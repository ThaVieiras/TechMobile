namespace TechMobile.Desktop.Domain.Entities
{
    /// <summary>
    /// Item de um pedido — mapeado para 'itens_pedidos'.
    /// Preço congelado no momento da compra.
    /// </summary>
    public class ItensPedido
    {
        public int IdItem { get; set; }
        public int IdPedido { get; set; }
        public int IdProduto { get; set; }
        public int Quantidade { get; set; }
        public decimal PrecoUnitario { get; set; }
        public decimal Subtotal { get; set; }

        // Dados de JOIN
        public string NomeProduto { get; set; } = string.Empty;
        public string ImagemUrl { get; set; } = string.Empty;
    }

    /// <summary>
    /// Saldo de estoque de um produto — mapeado para 'estoque'.
    /// </summary>
    public class Estoque
    {
        public int IdProduto { get; set; }
        public int QuantidadeAtual { get; set; }
        public DateTime AtualizadoEm { get; set; }

        // Dados de JOIN para exibição
        public string NomeProduto { get; set; } = string.Empty;
        public string Marca { get; set; } = string.Empty;
        public string Categoria { get; set; } = string.Empty;
    }
}
