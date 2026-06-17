using MySqlConnector;
using TechMobile.Desktop.Domain.Entities;
using TechMobile.Desktop.Domain.Enums;

namespace TechMobile.Desktop.Infrastructure.Repositories
{
    /// <summary>
    /// Acesso ao banco para operações com administradores.
    /// </summary>
    public class AdminRepository
    {
        /// <summary>
        /// Busca um administrador pelo e-mail. Retorna null se não encontrado.
        /// </summary>
        public Administrador? BuscarPorEmail(string email)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                "SELECT id_admin, nome, email, senha_hash, perfil, ativo " +
                "FROM administradores WHERE email = @email AND ativo = 1", conn);
            cmd.Parameters.AddWithValue("@email", email);

            using var reader = cmd.ExecuteReader();
            if (!reader.Read()) return null;

            return MapAdmin(reader);
        }

        /// <summary>
        /// Lista todos os administradores ativos.
        /// </summary>
        public List<Administrador> ListarTodos()
        {
            var lista = new List<Administrador>();
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                "SELECT id_admin, nome, email, senha_hash, perfil, ativo " +
                "FROM administradores ORDER BY nome", conn);

            using var reader = cmd.ExecuteReader();
            while (reader.Read())
                lista.Add(MapAdmin(reader));

            return lista;
        }

        /// <summary>
        /// Insere um novo administrador.
        /// </summary>
        public void Inserir(Administrador admin)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                "INSERT INTO administradores (nome, email, senha_hash, perfil, ativo) " +
                "VALUES (@nome, @email, @hash, @perfil, 1)", conn);

            cmd.Parameters.AddWithValue("@nome", admin.Nome);
            cmd.Parameters.AddWithValue("@email", admin.Email);
            cmd.Parameters.AddWithValue("@hash", admin.SenhaHash);
            cmd.Parameters.AddWithValue("@perfil", admin.Perfil.ToString());
            cmd.ExecuteNonQuery();
        }

        /// <summary>
        /// Desativa um administrador (exclusão lógica).
        /// </summary>
        public void Desativar(int idAdmin)
        {
            using var conn = DbConnection.GetConnection();
            var cmd = new MySqlCommand(
                "UPDATE administradores SET ativo = 0 WHERE id_admin = @id", conn);
            cmd.Parameters.AddWithValue("@id", idAdmin);
            cmd.ExecuteNonQuery();
        }

        private static Administrador MapAdmin(MySqlDataReader r) => new()
        {
            IdAdmin    = r.GetInt32("id_admin"),
            Nome       = r.GetString("nome"),
            Email      = r.GetString("email"),
            SenhaHash  = r.GetString("senha_hash"),
            Perfil     = Enum.TryParse<PerfilAdmin>(r.GetString("perfil"), out var p) ? p : PerfilAdmin.Estoque,
            Ativo      = r.GetBoolean("ativo")
        };
    }
}
