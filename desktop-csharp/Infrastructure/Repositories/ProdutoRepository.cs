using MySqlConnector;
using TechMobile.Desktop.Domain.Entities;

namespace TechMobile.Desktop.Infrastructure.Repositories
{
    /// <summary>
    /// Acesso ao banco para operações com produtos.
    /// </summary>
    public class ProdutoRepository
    {
        /// <summary>
        /// Lista todos os produtos com saldo de estoque via LEFT JOIN.
        /// </summary>
        public List<Produto> ListarTodos(string? busca = null, string? categoria = null)
        {
            var lista = new List<Produto>();
            using var conn = DbConnection.GetConnection();

            var sql = @"SELECT p.*, COALESCE(e.quantidade_atual, 0) AS quantidade_estoque
                        FROM produtos p
                        LEFT JOIN estoque e ON p.id_produto = e.id_produto
                        WHERE 1=1";

            if (!string.IsNullOrWhiteSpace(busca))
                sql += " AND (p.nome LIKE @busca OR p.marca LIKE @busca)";
            if (!string.IsNullOrWhiteSpace(categoria))
                sql += " AND p.categoria = @categoria";

            sql += " ORDER BY p.nome";

            var cmd = new MySqlCommand(sql, conn);
            if (!string.IsNullOrWhiteSpace(busca))
                cmd.Parameters.AddWithValue("@busca", $"%{busca}%");
            if (!string.IsNullOrWhiteSpace(categoria))
                cmd.Parameters.AddWithValue("@categoria", categoria);

            using var reader = cmd.ExecuteReader();
            while (reader.Read())
                lista.Add(MapProduto(reader));

            return lista;
        }

        /// <summary>
        /// Busca um produto pelo ID.
        /// </summary>
        public Produto? BuscarPorId(int id)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                @"SELECT p.*, COALESCE(e.quantidade_atual, 0) AS quantidade_estoque
                  FROM produtos p
                  LEFT JOIN estoque e ON p.id_produto = e.id_produto
                  WHERE p.id_produto = @id", conn);
            cmd.Parameters.AddWithValue("@id", id);

            using var reader = cmd.ExecuteReader();
            return reader.Read() ? MapProduto(reader) : null;
        }

        /// <summary>
        /// Insere um novo produto e cria registro inicial de estoque.
        /// </summary>
        public int Inserir(Produto p, int estoqueInicial = 0)
        {
            using var conn = DbConnection.GetConnection();
            using var tr = conn.BeginTransaction();
            try
            {
                var cmd = new MySqlCommand(
                    @"INSERT INTO produtos (nome, marca, modelo, categoria, descricao, preco,
                        imagem_url, ativo, mais_vendido)
                      VALUES (@nome,@marca,@modelo,@cat,@desc,@preco,@img,@ativo,@mv)",
                    conn, tr);

                cmd.Parameters.AddWithValue("@nome",  p.Nome);
                cmd.Parameters.AddWithValue("@marca", p.Marca);
                cmd.Parameters.AddWithValue("@modelo",p.Modelo);
                cmd.Parameters.AddWithValue("@cat",   p.Categoria);
                cmd.Parameters.AddWithValue("@desc",  p.Descricao);
                cmd.Parameters.AddWithValue("@preco", p.Preco);
                cmd.Parameters.AddWithValue("@img",   p.ImagemUrl);
                cmd.Parameters.AddWithValue("@ativo", p.Ativo ? 1 : 0);
                cmd.Parameters.AddWithValue("@mv",    p.MaisVendido ? 1 : 0);
                cmd.ExecuteNonQuery();

                // Obtém o ID gerado
                var idCmd = new MySqlCommand("SELECT LAST_INSERT_ID()", conn, tr);
                int novoId = Convert.ToInt32(idCmd.ExecuteScalar());

                // Cria registro de estoque
                var estCmd = new MySqlCommand(
                    "INSERT INTO estoque (id_produto, quantidade_atual, atualizado_em) " +
                    "VALUES (@id, @qtd, NOW())", conn, tr);
                estCmd.Parameters.AddWithValue("@id",  novoId);
                estCmd.Parameters.AddWithValue("@qtd", estoqueInicial);
                estCmd.ExecuteNonQuery();

                tr.Commit();
                return novoId;
            }
            catch
            {
                tr.Rollback();
                throw;
            }
        }

        /// <summary>
        /// Atualiza os dados de um produto existente.
        /// </summary>
        public void Atualizar(Produto p)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                @"UPDATE produtos SET nome=@nome, marca=@marca, modelo=@modelo,
                    categoria=@cat, descricao=@desc, preco=@preco,
                    imagem_url=@img, ativo=@ativo, mais_vendido=@mv
                  WHERE id_produto=@id", conn);

            cmd.Parameters.AddWithValue("@nome",  p.Nome);
            cmd.Parameters.AddWithValue("@marca", p.Marca);
            cmd.Parameters.AddWithValue("@modelo",p.Modelo);
            cmd.Parameters.AddWithValue("@cat",   p.Categoria);
            cmd.Parameters.AddWithValue("@desc",  p.Descricao);
            cmd.Parameters.AddWithValue("@preco", p.Preco);
            cmd.Parameters.AddWithValue("@img",   p.ImagemUrl);
            cmd.Parameters.AddWithValue("@ativo", p.Ativo ? 1 : 0);
            cmd.Parameters.AddWithValue("@mv",    p.MaisVendido ? 1 : 0);
            cmd.Parameters.AddWithValue("@id",    p.IdProduto);
            cmd.ExecuteNonQuery();
        }

        /// <summary>
        /// Desativa um produto (exclusão lógica — RN: não pode excluir com pedidos).
        /// </summary>
        public void Desativar(int id)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                "UPDATE produtos SET ativo = 0 WHERE id_produto = @id", conn);
            cmd.Parameters.AddWithValue("@id", id);
            cmd.ExecuteNonQuery();
        }

        /// <summary>
        /// Verifica se o produto possui itens de pedido vinculados.
        /// </summary>
        public bool PossuiPedidos(int id)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                "SELECT COUNT(*) FROM itens_pedidos WHERE id_produto = @id", conn);
            cmd.Parameters.AddWithValue("@id", id);
            return Convert.ToInt32(cmd.ExecuteScalar()) > 0;
        }

        private static Produto MapProduto(MySqlDataReader r) => new()
        {
            IdProduto         = r.GetInt32("id_produto"),
            Nome              = r.GetString("nome"),
            Marca             = r.GetString("marca"),
            Modelo            = r.IsDBNull(r.GetOrdinal("modelo")) ? "" : r.GetString("modelo"),
            Categoria         = r.GetString("categoria"),
            Descricao         = r.IsDBNull(r.GetOrdinal("descricao")) ? "" : r.GetString("descricao"),
            Preco             = r.GetDecimal("preco"),
            ImagemUrl         = r.IsDBNull(r.GetOrdinal("imagem_url")) ? "" : r.GetString("imagem_url"),
            Ativo             = r.GetBoolean("ativo"),
            MaisVendido       = r.GetBoolean("mais_vendido"),
            QuantidadeEstoque = r.GetInt32("quantidade_estoque")
        };
    }
}
