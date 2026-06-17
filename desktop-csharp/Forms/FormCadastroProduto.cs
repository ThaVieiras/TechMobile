using TechMobile.Desktop.Application.Services;
using TechMobile.Desktop.Domain.Entities;
using TechMobile.Desktop.Domain.Enums;

namespace TechMobile.Desktop.UI.Forms
{
    /// <summary>
    /// Formulário para cadastro e edição de produto (UC09 / UC10).
    /// Modo novo: produto == null. Modo edição: produto preenchido.
    /// </summary>
    public class FormCadastroProduto : Form
    {
        private TextBox txtNome, txtMarca, txtModelo, txtPreco, txtImagem, txtEstoqueInicial;
        private ComboBox cbCategoria;
        private RichTextBox rtbDescricao;
        private CheckBox chkAtivo, chkMaisVendido;
        private Button btnSalvar, btnCancelar, btnEscolherImagem;
        private Label lblTitulo;

        private readonly ProdutoService _svc = new();
        private readonly Produto? _produtoEdicao;

        public FormCadastroProduto(Produto? produto)
        {
            _produtoEdicao = produto;
            InitializeComponent();

            if (produto != null) PreencherFormulario(produto);
        }

        private void InitializeComponent()
        {
            Text = _produtoEdicao == null ? "Novo Produto" : "Editar Produto";
            Size = new Size(620, 660);
            StartPosition = FormStartPosition.CenterParent;
            FormBorderStyle = FormBorderStyle.FixedDialog;
            MaximizeBox = false;
            BackColor = Color.White;

            lblTitulo = new Label
            {
                Text = _produtoEdicao == null ? "Cadastrar Produto" : "Editar Produto",
                Font = new Font("Arial", 14, FontStyle.Bold),
                ForeColor = Color.FromArgb(61, 0, 102),
                AutoSize = true,
                Location = new Point(30, 20)
            };

            int y = 70;
            int labelW = 120;

            // Linha 1: Nome
            y = AdicionarCampo("Nome *", out txtNome, y);

            // Linha 2: Marca / Modelo na mesma linha
            AdicionarLabel("Marca *", 30, y);
            txtMarca = new TextBox { Location = new Point(160, y), Size = new Size(170, 28), Font = new Font("Arial", 10) };
            AdicionarLabel("Modelo", 340, y);
            txtModelo = new TextBox { Location = new Point(430, y), Size = new Size(150, 28), Font = new Font("Arial", 10) };
            Controls.AddRange(new Control[] { txtMarca, txtModelo });
            y += 50;

            // Linha 3: Categoria / Preço
            AdicionarLabel("Categoria *", 30, y);
            cbCategoria = new ComboBox
            {
                Location = new Point(160, y),
                Size = new Size(160, 28),
                Font = new Font("Arial", 10),
                DropDownStyle = ComboBoxStyle.DropDownList
            };
            cbCategoria.Items.AddRange(CategoriaProduto.Todas);
            AdicionarLabel("Preço (R$) *", 340, y);
            txtPreco = new TextBox { Location = new Point(460, y), Size = new Size(110, 28), Font = new Font("Arial", 10) };
            Controls.AddRange(new Control[] { cbCategoria, txtPreco });
            y += 50;

            // Descrição
            AdicionarLabel("Descrição", 30, y);
            rtbDescricao = new RichTextBox
            {
                Location = new Point(160, y),
                Size = new Size(400, 80),
                Font = new Font("Arial", 10),
                BorderStyle = BorderStyle.FixedSingle
            };
            Controls.Add(rtbDescricao);
            y += 100;

            // Imagem
            AdicionarLabel("Imagem", 30, y);
            txtImagem = new TextBox
            {
                Location = new Point(160, y),
                Size = new Size(280, 28),
                Font = new Font("Arial", 10),
                PlaceholderText = "nome-do-arquivo.jpg"
            };
            btnEscolherImagem = new Button
            {
                Text = "Escolher...",
                Location = new Point(455, y - 1),
                Size = new Size(105, 30),
                Font = new Font("Arial", 9),
                BackColor = Color.FromArgb(61, 0, 102),
                ForeColor = Color.White,
                FlatStyle = FlatStyle.Flat,
                Cursor = Cursors.Hand
            };
            btnEscolherImagem.FlatAppearance.BorderSize = 0;
            btnEscolherImagem.Click += BtnEscolherImagem_Click;
            Controls.AddRange(new Control[] { txtImagem, btnEscolherImagem });
            y += 50;

            // Estoque inicial (somente no cadastro)
            if (_produtoEdicao == null)
            {
                AdicionarLabel("Estoque Inicial", 30, y);
                txtEstoqueInicial = new TextBox
                {
                    Location = new Point(160, y),
                    Size = new Size(100, 28),
                    Font = new Font("Arial", 10),
                    Text = "0"
                };
                Controls.Add(txtEstoqueInicial);
                y += 50;
            }
            else
            {
                txtEstoqueInicial = new TextBox { Text = "0" };
            }

            // Checkboxes
            chkAtivo = new CheckBox
            {
                Text = "Produto ativo na loja",
                Location = new Point(160, y),
                AutoSize = true,
                Font = new Font("Arial", 10),
                Checked = true
            };
            chkMaisVendido = new CheckBox
            {
                Text = "Exibir em 'Mais Vendidos'",
                Location = new Point(330, y),
                AutoSize = true,
                Font = new Font("Arial", 10)
            };
            Controls.AddRange(new Control[] { chkAtivo, chkMaisVendido });
            y += 50;

            // Botões
            btnSalvar = new Button
            {
                Text = "💾  SALVAR",
                Location = new Point(160, y + 10),
                Size = new Size(200, 44),
                Font = new Font("Arial", 11, FontStyle.Bold),
                BackColor = Color.FromArgb(253, 197, 0),
                ForeColor = Color.FromArgb(61, 0, 102),
                FlatStyle = FlatStyle.Flat,
                Cursor = Cursors.Hand,
                DialogResult = DialogResult.None
            };
            btnSalvar.FlatAppearance.BorderSize = 0;
            btnSalvar.Click += BtnSalvar_Click;

            btnCancelar = new Button
            {
                Text = "Cancelar",
                Location = new Point(375, y + 10),
                Size = new Size(120, 44),
                Font = new Font("Arial", 10),
                BackColor = Color.WhiteSmoke,
                ForeColor = Color.FromArgb(61, 0, 102),
                FlatStyle = FlatStyle.Flat,
                DialogResult = DialogResult.Cancel,
                Cursor = Cursors.Hand
            };
            btnCancelar.FlatAppearance.BorderColor = Color.FromArgb(61, 0, 102);

            Controls.AddRange(new Control[] { lblTitulo, btnSalvar, btnCancelar });
        }

