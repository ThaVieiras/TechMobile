using TechMobile.Desktop.Domain.Entities;
using TechMobile.Desktop.Infrastructure.Repositories;

namespace TechMobile.Desktop.Application.Services
{
    /// <summary>
    /// Regras de negócio para produtos.
    /// </summary>
    public class ProdutoService
    {
        private readonly ProdutoRepository _repo = new();

        public List<Produto> Listar(string? busca = null, string? categoria = null)
            => _repo.ListarTodos(busca, categoria);

        public Produto? BuscarPorId(int id) => _repo.BuscarPorId(id);

        /// <summary>
        /// Salva produto novo ou atualiza existente. Retorna o ID.
        /// </summary>
        public int Salvar(Produto produto, int estoqueInicial = 0)
        {
            Validar(produto);

            if (produto.IdProduto == 0)
                return _repo.Inserir(produto, estoqueInicial);

            _repo.Atualizar(produto);
            return produto.IdProduto;
        }

        /// <summary>
        /// Desativa produto — lança exceção se tiver pedidos vinculados (RN-D06).
        /// </summary>
        public void Desativar(int id)
        {
            if (_repo.PossuiPedidos(id))
                throw new InvalidOperationException(
                    "Este produto possui pedidos vinculados e não pode ser excluído.\n" +
                    "Use a opção de desativar para removê-lo da loja.");

            _repo.Desativar(id);
        }

        private static void Validar(Produto p)
        {
            if (string.IsNullOrWhiteSpace(p.Nome))
                throw new ArgumentException("O nome do produto é obrigatório.");
            if (string.IsNullOrWhiteSpace(p.Marca))
                throw new ArgumentException("A marca é obrigatória.");
            if (p.Preco <= 0)
                throw new ArgumentException("O preço deve ser maior que zero.");
            if (string.IsNullOrWhiteSpace(p.Categoria))
                throw new ArgumentException("A categoria é obrigatória.");
        }
    }

    /// <summary>
    /// Regras de negócio para estoque.
    /// </summary>
    public class EstoqueService
    {
        private readonly EstoqueRepository _repo = new();

        public List<Estoque> Listar(string? busca = null) => _repo.ListarTodos(busca);

        public int ObterQuantidade(int idProduto) => _repo.ObterQuantidade(idProduto);

        public int ContarEstoqueBaixo() => _repo.ContarEstoqueBaixo();

        /// <summary>
        /// Ajusta o saldo de estoque (RN-D02: apenas Admin e Estoque).
        /// </summary>
        public void AjustarQuantidade(int idProduto, int novaQuantidade)
        {
            if (novaQuantidade < 0)
                throw new ArgumentException("A quantidade não pode ser negativa.");
            _repo.AjustarQuantidade(idProduto, novaQuantidade);
        }
    }
}
