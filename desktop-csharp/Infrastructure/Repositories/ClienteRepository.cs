using MySqlConnector;
using TechMobile.Desktop.Domain.Entities;

namespace TechMobile.Desktop.Infrastructure.Repositories
{
    /// <summary>
    /// Acesso ao banco para visualização e gestão de clientes.
    /// Clientes são criados exclusivamente pelo módulo Web.
    /// </summary>
    public class ClienteRepository
    {
        /// <summary>
        /// Lista todos os clientes com totais de pedidos.
        /// </summary>
        public List<Cliente> ListarTodos(string? busca = null)
        {
            var lista = new List<Cliente>();
            using var conn = DbConnection.GetConnection();

            var sql = @"SELECT c.id_cliente, c.nome, c.email, c.cpf,
                               c.telefone, c.endereco, c.data_cadastro, c.ativo,
                               COUNT(p.id_pedido)          AS total_pedidos,
                               COALESCE(SUM(p.valor_total), 0) AS total_gasto
                        FROM clientes c
                        LEFT JOIN pedidos p ON c.id_cliente = p.id_cliente
                        WHERE 1=1";

            if (!string.IsNullOrWhiteSpace(busca))
                sql += " AND (c.nome LIKE @busca OR c.email LIKE @busca)";

            sql += " GROUP BY c.id_cliente ORDER BY c.nome";

            var cmd = new MySqlCommand(sql, conn);
            if (!string.IsNullOrWhiteSpace(busca))
                cmd.Parameters.AddWithValue("@busca", $"%{busca}%");

            using var reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                lista.Add(new Cliente
                {
                    IdCliente     = reader.GetInt32("id_cliente"),
                    Nome          = reader.GetString("nome"),
                    Email         = reader.GetString("email"),
                    Cpf           = reader.IsDBNull(reader.GetOrdinal("cpf")) ? "" : reader.GetString("cpf"),
                    Telefone      = reader.IsDBNull(reader.GetOrdinal("telefone")) ? "" : reader.GetString("telefone"),
                    Endereco      = reader.IsDBNull(reader.GetOrdinal("endereco")) ? "" : reader.GetString("endereco"),
                    DataCadastro  = reader.GetDateTime("data_cadastro"),
                    Ativo         = reader.GetBoolean("ativo"),
                    TotalPedidos  = reader.GetInt32("total_pedidos"),
                    TotalGasto    = reader.GetDecimal("total_gasto")
                });
            }
            return lista;
        }

        /// <summary>
        /// Desativa um cliente (exclusão lógica — RN-D).
        /// </summary>
        public void Desativar(int idCliente)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                "UPDATE clientes SET ativo = 0 WHERE id_cliente = @id", conn);
            cmd.Parameters.AddWithValue("@id", idCliente);
            cmd.ExecuteNonQuery();
        }

        /// <summary>
        /// Conta total de clientes ativos para o Dashboard.
        /// </summary>
        public int ContarAtivos()
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                "SELECT COUNT(*) FROM clientes WHERE ativo = 1", conn);
            return Convert.ToInt32(cmd.ExecuteScalar());
        }
    }
}
