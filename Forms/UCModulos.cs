using TechMobile.Desktop.Application.Services;
using TechMobile.Desktop.Domain.Entities;
using TechMobile.Desktop.Domain.Enums;

// ═══════════════════════════════════════════════════════════════════════════
// UCEstoque — Controle de Estoque (RF-D09, RF-D10 | UC12)
// ═══════════════════════════════════════════════════════════════════════════
namespace TechMobile.Desktop.UI.Forms
{
    public class UCEstoque : UserControl
    {
        private DataGridView dgv;
        private TextBox txtBusca;
        private Button btnAjustar, btnAtualizar;
        private Label lblContador;
        private readonly EstoqueService _svc = new();
        private List<Estoque> _itens = new();

        public UCEstoque()
        {
            InitializeComponent();
            Carregar();
        }

        private void InitializeComponent()
        {
            Dock = DockStyle.Fill;
            BackColor = Color.FromArgb(245, 246, 250);

            var lblTitulo = new Label
            {
                Text = "Controle de Estoque",
                Font = new Font("Arial", 16, FontStyle.Bold),
                ForeColor = Color.FromArgb(61, 0, 102),
                AutoSize = true, Location = new Point(0, 10)
            };

            var pnlBar = new Panel { Location = new Point(0, 50), Size = new Size(1000, 50), BackColor = Color.White };

            txtBusca = new TextBox
            {
                Location = new Point(10, 12), Size = new Size(260, 28),
                Font = new Font("Arial", 10), PlaceholderText = "🔍 Buscar produto..."
            };
            txtBusca.TextChanged += (s, e) => Carregar();

            btnAjustar = BotaoCor("✏ Ajustar Quantidade", Color.FromArgb(61, 0, 102), Color.White);
            btnAjustar.Location = new Point(290, 10);
            btnAjustar.Click += BtnAjustar_Click;

            btnAtualizar = BotaoCor("↺ Atualizar", Color.Gray, Color.White);
            btnAtualizar.Location = new Point(450, 10);
            btnAtualizar.Click += (s, e) => Carregar();

            pnlBar.Controls.AddRange(new Control[] { txtBusca, btnAjustar, btnAtualizar });

            dgv = CriarGrid();
            dgv.Location = new Point(0, 110);
            dgv.Size = new Size(1000, 500);

            dgv.Columns.AddRange(
                new DataGridViewTextBoxColumn { Name = "IdProduto",  HeaderText = "ID",        FillWeight = 5  },
                new DataGridViewTextBoxColumn { Name = "Nome",       HeaderText = "Produto",    FillWeight = 30 },
                new DataGridViewTextBoxColumn { Name = "Marca",      HeaderText = "Marca",      FillWeight = 15 },
                new DataGridViewTextBoxColumn { Name = "Categoria",  HeaderText = "Categoria",  FillWeight = 15 },
                new DataGridViewTextBoxColumn { Name = "Quantidade", HeaderText = "Qtd. Atual", FillWeight = 15 },
                new DataGridViewTextBoxColumn { Name = "Atualizado", HeaderText = "Atualizado", FillWeight = 20 }
            );

            lblContador = new Label { Text = "", Font = new Font("Arial", 9), ForeColor = Color.Gray, AutoSize = true, Location = new Point(0, 615) };

            Controls.AddRange(new Control[] { lblTitulo, pnlBar, dgv, lblContador });
        }