        private int AdicionarCampo(string label, out TextBox txt, int y)
        {
            AdicionarLabel(label, 30, y);
            txt = new TextBox
            {
                Location = new Point(160, y),
                Size = new Size(400, 28),
                Font = new Font("Arial", 10)
            };
            Controls.Add(txt);
            return y + 50;
        }

        private void AdicionarLabel(string texto, int x, int y)
        {
            Controls.Add(new Label
            {
                Text = texto,
                Font = new Font("Arial", 9, FontStyle.Bold),
                ForeColor = Color.FromArgb(75, 85, 99),
                AutoSize = true,
                Location = new Point(x, y + 5)
            });
        }

        private void PreencherFormulario(Produto p)
        {
            txtNome.Text       = p.Nome;
            txtMarca.Text      = p.Marca;
            txtModelo.Text     = p.Modelo;
            txtPreco.Text      = p.Preco.ToString("F2");
            txtImagem.Text     = p.ImagemUrl;
            rtbDescricao.Text  = p.Descricao;
            chkAtivo.Checked   = p.Ativo;
            chkMaisVendido.Checked = p.MaisVendido;

            int idx = cbCategoria.Items.IndexOf(p.Categoria);
            if (idx >= 0) cbCategoria.SelectedIndex = idx;
        }

        private void BtnEscolherImagem_Click(object? sender, EventArgs e)
        {
            using var dialog = new OpenFileDialog
            {
                Title = "Selecionar imagem do produto",
                Filter = "Imagens|*.jpg;*.jpeg;*.png;*.webp",
                InitialDirectory = Environment.GetFolderPath(Environment.SpecialFolder.MyPictures)
            };

            if (dialog.ShowDialog() == DialogResult.OK)
                txtImagem.Text = Path.GetFileName(dialog.FileName);
        }

        private void BtnSalvar_Click(object? sender, EventArgs e)
        {
            try
            {
                var produto = new Produto
                {
                    IdProduto   = _produtoEdicao?.IdProduto ?? 0,
                    Nome        = txtNome.Text.Trim(),
                    Marca       = txtMarca.Text.Trim(),
                    Modelo      = txtModelo.Text.Trim(),
                    Categoria   = cbCategoria.SelectedItem?.ToString() ?? "",
                    Descricao   = rtbDescricao.Text.Trim(),
                    Preco       = decimal.TryParse(txtPreco.Text.Replace(",","."),
                                    System.Globalization.NumberStyles.Any,
                                    System.Globalization.CultureInfo.InvariantCulture,
                                    out var preco) ? preco : 0,
                    ImagemUrl   = txtImagem.Text.Trim(),
                    Ativo       = chkAtivo.Checked,
                    MaisVendido = chkMaisVendido.Checked
                };

                int estoque = int.TryParse(txtEstoqueInicial.Text, out var est) ? est : 0;

                _svc.Salvar(produto, estoque);

                MessageBox.Show("Produto salvo com sucesso!", "Sucesso",
                    MessageBoxButtons.OK, MessageBoxIcon.Information);
                DialogResult = DialogResult.OK;
                Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Erro ao salvar",
                    MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
