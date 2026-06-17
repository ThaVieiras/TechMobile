using MySqlConnector;
using TechMobile.Desktop.Domain.Entities;
using TechMobile.Desktop.Domain.Enums;

namespace TechMobile.Desktop.Infrastructure.Repositories
{
    /// <summary>
    /// Acesso ao banco para operações com pedidos.
    /// </summary>
    public class PedidoRepository
    {
        /// <summary>
        /// Lista pedidos com filtro opcional por status e período.
        /// </summary>
        public List<Pedido> ListarTodos(int? idStatus = null, DateTime? de = null, DateTime? ate = null)
        {
            var lista = new List<Pedido>();
            using var conn = DbConnection.GetConnection();

            var sql = @"SELECT p.id_pedido, p.id_cliente, p.id_status, p.data_pedido,
                               p.valor_total, p.observacao, p.atualizado_em,
                               p.id_admin_ultimo_update,
                               c.nome AS nome_cliente,
                               s.nome_status
                        FROM pedidos p
                        INNER JOIN clientes c ON p.id_cliente = c.id_cliente
                        INNER JOIN status_pedido s ON p.id_status = s.id_status
                        WHERE 1=1";

            if (idStatus.HasValue) sql += " AND p.id_status = @status";
            if (de.HasValue)       sql += " AND p.data_pedido >= @de";
            if (ate.HasValue)      sql += " AND p.data_pedido <= @ate";
            sql += " ORDER BY p.data_pedido DESC";

            var cmd = new MySqlCommand(sql, conn);
            if (idStatus.HasValue) cmd.Parameters.AddWithValue("@status", idStatus.Value);
            if (de.HasValue)       cmd.Parameters.AddWithValue("@de", de.Value.Date);
            if (ate.HasValue)      cmd.Parameters.AddWithValue("@ate", ate.Value.Date.AddDays(1));

            using var reader = cmd.ExecuteReader();
            while (reader.Read())
                lista.Add(MapPedido(reader));

            return lista;
        }

