using MySqlConnector;

namespace TechMobile.Desktop.Infrastructure
{
    /// <summary>
    /// Gerencia a string de conexão e fornece instâncias MySqlConnection.
    /// Aponta para o mesmo banco MySQL utilizado pelo módulo Web (PHP).
    /// </summary>
    public static class DbConnection
    {
        // ── Ajuste Server/Database/Uid/Pwd conforme seu ambiente ──────────
        private const string ConnStr =
            "Server=localhost;" +
            "Port=3306;" +
            "Database=techmobile;" +
            "Uid=root;" +
            "Pwd=;" +
            "CharSet=utf8mb4;" +
            "ConnectionTimeout=30;";

        /// <summary>
        /// Retorna uma nova conexão aberta com o banco MySQL.
        /// O chamador é responsável por fechar/descartar (using).
        /// </summary>
        public static MySqlConnection GetConnection()
        {
            var conn = new MySqlConnection(ConnStr);
            conn.Open();
            return conn;
        }

        /// <summary>
        /// Testa a conexão ao banco. Retorna true se bem-sucedido.
        /// </summary>
        public static bool TestarConexao()
        {
            try
            {
                using var conn = GetConnection();
                return conn.State == System.Data.ConnectionState.Open;
            }
            catch
            {
                return false;
            }
        }
    }
}
