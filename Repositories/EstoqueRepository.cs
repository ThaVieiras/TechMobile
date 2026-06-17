using MySqlConnector;
using TechMobile.Desktop.Domain.Entities;

namespace TechMobile.Desktop.Infrastructure.Repositories
{
    /// <summary>
    /// Acesso ao banco para operações de estoque.
    /// </summary>
    public class EstoqueRepository
    {
        /// <summary>
        /// Lista todos os produtos com saldo de estoque, com alerta para baixo estoque.
        /// </summary>
        public List<Estoque> ListarTodos(string? busca = null)
        {
            var lista = new List<Estoque>();
            using var conn = DbConnection.GetConnection();

            var sql = @"SELECT e.id_produto, e.quantidade_atual, e.atualizado_em,
                               p.nome AS nome_produto, p.marca, p.categoria
                        FROM estoque e
                        INNER JOIN produtos p ON e.id_produto = p.id_produto
                        WHERE p.ativo = 1";

            if (!string.IsNullOrWhiteSpace(busca))
                sql += " AND p.nome LIKE @busca";

            sql += " ORDER BY p.nome";

            var cmd = new MySqlCommand(sql, conn);
            if (!string.IsNullOrWhiteSpace(busca))
                cmd.Parameters.AddWithValue("@busca", $"%{busca}%");

            using var reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                lista.Add(new Estoque
                {
                    IdProduto       = reader.GetInt32("id_produto"),
                    QuantidadeAtual = reader.GetInt32("quantidade_atual"),
                    AtualizadoEm    = reader.GetDateTime("atualizado_em"),
                    NomeProduto     = reader.GetString("nome_produto"),
                    Marca           = reader.GetString("marca"),
                    Categoria       = reader.GetString("categoria")
                });
            }
            return lista;
        }

        /// <summary>
        /// Ajusta o saldo de um produto (entrada manual).
        /// </summary>
        public void AjustarQuantidade(int idProduto, int novaQuantidade)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                @"INSERT INTO estoque (id_produto, quantidade_atual, atualizado_em)
                  VALUES (@id, @qtd, NOW())
                  ON DUPLICATE KEY UPDATE quantidade_atual = @qtd, atualizado_em = NOW()", conn);
            cmd.Parameters.AddWithValue("@id",  idProduto);
            cmd.Parameters.AddWithValue("@qtd", novaQuantidade);
            cmd.ExecuteNonQuery();
        }

        /// <summary>
        /// Retorna o saldo atual de um produto específico.
        /// </summary>
        public int ObterQuantidade(int idProduto)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                "SELECT COALESCE(quantidade_atual, 0) FROM estoque WHERE id_produto = @id", conn);
            cmd.Parameters.AddWithValue("@id", idProduto);
            var result = cmd.ExecuteScalar();
            return result == null ? 0 : Convert.ToInt32(result);
        }

        /// <summary>
        /// Conta produtos com estoque baixo (abaixo do limite informado).
        /// </summary>
        public int ContarEstoqueBaixo(int limite = 5)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                "SELECT COUNT(*) FROM estoque e " +
                "INNER JOIN produtos p ON e.id_produto = p.id_produto " +
                "WHERE p.ativo = 1 AND e.quantidade_atual < @limite", conn);
            cmd.Parameters.AddWithValue("@limite", limite);
            return Convert.ToInt32(cmd.ExecuteScalar());
        }
    }
}
