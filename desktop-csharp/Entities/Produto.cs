namespace TechMobile.Desktop.Domain.Entities
{
    /// <summary>
    /// Entidade que representa um produto do catálogo TechMobile.
    /// Mapeada para a tabela 'produtos' no banco MySQL compartilhado com o Web.
    /// </summary>
    public class Produto
    {
        public int IdProduto { get; set; }
        public string Nome { get; set; } = string.Empty;
        public string Marca { get; set; } = string.Empty;
        public string Modelo { get; set; } = string.Empty;
        public string Categoria { get; set; } = string.Empty;
        public string Descricao { get; set; } = string.Empty;
        public decimal Preco { get; set; }
        public string ImagemUrl { get; set; } = string.Empty;
        public bool Ativo { get; set; } = true;
        public bool MaisVendido { get; set; } = false;
        public DateTime DataCadastro { get; set; } = DateTime.Now;

        // Estoque relacionado (carregado via JOIN)
        public int QuantidadeEstoque { get; set; }
    }
}
