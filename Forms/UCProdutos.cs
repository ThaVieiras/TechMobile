using TechMobile.Desktop.Application.Services;
using TechMobile.Desktop.Domain.Entities;
using TechMobile.Desktop.Domain.Enums;

namespace TechMobile.Desktop.UI.Forms
{
    /// <summary>
    /// Módulo de gestão de produtos (UC09, UC10, UC11).
    /// Lista produtos com busca, filtro por categoria e ações de CRUD.
    /// </summary>
    public class UCProdutos : UserControl
    {
        private DataGridView dgvProdutos;
        private TextBox txtBusca;
        private ComboBox cbCategoria;
        private Button btnNovo, btnEditar, btnDesativar, btnAtualizar;
        private Label lblContador;

        private readonly ProdutoService _svc = new();
        private List<Produto> _produtos = new();

        public UCProdutos()
        {
            InitializeComponent();
            CarregarProdutos();
        }

        private void InitializeComponent()
        {
            Dock = DockStyle.Fill;
            BackColor = Color.FromArgb(245, 246, 250);

            // ── Cabeçalho ─────────────────────────────────────────────────
            var lblTitulo = new Label
            {
                Text = "Gestão de Produtos",
                Font = new Font("Arial", 16, FontStyle.Bold),
                ForeColor = Color.FromArgb(61, 0, 102),
                AutoSize = true,
                Location = new Point(0, 10)
            };

            // ── Barra de ferramentas ───────────────────────────────────────
            var pnlToolbar = new Panel
            {
                Location = new Point(0, 50),
                Size = new Size(1000, 50),
                BackColor = Color.White,
                Padding = new Padding(10, 8, 10, 8)
            };

            txtBusca = new TextBox
            {
                Location = new Point(10, 12),
                Size = new Size(260, 28),
                Font = new Font("Arial", 10),
                PlaceholderText = "🔍 Buscar produto ou marca..."
            };
            txtBusca.TextChanged += (s, e) => CarregarProdutos();

            cbCategoria = new ComboBox
            {
                Location = new Point(285, 12),
                Size = new Size(160, 28),
                Font = new Font("Arial", 10),
                DropDownStyle = ComboBoxStyle.DropDownList
            };
            cbCategoria.Items.Add("Todas as categorias");
            cbCategoria.Items.AddRange(CategoriaProduto.Todas);
            cbCategoria.SelectedIndex = 0;
            cbCategoria.SelectedIndexChanged += (s, e) => CarregarProdutos();

            btnNovo = CriarBotao("+ Novo Produto", Color.FromArgb(253, 197, 0), Color.FromArgb(61, 0, 102));
            btnNovo.Location = new Point(470, 10);
            btnNovo.Click += BtnNovo_Click;

            btnEditar = CriarBotao("✏ Editar", Color.FromArgb(61, 0, 102), Color.White);
            btnEditar.Location = new Point(620, 10);
            btnEditar.Click += BtnEditar_Click;

            btnDesativar = CriarBotao("🗑 Desativar", Color.FromArgb(200, 40, 40), Color.White);
            btnDesativar.Location = new Point(730, 10);
            btnDesativar.Click += BtnDesativar_Click;

            btnAtualizar = CriarBotao("↺ Atualizar", Color.FromArgb(90, 90, 90), Color.White);
            btnAtualizar.Location = new Point(860, 10);
            btnAtualizar.Click += (s, e) => CarregarProdutos();

            pnlToolbar.Controls.AddRange(new Control[]
            {
                txtBusca, cbCategoria, btnNovo, btnEditar, btnDesativar, btnAtualizar
            });

            // ── Grid de produtos ───────────────────────────────────────────
            dgvProdutos = new DataGridView
            {
                Location = new Point(0, 110),
                Size = new Size(1000, 500),
                Anchor = AnchorStyles.Top | AnchorStyles.Left | AnchorStyles.Right | AnchorStyles.Bottom,
                BackgroundColor = Color.White,
                BorderStyle = BorderStyle.None,
                RowHeadersVisible = false,
                AllowUserToAddRows = false,
                AllowUserToDeleteRows = false,
                ReadOnly = true,
                SelectionMode = DataGridViewSelectionMode.FullRowSelect,
                MultiSelect = false,
                Font = new Font("Arial", 9),
                AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill,
                ColumnHeadersHeight = 38,
                RowTemplate = { Height = 36 }
            };
            dgvProdutos.ColumnHeadersDefaultCellStyle.BackColor = Color.FromArgb(61, 0, 102);
            dgvProdutos.ColumnHeadersDefaultCellStyle.ForeColor = Color.White;
            dgvProdutos.ColumnHeadersDefaultCellStyle.Font = new Font("Arial", 9, FontStyle.Bold);
            dgvProdutos.EnableHeadersVisualStyles = false;
            dgvProdutos.AlternatingRowsDefaultCellStyle.BackColor = Color.FromArgb(250, 248, 255);
            dgvProdutos.CellDoubleClick += (s, e) => BtnEditar_Click(s, e);

            // Colunas
            dgvProdutos.Columns.AddRange(
                new DataGridViewTextBoxColumn { Name = "IdProduto",   HeaderText = "ID",        FillWeight = 5  },
                new DataGridViewTextBoxColumn { Name = "Nome",        HeaderText = "Nome",       FillWeight = 25 },
                new DataGridViewTextBoxColumn { Name = "Marca",       HeaderText = "Marca",      FillWeight = 15 },
                new DataGridViewTextBoxColumn { Name = "Categoria",   HeaderText = "Categoria",  FillWeight = 12 },
                new DataGridViewTextBoxColumn { Name = "Preco",       HeaderText = "Preço",      FillWeight = 12 },
                new DataGridViewTextBoxColumn { Name = "Estoque",     HeaderText = "Estoque",    FillWeight = 10 },
                new DataGridViewTextBoxColumn { Name = "MaisVendido", HeaderText = "Destaque",   FillWeight = 10 },
                new DataGridViewTextBoxColumn { Name = "Ativo",       HeaderText = "Status",     FillWeight = 11 }
            );

            lblContador = new Label
            {
                Text = "0 produtos",
                Font = new Font("Arial", 9),
                ForeColor = Color.Gray,
                AutoSize = true,
                Location = new Point(0, 615)
            };

            Controls.AddRange(new Control[]
            {
                lblTitulo, pnlToolbar, dgvProdutos, lblContador
            });
        }