        /// <summary>
        /// Busca um pedido com todos os itens.
        /// </summary>
        public Pedido? BuscarComItens(int idPedido)
        {
            using var conn = DbConnection.GetConnection();

            // Pedido
            var cmdP = new MySqlCommand(
                @"SELECT p.*, c.nome AS nome_cliente, s.nome_status
                  FROM pedidos p
                  INNER JOIN clientes c ON p.id_cliente = c.id_cliente
                  INNER JOIN status_pedido s ON p.id_status = s.id_status
                  WHERE p.id_pedido = @id", conn);
            cmdP.Parameters.AddWithValue("@id", idPedido);

            Pedido? pedido = null;
            using (var r = cmdP.ExecuteReader())
            {
                if (r.Read()) pedido = MapPedido(r);
            }
            if (pedido == null) return null;

            // Itens
            var cmdI = new MySqlCommand(
                @"SELECT i.*, pr.nome AS nome_produto, pr.imagem_url
                  FROM itens_pedidos i
                  INNER JOIN produtos pr ON i.id_produto = pr.id_produto
                  WHERE i.id_pedido = @id", conn);
            cmdI.Parameters.AddWithValue("@id", idPedido);

            using var ri = cmdI.ExecuteReader();
            while (ri.Read())
            {
                pedido.Itens.Add(new ItensPedido
                {
                    IdItem         = ri.GetInt32("id_item"),
                    IdPedido       = idPedido,
                    IdProduto      = ri.GetInt32("id_produto"),
                    Quantidade     = ri.GetInt32("quantidade"),
                    PrecoUnitario  = ri.GetDecimal("preco_unitario"),
                    Subtotal       = ri.GetDecimal("subtotal"),
                    NomeProduto    = ri.GetString("nome_produto"),
                    ImagemUrl      = ri.IsDBNull(ri.GetOrdinal("imagem_url")) ? "" : ri.GetString("imagem_url")
                });
            }
            return pedido;
        }

        /// <summary>
        /// Atualiza o status de um pedido registrando o admin responsável (RN-D04).
        /// </summary>
        public void AtualizarStatus(int idPedido, StatusPedido novoStatus, int idAdmin)
        {
            using var conn = DbConnection.GetConnection();
            using var tr = conn.BeginTransaction();
            try
            {
                var cmd = new MySqlCommand(
                    @"UPDATE pedidos
                      SET id_status = @status,
                          id_admin_ultimo_update = @admin,
                          atualizado_em = NOW()
                      WHERE id_pedido = @id", conn, tr);
                cmd.Parameters.AddWithValue("@status", (int)novoStatus);
                cmd.Parameters.AddWithValue("@admin",  idAdmin);
                cmd.Parameters.AddWithValue("@id",     idPedido);
                cmd.ExecuteNonQuery();

                // Se cancelado, restaura estoque (RN-D05)
                if (novoStatus == StatusPedido.Cancelado)
                    RestaurarEstoque(idPedido, conn, tr);

                tr.Commit();
            }
            catch
            {
                tr.Rollback();
                throw;
            }
        }

        private static void RestaurarEstoque(int idPedido, MySqlConnection conn, MySqlTransaction tr)
        {
            var cmdItens = new MySqlCommand(
                "SELECT id_produto, quantidade FROM itens_pedidos WHERE id_pedido = @id",
                conn, tr);
            cmdItens.Parameters.AddWithValue("@id", idPedido);

            var itens = new List<(int id, int qtd)>();
            using (var r = cmdItens.ExecuteReader())
                while (r.Read())
                    itens.Add((r.GetInt32(0), r.GetInt32(1)));

            foreach (var (id, qtd) in itens)
            {
                var cmdEst = new MySqlCommand(
                    "UPDATE estoque SET quantidade_atual = quantidade_atual + @qtd, " +
                    "atualizado_em = NOW() WHERE id_produto = @id", conn, tr);
                cmdEst.Parameters.AddWithValue("@qtd", qtd);
                cmdEst.Parameters.AddWithValue("@id",  id);
                cmdEst.ExecuteNonQuery();
            }
        }

        /// <summary>
        /// Estatísticas para o Dashboard.
        /// </summary>
        public (int totalHoje, decimal vendasHoje, int pendentes) ObterEstatisticas()
        {
            using var conn = DbConnection.GetConnection();

            var cmd1 = new MySqlCommand(
                "SELECT COUNT(*), COALESCE(SUM(valor_total),0) FROM pedidos " +
                "WHERE DATE(data_pedido) = CURDATE()", conn);
            using var r1 = cmd1.ExecuteReader();
            r1.Read();
            int totalHoje = r1.GetInt32(0);
            decimal vendasHoje = r1.GetDecimal(1);
            r1.Close();

            var cmd2 = new MySqlCommand(
                "SELECT COUNT(*) FROM pedidos WHERE id_status IN (1,2)", conn);
            int pendentes = Convert.ToInt32(cmd2.ExecuteScalar());

            return (totalHoje, vendasHoje, pendentes);
        }

        private static Pedido MapPedido(MySqlDataReader r) => new()
        {
            IdPedido              = r.GetInt32("id_pedido"),
            IdCliente             = r.GetInt32("id_cliente"),
            IdStatus              = r.GetInt32("id_status"),
            DataPedido            = r.GetDateTime("data_pedido"),
            ValorTotal            = r.GetDecimal("valor_total"),
            Observacao            = r.IsDBNull(r.GetOrdinal("observacao")) ? "" : r.GetString("observacao"),
            AtualizadoEm          = r.IsDBNull(r.GetOrdinal("atualizado_em")) ? null : r.GetDateTime("atualizado_em"),
            IdAdminUltimoUpdate   = r.IsDBNull(r.GetOrdinal("id_admin_ultimo_update")) ? null : r.GetInt32("id_admin_ultimo_update"),
            NomeCliente           = r.GetString("nome_cliente"),
            NomeStatus            = r.GetString("nome_status")
        };
    }
}
