namespace TechMobile.Desktop.Domain.Enums
{
    /// <summary>
    /// Perfis de acesso dos administradores (RBAC).
    /// </summary>
    public enum PerfilAdmin
    {
        Admin = 1,
        Estoque = 2,
        Financeiro = 3
    }

    /// <summary>
    /// Status possíveis de um pedido.
    /// Deve corresponder aos registros da tabela status_pedido.
    /// </summary>
    public enum StatusPedido
    {
        Novo = 1,
        EmProcessamento = 2,
        Enviado = 3,
        Entregue = 4,
        Cancelado = 5
    }

    /// <summary>
    /// Categorias de produto aceitas pelo sistema.
    /// </summary>
    public static class CategoriaProduto
    {
        public const string Smartphone = "smartphone";
        public const string Acessorios = "acessorios";
        public const string Recondicionado = "recondicionado";
        public const string Oferta = "oferta";

        public static readonly string[] Todas = { Smartphone, Acessorios, Recondicionado, Oferta };
    }
}