        private void CarregarProdutos()
        {
            try
            {
                string? busca = string.IsNullOrWhiteSpace(txtBusca.Text) ? null : txtBusca.Text;
                string? cat   = cbCategoria.SelectedIndex > 0
                    ? cbCategoria.SelectedItem?.ToString()
                    : null;

                _produtos = _svc.Listar(busca, cat);
                dgvProdutos.Rows.Clear();

                foreach (var p in _produtos)
                {
                    var row = dgvProdutos.Rows.Add(
                        p.IdProduto,
                        p.Nome,
                        p.Marca,
                        p.Categoria,
                        $"R$ {p.Preco:N2}",
                        p.QuantidadeEstoque,
                        p.MaisVendido ? "⭐ Sim" : "—",
                        p.Ativo ? "✔ Ativo" : "✘ Inativo"
                    );

                    // Destaque visual para produtos inativos
                    if (!p.Ativo)
                        dgvProdutos.Rows[row].DefaultCellStyle.ForeColor = Color.Gray;

                    // Alerta de estoque baixo
                    if (p.QuantidadeEstoque < 5)
                        dgvProdutos.Rows[row].Cells["Estoque"].Style.ForeColor = Color.Red;
                }

                lblContador.Text = $"{_produtos.Count} produto(s) encontrado(s)";
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao carregar produtos:\n{ex.Message}",
                    "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private Produto? ProdutoSelecionado()
        {
            if (dgvProdutos.CurrentRow == null) return null;
            int id = Convert.ToInt32(dgvProdutos.CurrentRow.Cells["IdProduto"].Value);
            return _produtos.FirstOrDefault(p => p.IdProduto == id);
        }

        private void BtnNovo_Click(object? sender, EventArgs e)
        {
            var form = new FormCadastroProduto(null);
            if (form.ShowDialog() == DialogResult.OK) CarregarProdutos();
        }

        private void BtnEditar_Click(object? sender, EventArgs e)
        {
            var produto = ProdutoSelecionado();
            if (produto == null)
            {
                MessageBox.Show("Selecione um produto para editar.", "Atenção",
                    MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }
            var form = new FormCadastroProduto(produto);
            if (form.ShowDialog() == DialogResult.OK) CarregarProdutos();
        }

        private void BtnDesativar_Click(object? sender, EventArgs e)
        {
            var produto = ProdutoSelecionado();
            if (produto == null)
            {
                MessageBox.Show("Selecione um produto.", "Atenção",
                    MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            var confirm = MessageBox.Show(
                $"Deseja desativar o produto:\n\"{produto.Nome}\"?\n\n" +
                "O produto ficará invisível na loja, mas seus dados serão mantidos.",
                "Confirmar desativação",
                MessageBoxButtons.YesNo, MessageBoxIcon.Warning);

            if (confirm != DialogResult.Yes) return;

            try
            {
                _svc.Desativar(produto.IdProduto);
                MessageBox.Show("Produto desativado com sucesso.", "Sucesso",
                    MessageBoxButtons.OK, MessageBoxIcon.Information);
                CarregarProdutos();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Não foi possível desativar",
                    MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private static Button CriarBotao(string texto, Color fundo, Color letra)
        {
            var btn = new Button
            {
                Text = texto,
                Size = new Size(130, 30),
                Font = new Font("Arial", 9, FontStyle.Bold),
                BackColor = fundo,
                ForeColor = letra,
                FlatStyle = FlatStyle.Flat,
                Cursor = Cursors.Hand
            };
            btn.FlatAppearance.BorderSize = 0;
            return btn;
        }
    }
}
