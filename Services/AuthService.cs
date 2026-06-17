using TechMobile.Desktop.Domain.Entities;
using TechMobile.Desktop.Infrastructure.Repositories;

namespace TechMobile.Desktop.Application.Services
{
    /// <summary>
    /// Serviço de autenticação de administradores.
    /// Valida senha usando BCrypt compatível com password_hash do PHP.
    /// </summary>
    public class AuthService
    {
        private readonly AdminRepository _repo = new();

        // Administrador logado na sessão atual da aplicação
        public static Administrador? AdminLogado { get; private set; }

        /// <summary>
        /// Tenta autenticar um administrador pelo e-mail e senha.
        /// Retorna true se bem-sucedido.
        /// </summary>
        public bool Login(string email, string senha)
        {
            var admin = _repo.BuscarPorEmail(email);
            if (admin == null) return false;

            // BCrypt.Net verifica hash gerado pelo PHP password_hash
            bool senhaOk = BCrypt.Net.BCrypt.Verify(senha, admin.SenhaHash);
            if (!senhaOk) return false;

            AdminLogado = admin;
            return true;
        }

        /// <summary>
        /// Encerra a sessão administrativa.
        /// </summary>
        public static void Logout()
        {
            AdminLogado = null;
        }

        /// <summary>
        /// Gera hash compatível com PHP password_hash para novos admins.
        /// </summary>
        public static string GerarHash(string senha)
        {
            return BCrypt.Net.BCrypt.HashPassword(senha);
        }
    }
}
