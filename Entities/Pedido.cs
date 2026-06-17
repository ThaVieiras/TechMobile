namespace TechMobile.Desktop.Domain.Entities
{
    /// <summary>
    /// Entidade que representa um pedido realizado no Web.
    /// Mapeada para a tabela 'pedidos'.
    /// </summary>
    public class Pedido
    {
        public int IdPedido { get; set; }
        public int IdCliente { get; set; }
        public int IdStatus { get; set; }
        public DateTime DataPedido { get; set; }
        public decimal ValorTotal { get; set; }
        public string Observacao { get; set; } = string.Empty;
        public DateTime? AtualizadoEm { get; set; }
        public int? IdAdminUltimoUpdate { get; set; }

        // Dados de JOIN para exibição
        public string NomeCliente { get; set; } = string.Empty;
        public string NomeStatus { get; set; } = string.Empty;

        // Itens carregados sob demanda
        public List<ItensPedido> Itens { get; set; } = new();
    }
}
