using TechMobile.Desktop.Application.Services;
using TechMobile.Desktop.Infrastructure.Repositories;

namespace TechMobile.Desktop.UI.Forms
{
    /// <summary>
    /// Dashboard — painel inicial com indicadores do dia.
    /// Exibe: pedidos do dia, total de vendas, pedidos pendentes e estoque baixo.
    /// </summary>
    public class UCDashboard : UserControl
    {
        private TableLayoutPanel _grid;
        private Label lblPedidosHoje, lblVendasHoje, lblPendentes, lblEstoqueBaixo;

        private readonly PedidoService _pedidoSvc = new();
        private readonly EstoqueService _estoqueSvc = new();
        private readonly ClienteRepository _clienteRepo = new();

        public UCDashboard()
        {
            InitializeComponent();
            CarregarDados();
        }

        private void InitializeComponent()
        {
            Dock = DockStyle.Fill;
            BackColor = Color.FromArgb(245, 246, 250);
            Padding = new Padding(10);

            var lblTitulo = new Label
            {
                Text = $"Bem-vindo, {AuthService.AdminLogado?.Nome?.Split(' ')[0]}!",
                Font = new Font("Arial", 18, FontStyle.Bold),
                ForeColor = Color.FromArgb(61, 0, 102),
                AutoSize = true,
                Location = new Point(0, 10)
            };

            var lblSubtitulo = new Label
            {
                Text = $"Hoje é {DateTime.Now:dddd, dd 'de' MMMM 'de' yyyy}",
                Font = new Font("Arial", 10),
                ForeColor = Color.Gray,
                AutoSize = true,
                Location = new Point(0, 42)
            };

            // Grid de cards 2x2
            _grid = new TableLayoutPanel
            {
                Location = new Point(0, 90),
                Size = new Size(900, 260),
                RowCount = 2,
                ColumnCount = 2,
                CellBorderStyle = TableLayoutPanelCellBorderStyle.None
            };
            _grid.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 50));
            _grid.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 50));
            _grid.RowStyles.Add(new RowStyle(SizeType.Percent, 50));
            _grid.RowStyles.Add(new RowStyle(SizeType.Percent, 50));

            lblPedidosHoje  = CriarCard("Pedidos Hoje",    "—", Color.FromArgb(61, 0, 102));
            lblVendasHoje   = CriarCard("Vendas Hoje",     "—", Color.FromArgb(16, 120, 60));
            lblPendentes    = CriarCard("Pedidos Pendentes","—", Color.FromArgb(180, 80, 0));
            lblEstoqueBaixo = CriarCard("Estoque Baixo",   "—", Color.FromArgb(160, 0, 0));

            _grid.Controls.Add(lblPedidosHoje.Parent,  0, 0);
            _grid.Controls.Add(lblVendasHoje.Parent,   1, 0);
            _grid.Controls.Add(lblPendentes.Parent,    0, 1);
            _grid.Controls.Add(lblEstoqueBaixo.Parent, 1, 1);

            Controls.AddRange(new Control[] { lblTitulo, lblSubtitulo, _grid });
        }

        private static Label CriarCard(string titulo, string valor, Color cor)
        {
            var pnl = new Panel
            {
                Dock = DockStyle.Fill,
                BackColor = Color.White,
                Margin = new Padding(8),
                Padding = new Padding(25)
            };
            // Borda colorida no topo
            pnl.Paint += (s, e) =>
                e.Graphics.FillRectangle(new SolidBrush(cor), 0, 0, pnl.Width, 6);

            var lblTitulo = new Label
            {
                Text = titulo,
                Font = new Font("Arial", 10),
                ForeColor = Color.Gray,
                AutoSize = true,
                Location = new Point(25, 30)
            };

            var lblValor = new Label
            {
                Text = valor,
                Font = new Font("Arial", 32, FontStyle.Bold),
                ForeColor = cor,
                AutoSize = true,
                Location = new Point(25, 55)
            };

            pnl.Controls.AddRange(new Control[] { lblTitulo, lblValor });
            return lblValor;
        }

        private void CarregarDados()
        {
            try
            {
                var (totalHoje, vendasHoje, pendentes) = _pedidoSvc.ObterEstatisticas();
                int estoqueBaixo = _estoqueSvc.ContarEstoqueBaixo();

                lblPedidosHoje.Text  = totalHoje.ToString();
                lblVendasHoje.Text   = $"R$ {vendasHoje:N2}";
                lblPendentes.Text    = pendentes.ToString();
                lblEstoqueBaixo.Text = estoqueBaixo.ToString();
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao carregar dados do dashboard:\n{ex.Message}",
                    "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