        private void Carregar()
        {
            try
            {
                string? busca = string.IsNullOrWhiteSpace(txtBusca.Text) ? null : txtBusca.Text;
                _itens = _svc.Listar(busca);
                dgv.Rows.Clear();

                foreach (var e in _itens)
                {
                    int row = dgv.Rows.Add(e.IdProduto, e.NomeProduto, e.Marca, e.Categoria,
                        e.QuantidadeAtual, e.AtualizadoEm.ToString("dd/MM/yyyy HH:mm"));

                    if (e.QuantidadeAtual < 5)
                    {
                        dgv.Rows[row].Cells["Quantidade"].Style.ForeColor = Color.Red;
                        dgv.Rows[row].Cells["Quantidade"].Style.Font = new Font("Arial", 9, FontStyle.Bold);
                    }
                }
                lblContador.Text = $"{_itens.Count} produto(s) | Estoque baixo: {_svc.ContarEstoqueBaixo()}";
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro: {ex.Message}", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void BtnAjustar_Click(object? sender, EventArgs e)
        {
            if (dgv.CurrentRow == null) { MessageBox.Show("Selecione um produto."); return; }

            int id   = Convert.ToInt32(dgv.CurrentRow.Cells["IdProduto"].Value);
            var item = _itens.First(i => i.IdProduto == id);

            string input = Microsoft.VisualBasic.Interaction.InputBox(
                $"Produto: {item.NomeProduto}\nSaldo atual: {item.QuantidadeAtual}\n\nNova quantidade:",
                "Ajustar Estoque", item.QuantidadeAtual.ToString());

            if (string.IsNullOrWhiteSpace(input)) return;
            if (!int.TryParse(input, out int novaQtd) || novaQtd < 0)
            {
                MessageBox.Show("Quantidade inválida.", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            try
            {
                _svc.AjustarQuantidade(id, novaQtd);
                MessageBox.Show("Estoque atualizado!", "Sucesso", MessageBoxButtons.OK, MessageBoxIcon.Information);
                Carregar();
            }
            catch (Exception ex) { MessageBox.Show(ex.Message, "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error); }
        }

        private static Button BotaoCor(string t, Color bg, Color fg)
        {
            var b = new Button { Text = t, Size = new Size(150, 30), Font = new Font("Arial", 9, FontStyle.Bold),
                BackColor = bg, ForeColor = fg, FlatStyle = FlatStyle.Flat, Cursor = Cursors.Hand };
            b.FlatAppearance.BorderSize = 0;
            return b;
        }

        private static DataGridView CriarGrid()
        {
            var g = new DataGridView
            {
                BackgroundColor = Color.White, BorderStyle = BorderStyle.None,
                RowHeadersVisible = false, AllowUserToAddRows = false,
                AllowUserToDeleteRows = false, ReadOnly = true,
                SelectionMode = DataGridViewSelectionMode.FullRowSelect,
                MultiSelect = false, Font = new Font("Arial", 9),
                AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill,
                ColumnHeadersHeight = 38, RowTemplate = { Height = 36 }
            };
            g.ColumnHeadersDefaultCellStyle.BackColor = Color.FromArgb(61, 0, 102);
            g.ColumnHeadersDefaultCellStyle.ForeColor = Color.White;
            g.ColumnHeadersDefaultCellStyle.Font = new Font("Arial", 9, FontStyle.Bold);
            g.EnableHeadersVisualStyles = false;
            g.AlternatingRowsDefaultCellStyle.BackColor = Color.FromArgb(250, 248, 255);
            return g;
        }
    }

    // ═══════════════════════════════════════════════════════════════════════
    // UCPedidos — Gestão de Pedidos (RF-D12 a RF-D15 | UC13, UC14)
    // ═══════════════════════════════════════════════════════════════════════
    public class UCPedidos : UserControl
    {
        private DataGridView dgv;
        private ComboBox cbStatus;
        private DateTimePicker dtpDe, dtpAte;
        private Button btnFiltrar, btnDetalhes, btnAtualizarStatus;
        private Label lblContador;
        private readonly PedidoService _svc = new();
        private List<Pedido> _pedidos = new();

        public UCPedidos() { InitializeComponent(); Carregar(); }

        private void InitializeComponent()
        {
            Dock = DockStyle.Fill;
            BackColor = Color.FromArgb(245, 246, 250);

            var lblTitulo = new Label
            {
                Text = "Gestão de Pedidos", Font = new Font("Arial", 16, FontStyle.Bold),
                ForeColor = Color.FromArgb(61, 0, 102), AutoSize = true, Location = new Point(0, 10)
            };

            var pnlBar = new Panel { Location = new Point(0, 50), Size = new Size(1000, 56), BackColor = Color.White };

            cbStatus = new ComboBox
            {
                Location = new Point(10, 14), Size = new Size(180, 28),
                Font = new Font("Arial", 10), DropDownStyle = ComboBoxStyle.DropDownList
            };
            cbStatus.Items.Add("Todos os status");
            foreach (StatusPedido s in Enum.GetValues<StatusPedido>())
                cbStatus.Items.Add(s.ToString());
            cbStatus.SelectedIndex = 0;

            pnlBar.Controls.Add(new Label { Text = "De:", AutoSize = true, Location = new Point(200, 18), Font = new Font("Arial", 9) });
            dtpDe = new DateTimePicker { Location = new Point(225, 14), Size = new Size(130, 28), Format = DateTimePickerFormat.Short, Value = DateTime.Today.AddDays(-30) };
            pnlBar.Controls.Add(new Label { Text = "Até:", AutoSize = true, Location = new Point(365, 18), Font = new Font("Arial", 9) });
            dtpAte = new DateTimePicker { Location = new Point(390, 14), Size = new Size(130, 28), Format = DateTimePickerFormat.Short, Value = DateTime.Today };

            btnFiltrar = BotaoCor("🔍 Filtrar", Color.FromArgb(253, 197, 0), Color.FromArgb(61, 0, 102));
            btnFiltrar.Location = new Point(535, 13);
            btnFiltrar.Click += (s, e) => Carregar();

            btnDetalhes = BotaoCor("📋 Detalhes", Color.FromArgb(61, 0, 102), Color.White);
            btnDetalhes.Location = new Point(680, 13);
            btnDetalhes.Click += BtnDetalhes_Click;

            btnAtualizarStatus = BotaoCor("🔄 Atualizar Status", Color.FromArgb(16, 120, 60), Color.White);
            btnAtualizarStatus.Width = 160;
            btnAtualizarStatus.Location = new Point(820, 13);
            btnAtualizarStatus.Click += BtnAtualizarStatus_Click;

            pnlBar.Controls.AddRange(new Control[] { cbStatus, dtpDe, dtpAte, btnFiltrar, btnDetalhes, btnAtualizarStatus });

            dgv = UCEstoque_Shared.CriarGridShared();
            dgv.Location = new Point(0, 110); dgv.Size = new Size(1000, 500);
            dgv.CellDoubleClick += (s, e) => BtnDetalhes_Click(s, e);

            dgv.Columns.AddRange(
                new DataGridViewTextBoxColumn { Name = "IdPedido",  HeaderText = "Pedido", FillWeight = 7  },
                new DataGridViewTextBoxColumn { Name = "Data",      HeaderText = "Data",   FillWeight = 14 },
                new DataGridViewTextBoxColumn { Name = "Cliente",   HeaderText = "Cliente",FillWeight = 25 },
                new DataGridViewTextBoxColumn { Name = "Status",    HeaderText = "Status", FillWeight = 15 },
                new DataGridViewTextBoxColumn { Name = "Total",     HeaderText = "Total",  FillWeight = 12 },
                new DataGridViewTextBoxColumn { Name = "Atualizado",HeaderText = "Últ. Atualização", FillWeight = 17 }
            );

            lblContador = new Label { Text = "", Font = new Font("Arial", 9), ForeColor = Color.Gray, AutoSize = true, Location = new Point(0, 615) };
            Controls.AddRange(new Control[] { lblTitulo, pnlBar, dgv, lblContador });
        }

        private void Carregar()
        {
            try
            {
                int? status = cbStatus.SelectedIndex > 0 ? (int)(StatusPedido)Enum.Parse(typeof(StatusPedido), cbStatus.SelectedItem!.ToString()!) : null;
                _pedidos = _svc.Listar(status, dtpDe.Value, dtpAte.Value);
                dgv.Rows.Clear();

                foreach (var p in _pedidos)
                {
                    int row = dgv.Rows.Add(
                        $"#{p.IdPedido}",
                        p.DataPedido.ToString("dd/MM/yyyy HH:mm"),
                        p.NomeCliente,
                        p.NomeStatus,
                        $"R$ {p.ValorTotal:N2}",
                        p.AtualizadoEm?.ToString("dd/MM/yyyy HH:mm") ?? "—"
                    );

                    dgv.Rows[row].Cells["Status"].Style.ForeColor = p.IdStatus switch
                    {
                        1 => Color.FromArgb(180, 100, 0),
                        2 => Color.FromArgb(0, 100, 180),
                        3 => Color.FromArgb(0, 130, 60),
                        4 => Color.FromArgb(0, 140, 0),
                        5 => Color.Red,
                        _ => Color.Black
                    };
                }
                lblContador.Text = $"{_pedidos.Count} pedido(s) no período";
            }
            catch (Exception ex) { MessageBox.Show(ex.Message, "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error); }
        }

        private Pedido? PedidoSelecionado()
        {
            if (dgv.CurrentRow == null) return null;
            var cell = dgv.CurrentRow.Cells["IdPedido"].Value?.ToString()?.Replace("#", "");
            if (!int.TryParse(cell, out int id)) return null;
            return _pedidos.FirstOrDefault(p => p.IdPedido == id);
        }

        private void BtnDetalhes_Click(object? sender, EventArgs e)
        {
            var p = PedidoSelecionado();
            if (p == null) { MessageBox.Show("Selecione um pedido."); return; }
            new FormDetalhePedido(p.IdPedido).ShowDialog();
        }

        private void BtnAtualizarStatus_Click(object? sender, EventArgs e)
        {
            var p = PedidoSelecionado();
            if (p == null) { MessageBox.Show("Selecione um pedido."); return; }

            var form = new FormAtualizarStatus(p);
            if (form.ShowDialog() == DialogResult.OK) Carregar();
        }

        private static Button BotaoCor(string t, Color bg, Color fg)
        {
            var b = new Button { Text = t, Size = new Size(130, 30), Font = new Font("Arial", 9, FontStyle.Bold),
                BackColor = bg, ForeColor = fg, FlatStyle = FlatStyle.Flat, Cursor = Cursors.Hand };
            b.FlatAppearance.BorderSize = 0;
            return b;
        }
    }

    // ═══════════════════════════════════════════════════════════════════════
    // UCClientes — Gestão de Clientes (RF-D16 a RF-D18 | UC15)
    // ═══════════════════════════════════════════════════════════════════════
    public class UCClientes : UserControl
    {
        private DataGridView dgv;
        private TextBox txtBusca;
        private Button btnDesativar, btnAtualizar;
        private readonly Infrastructure.Repositories.ClienteRepository _repo = new();
        private List<Domain.Entities.Cliente> _clientes = new();

        public UCClientes() { InitializeComponent(); Carregar(); }

        private void InitializeComponent()
        {
            Dock = DockStyle.Fill; BackColor = Color.FromArgb(245, 246, 250);

            var lblT = new Label { Text = "Gestão de Clientes", Font = new Font("Arial", 16, FontStyle.Bold), ForeColor = Color.FromArgb(61, 0, 102), AutoSize = true, Location = new Point(0, 10) };

            var pnl = new Panel { Location = new Point(0, 50), Size = new Size(1000, 50), BackColor = Color.White };
            txtBusca = new TextBox { Location = new Point(10, 12), Size = new Size(260, 28), Font = new Font("Arial", 10), PlaceholderText = "🔍 Buscar cliente..." };
            txtBusca.TextChanged += (s, e) => Carregar();

            btnDesativar = new Button { Text = "🚫 Desativar Cliente", Location = new Point(285, 10), Size = new Size(160, 30), Font = new Font("Arial", 9, FontStyle.Bold), BackColor = Color.FromArgb(200, 40, 40), ForeColor = Color.White, FlatStyle = FlatStyle.Flat, Cursor = Cursors.Hand };
            btnDesativar.FlatAppearance.BorderSize = 0;
            btnDesativar.Click += BtnDesativar_Click;

            btnAtualizar = new Button { Text = "↺ Atualizar", Location = new Point(460, 10), Size = new Size(120, 30), Font = new Font("Arial", 9, FontStyle.Bold), BackColor = Color.Gray, ForeColor = Color.White, FlatStyle = FlatStyle.Flat, Cursor = Cursors.Hand };
            btnAtualizar.FlatAppearance.BorderSize = 0;
            btnAtualizar.Click += (s, e) => Carregar();
            pnl.Controls.AddRange(new Control[] { txtBusca, btnDesativar, btnAtualizar });

            dgv = UCEstoque_Shared.CriarGridShared();
            dgv.Location = new Point(0, 110); dgv.Size = new Size(1000, 500);
            dgv.Columns.AddRange(
                new DataGridViewTextBoxColumn { Name = "Id",     HeaderText = "ID",       FillWeight = 5  },
                new DataGridViewTextBoxColumn { Name = "Nome",   HeaderText = "Nome",     FillWeight = 25 },
                new DataGridViewTextBoxColumn { Name = "Email",  HeaderText = "E-mail",   FillWeight = 25 },
                new DataGridViewTextBoxColumn { Name = "Tel",    HeaderText = "Telefone", FillWeight = 15 },
                new DataGridViewTextBoxColumn { Name = "Pedidos",HeaderText = "Pedidos",  FillWeight = 8  },
                new DataGridViewTextBoxColumn { Name = "Gasto",  HeaderText = "Total Gasto", FillWeight = 12 },
                new DataGridViewTextBoxColumn { Name = "Status", HeaderText = "Status",   FillWeight = 10 }
            );
            Controls.AddRange(new Control[] { lblT, pnl, dgv });
        }

        private void Carregar()
        {
            try
            {
                string? busca = string.IsNullOrWhiteSpace(txtBusca.Text) ? null : txtBusca.Text;
                _clientes = _repo.ListarTodos(busca);
                dgv.Rows.Clear();
                foreach (var c in _clientes)
                {
                    int row = dgv.Rows.Add(c.IdCliente, c.Nome, c.Email, c.Telefone,
                        c.TotalPedidos, $"R$ {c.TotalGasto:N2}", c.Ativo ? "✔ Ativo" : "✘ Inativo");
                    if (!c.Ativo) dgv.Rows[row].DefaultCellStyle.ForeColor = Color.Gray;
                }
            }
            catch (Exception ex) { MessageBox.Show(ex.Message, "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error); }
        }

        private void BtnDesativar_Click(object? sender, EventArgs e)
        {
            if (dgv.CurrentRow == null) { MessageBox.Show("Selecione um cliente."); return; }
            int id = Convert.ToInt32(dgv.CurrentRow.Cells["Id"].Value);
            var c = _clientes.First(x => x.IdCliente == id);

            if (MessageBox.Show($"Desativar cliente \"{c.Nome}\"?\nEle não conseguirá mais fazer login.", "Confirmar", MessageBoxButtons.YesNo, MessageBoxIcon.Warning) != DialogResult.Yes) return;

            try { _repo.Desativar(id); MessageBox.Show("Cliente desativado.", "Sucesso"); Carregar(); }
            catch (Exception ex) { MessageBox.Show(ex.Message, "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error); }
        }
    }

    // ═══════════════════════════════════════════════════════════════════════
    // UCRelatorios — Relatório de Vendas (RF-D22 a RF-D24)
    // ═══════════════════════════════════════════════════════════════════════
    public class UCRelatorios : UserControl
    {
        private DataGridView dgv;
        private DateTimePicker dtpDe, dtpAte;
        private Button btnGerar, btnExportarCsv;
        private Label lblTotal, lblQtd, lblTicket;
        private readonly RelatorioService _svc = new();
        private List<Pedido> _pedidos = new();

        public UCRelatorios() { InitializeComponent(); }

        private void InitializeComponent()
        {
            Dock = DockStyle.Fill; BackColor = Color.FromArgb(245, 246, 250);

            var lblT = new Label { Text = "Relatório de Vendas", Font = new Font("Arial", 16, FontStyle.Bold), ForeColor = Color.FromArgb(61, 0, 102), AutoSize = true, Location = new Point(0, 10) };

            var pnl = new Panel { Location = new Point(0, 50), Size = new Size(1000, 56), BackColor = Color.White };
            pnl.Controls.Add(new Label { Text = "De:", AutoSize = true, Location = new Point(10, 18), Font = new Font("Arial", 9) });
            dtpDe = new DateTimePicker { Location = new Point(35, 14), Size = new Size(130, 28), Format = DateTimePickerFormat.Short, Value = DateTime.Today.AddMonths(-1) };
            pnl.Controls.Add(new Label { Text = "Até:", AutoSize = true, Location = new Point(175, 18), Font = new Font("Arial", 9) });
            dtpAte = new DateTimePicker { Location = new Point(200, 14), Size = new Size(130, 28), Format = DateTimePickerFormat.Short, Value = DateTime.Today };
            btnGerar = new Button { Text = "📊 Gerar Relatório", Location = new Point(345, 13), Size = new Size(160, 30), Font = new Font("Arial", 9, FontStyle.Bold), BackColor = Color.FromArgb(253, 197, 0), ForeColor = Color.FromArgb(61, 0, 102), FlatStyle = FlatStyle.Flat, Cursor = Cursors.Hand };
            btnGerar.FlatAppearance.BorderSize = 0;
            btnGerar.Click += BtnGerar_Click;

            btnExportarCsv = new Button { Text = "📥 Exportar CSV", Location = new Point(520, 13), Size = new Size(150, 30), Font = new Font("Arial", 9, FontStyle.Bold), BackColor = Color.FromArgb(16, 120, 60), ForeColor = Color.White, FlatStyle = FlatStyle.Flat, Cursor = Cursors.Hand };
            btnExportarCsv.FlatAppearance.BorderSize = 0;
            btnExportarCsv.Click += BtnExportar_Click;
            pnl.Controls.AddRange(new Control[] { dtpDe, dtpAte, btnGerar, btnExportarCsv });

            // Cards de totalizadores
            lblTotal  = CriarCard("Total de Vendas",  "—", 0,   120);
            lblQtd    = CriarCard("Nº de Pedidos",    "—", 240, 120);
            lblTicket = CriarCard("Ticket Médio",     "—", 480, 120);

            dgv = UCEstoque_Shared.CriarGridShared();
            dgv.Location = new Point(0, 230); dgv.Size = new Size(1000, 390);
            dgv.Columns.AddRange(
                new DataGridViewTextBoxColumn { Name = "Id",      HeaderText = "Pedido",  FillWeight = 8  },
                new DataGridViewTextBoxColumn { Name = "Data",    HeaderText = "Data",    FillWeight = 14 },
                new DataGridViewTextBoxColumn { Name = "Cliente", HeaderText = "Cliente", FillWeight = 28 },
                new DataGridViewTextBoxColumn { Name = "Status",  HeaderText = "Status",  FillWeight = 14 },
                new DataGridViewTextBoxColumn { Name = "Total",   HeaderText = "Total",   FillWeight = 12 }
            );
            Controls.AddRange(new Control[] { lblT, pnl, dgv });
        }

        private Label CriarCard(string titulo, string valor, int x, int y)
        {
            var pnl = new Panel { Location = new Point(x, y), Size = new Size(220, 90), BackColor = Color.White };
            pnl.Paint += (s, e) => e.Graphics.FillRectangle(new SolidBrush(Color.FromArgb(61, 0, 102)), 0, 0, pnl.Width, 5);
            pnl.Controls.Add(new Label { Text = titulo, Font = new Font("Arial", 9), ForeColor = Color.Gray, AutoSize = true, Location = new Point(15, 20) });
            var lbl = new Label { Text = valor, Font = new Font("Arial", 20, FontStyle.Bold), ForeColor = Color.FromArgb(61, 0, 102), AutoSize = true, Location = new Point(15, 42) };
            pnl.Controls.Add(lbl);
            Controls.Add(pnl);
            return lbl;
        }

        private void BtnGerar_Click(object? sender, EventArgs e)
        {
            try
            {
                var (pedidos, total, qtd, ticket) = _svc.GerarRelatorioVendas(dtpDe.Value, dtpAte.Value);
                _pedidos = pedidos;
                lblTotal.Text  = $"R$ {total:N2}";
                lblQtd.Text    = qtd.ToString();
                lblTicket.Text = $"R$ {ticket:N2}";

                dgv.Rows.Clear();
                foreach (var p in pedidos)
                    dgv.Rows.Add($"#{p.IdPedido}", p.DataPedido.ToString("dd/MM/yyyy"), p.NomeCliente, p.NomeStatus, $"R$ {p.ValorTotal:N2}");
            }
            catch (Exception ex) { MessageBox.Show(ex.Message, "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error); }
        }

        private void BtnExportar_Click(object? sender, EventArgs e)
        {
            if (_pedidos.Count == 0) { MessageBox.Show("Gere o relatório antes de exportar."); return; }

            using var dlg = new SaveFileDialog { Filter = "CSV|*.csv", FileName = $"relatorio_{DateTime.Now:yyyyMMdd}.csv" };
            if (dlg.ShowDialog() != DialogResult.OK) return;

            try
            {
                _svc.ExportarCsv(_pedidos, dlg.FileName);
                MessageBox.Show($"Arquivo exportado:\n{dlg.FileName}", "Exportado com sucesso", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            catch (Exception ex) { MessageBox.Show(ex.Message, "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error); }
        }
    }

    /// <summary>Helper estático para criar DataGridView padronizado.</summary>
    internal static class UCEstoque_Shared
    {
        internal static DataGridView CriarGridShared()
        {
            var g = new DataGridView
            {
                BackgroundColor = Color.White, BorderStyle = BorderStyle.None,
                RowHeadersVisible = false, AllowUserToAddRows = false,
                AllowUserToDeleteRows = false, ReadOnly = true,
                SelectionMode = DataGridViewSelectionMode.FullRowSelect,
                MultiSelect = false, Font = new Font("Arial", 9),
                AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill,
                ColumnHeadersHeight = 38, RowTemplate = { Height = 36 }
            };
            g.ColumnHeadersDefaultCellStyle.BackColor = Color.FromArgb(61, 0, 102);
            g.ColumnHeadersDefaultCellStyle.ForeColor = Color.White;
            g.ColumnHeadersDefaultCellStyle.Font = new Font("Arial", 9, FontStyle.Bold);
            g.EnableHeadersVisualStyles = false;
            g.AlternatingRowsDefaultCellStyle.BackColor = Color.FromArgb(250, 248, 255);
            return g;
        }
    }
}
