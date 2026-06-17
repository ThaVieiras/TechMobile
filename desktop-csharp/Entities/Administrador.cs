using TechMobile.Desktop.Domain.Enums;

namespace TechMobile.Desktop.Domain.Entities
{
    /// <summary>
    /// Entidade que representa um usuário administrativo do Desktop.
    /// Mapeada para a tabela 'administradores'.
    /// </summary>
    public class Administrador
    {
        public int IdAdmin { get; set; }
        public string Nome { get; set; } = string.Empty;
        public string Email { get; set; } = string.Empty;
        public string SenhaHash { get; set; } = string.Empty;
        public PerfilAdmin Perfil { get; set; } = PerfilAdmin.Estoque;
        public bool Ativo { get; set; } = true;
        public DateTime DataCadastro { get; set; } = DateTime.Now;
    }
}
