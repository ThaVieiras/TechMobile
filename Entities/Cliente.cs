namespace TechMobile.Desktop.Domain.Entities
{
    /// <summary>
    /// Entidade que representa um cliente cadastrado no Web.
    /// Mapeada para a tabela 'clientes' — somente leitura/desativação no Desktop.
    /// </summary>
    public class Cliente
    {
        public int IdCliente { get; set; }
        public string Nome { get; set; } = string.Empty;
        public string Email { get; set; } = string.Empty;
        public string Cpf { get; set; } = string.Empty;
        public string Telefone { get; set; } = string.Empty;
        public string Endereco { get; set; } = string.Empty;
        public DateTime DataCadastro { get; set; }
        public bool Ativo { get; set; } = true;

        // Derivado — total de pedidos do cliente
        public int TotalPedidos { get; set; }
        public decimal TotalGasto { get; set; }
    }
}
