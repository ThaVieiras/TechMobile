using TechMobile.Desktop.Domain.Entities;
using TechMobile.Desktop.Domain.Enums;
using TechMobile.Desktop.Infrastructure.Repositories;
using System.Text;

namespace TechMobile.Desktop.Application.Services
{
    /// <summary>
    /// Regras de negócio para pedidos.
    /// </summary>
    public class PedidoService
    {
        private readonly PedidoRepository _repo = new();

        public List<Pedido> Listar(int? status = null, DateTime? de = null, DateTime? ate = null)
            => _repo.ListarTodos(status, de, ate);

        public Pedido? BuscarComItens(int id) => _repo.BuscarComItens(id);

        public (int totalHoje, decimal vendasHoje, int pendentes) ObterEstatisticas()
            => _repo.ObterEstatisticas();

        /// <summary>
        /// Atualiza status com validação do fluxo (RN-D04).
        /// </summary>
        public void AtualizarStatus(int idPedido, StatusPedido novoStatus, int idAdmin)
        {
            var pedido = _repo.BuscarComItens(idPedido)
                ?? throw new InvalidOperationException("Pedido não encontrado.");

            var statusAtual = (StatusPedido)pedido.IdStatus;

            // Valida fluxo: não pode retroceder (exceto Cancelado)
            if (novoStatus != StatusPedido.Cancelado && (int)novoStatus < (int)statusAtual)
                throw new InvalidOperationException(
                    $"Não é possível retroceder o status de '{pedido.NomeStatus}' " +
                    $"para '{novoStatus}'.");

            if (statusAtual == StatusPedido.Entregue)
                throw new InvalidOperationException("Pedido já entregue não pode ser alterado.");

            _repo.AtualizarStatus(idPedido, novoStatus, idAdmin);
        }
    }

    /// <summary>
    /// Geração de relatórios de vendas e exportação CSV.
    /// </summary>
    public class RelatorioService
    {
        private readonly PedidoRepository _pedidoRepo = new();
        private readonly ClienteRepository _clienteRepo = new();

        /// <summary>
        /// Relatório de vendas por período. Retorna lista de pedidos e totalizadores.
        /// </summary>
        public (List<Pedido> pedidos, decimal totalVendas, int qtdPedidos, decimal ticketMedio)
            GerarRelatorioVendas(DateTime de, DateTime ate)
        {
            var pedidos = _pedidoRepo.ListarTodos(null, de, ate)
                .Where(p => p.IdStatus != (int)StatusPedido.Cancelado)
                .ToList();

            decimal total = pedidos.Sum(p => p.ValorTotal);
            int qtd = pedidos.Count;
            decimal ticket = qtd > 0 ? total / qtd : 0;

            return (pedidos, total, qtd, ticket);
        }

        /// <summary>
        /// Exporta os dados do relatório para CSV (RN-D09).
        /// </summary>
        public string ExportarCsv(List<Pedido> pedidos, string caminho)
        {
            var sb = new StringBuilder();
            sb.AppendLine("ID Pedido;Data;Cliente;Status;Total");

            foreach (var p in pedidos)
            {
                sb.AppendLine(
                    $"{p.IdPedido};" +
                    $"{p.DataPedido:dd/MM/yyyy HH:mm};" +
                    $"{p.NomeCliente};" +
                    $"{p.NomeStatus};" +
                    $"{p.ValorTotal:F2}");
            }

            File.WriteAllText(caminho, sb.ToString(), Encoding.UTF8);
            return caminho;
        }
    }
}
