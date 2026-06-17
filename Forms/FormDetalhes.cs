using TechMobile.Desktop.Application.Services;
using TechMobile.Desktop.Domain.Entities;
using TechMobile.Desktop.Domain.Enums;

namespace TechMobile.Desktop.UI.Forms
{
    // ═══════════════════════════════════════════════════════════════════════
    // FormDetalhePedido — Detalhe completo de um pedido (UC13)
    // ═══════════════════════════════════════════════════════════════════════
    public class FormDetalhePedido : Form
    {
        private readonly PedidoService _svc = new();
        private readonly int _idPedido;

        public FormDetalhePedido(int idPedido)
        {
            _idPedido = idPedido;
            InitializeComponent();
            Carregar();
        }

        private Panel pnlResumo;
        private DataGridView dgvItens;
        private Label lblStatus, lblCliente, lblData, lblTotal;

        private void InitializeComponent()
        {
            Text = $"Detalhes do Pedido #{_idPedido}";
            Size = new Size(760, 600);
            StartPosition = FormStartPosition.CenterParent;
            FormBorderStyle = FormBorderStyle.FixedDialog;
            MaximizeBox = false;
            BackColor = Color.White;

            // Cabeçalho
            var lblTitulo = new Label
            {
                Text = $"Pedido #{_idPedido}",
                Font = new Font("Arial", 14, FontStyle.Bold),
                ForeColor = Color.FromArgb(61, 0, 102),
                AutoSize = true, Location = new Point(25, 20)
            };

            // Painel de resumo
            pnlResumo = new Panel
            {
                Location = new Point(20, 60),
                Size = new Size(700, 100),
                BackColor = Color.FromArgb(245, 246, 250),
                Padding = new Padding(15)
            };

            lblCliente = CriarInfo("Cliente: —", 15, 15);
            lblData    = CriarInfo("Data: —",    15, 40);
            lblStatus  = CriarInfo("Status: —",  380, 15);
            lblTotal   = CriarInfo("Total: —",   380, 40);
            pnlResumo.Controls.AddRange(new Control[] { lblCliente, lblData, lblStatus, lblTotal });

            // Grid de itens
            var lblItens = new Label
            {
                Text = "Itens do Pedido",
                Font = new Font("Arial", 11, FontStyle.Bold),
                ForeColor = Color.FromArgb(61, 0, 102),
                AutoSize = true, Location = new Point(20, 175)
            };

            dgvItens = new DataGridView
            {
                Location = new Point(20, 200),
                Size = new Size(700, 290),
                BackgroundColor = Color.White,
                BorderStyle = BorderStyle.None,
                RowHeadersVisible = false,
                AllowUserToAddRows = false,
                ReadOnly = true,
                SelectionMode = DataGridViewSelectionMode.FullRowSelect,
                Font = new Font("Arial", 9),
                AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill,
                ColumnHeadersHeight = 36,
                RowTemplate = { Height = 34 }
            };
            dgvItens.ColumnHeadersDefaultCellStyle.BackColor = Color.FromArgb(61, 0, 102);
            dgvItens.ColumnHeadersDefaultCellStyle.ForeColor = Color.White;
            dgvItens.ColumnHeadersDefaultCellStyle.Font = new Font("Arial", 9, FontStyle.Bold);
            dgvItens.EnableHeadersVisualStyles = false;
            dgvItens.Columns.AddRange(
                new DataGridViewTextBoxColumn { Name = "Produto",     HeaderText = "Produto",       FillWeight = 40 },
                new DataGridViewTextBoxColumn { Name = "Qtd",         HeaderText = "Qtd.",           FillWeight = 10 },
                new DataGridViewTextBoxColumn { Name = "PrecoUnit",   HeaderText = "Preço Unit.",    FillWeight = 20 },
                new DataGridViewTextBoxColumn { Name = "Subtotal",    HeaderText = "Subtotal",       FillWeight = 20 }
            );

            var btnFechar = new Button
            {
                Text = "Fechar",
                Location = new Point(580, 510),
                Size = new Size(140, 36),
                Font = new Font("Arial", 10, FontStyle.Bold),
                BackColor = Color.FromArgb(61, 0, 102),
                ForeColor = Color.White,
                FlatStyle = FlatStyle.Flat,
                DialogResult = DialogResult.Cancel,
                Cursor = Cursors.Hand
            };
            btnFechar.FlatAppearance.BorderSize = 0;

            Controls.AddRange(new Control[] { lblTitulo, pnlResumo, lblItens, dgvItens, btnFechar });
        }

        private static Label CriarInfo(string texto, int x, int y) => new()
        {
            Text = texto, AutoSize = true, Location = new Point(x, y),
            Font = new Font("Arial", 10), ForeColor = Color.FromArgb(30, 30, 30)
        };

        private void Carregar()
        {
            try
            {
                var pedido = _svc.BuscarComItens(_idPedido);
                if (pedido == null) { MessageBox.Show("Pedido não encontrado."); Close(); return; }

                lblCliente.Text = $"Cliente: {pedido.NomeCliente}";
                lblData.Text    = $"Data: {pedido.DataPedido:dd/MM/yyyy HH:mm}";
                lblStatus.Text  = $"Status: {pedido.NomeStatus}";
                lblTotal.Text   = $"Total: R$ {pedido.ValorTotal:N2}";

                foreach (var item in pedido.Itens)
                    dgvItens.Rows.Add(
                        item.NomeProduto,
                        item.Quantidade,
                        $"R$ {item.PrecoUnitario:N2}",
                        $"R$ {item.Subtotal:N2}"
                    );
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro: {ex.Message}", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }

    // ═══════════════════════════════════════════════════════════════════════
    // FormAtualizarStatus — Altera status de um pedido (UC14 | RN-D04)
    // ═══════════════════════════════════════════════════════════════════════
    public class FormAtualizarStatus : Form
    {
        private ComboBox cbNovoStatus;
        private Button btnConfirmar, btnCancelar;
        private readonly PedidoService _svc = new();
        private readonly Pedido _pedido;

        public FormAtualizarStatus(Pedido pedido)
        {
            _pedido = pedido;
            InitializeComponent();
        }

        private void InitializeComponent()
        {
            Text = $"Atualizar Status — Pedido #{_pedido.IdPedido}";
            Size = new Size(420, 270);
            StartPosition = FormStartPosition.CenterParent;
            FormBorderStyle = FormBorderStyle.FixedDialog;
            MaximizeBox = false;
            BackColor = Color.White;

            Controls.Add(new Label
            {
                Text = $"Pedido #{_pedido.IdPedido} — {_pedido.NomeCliente}",
                Font = new Font("Arial", 11, FontStyle.Bold),
                ForeColor = Color.FromArgb(61, 0, 102),
                AutoSize = true, Location = new Point(30, 25)
            });

            Controls.Add(new Label
            {
                Text = $"Status atual: {_pedido.NomeStatus}",
                Font = new Font("Arial", 10), ForeColor = Color.Gray,
                AutoSize = true, Location = new Point(30, 55)
            });

            Controls.Add(new Label
            {
                Text = "Novo status:",
                Font = new Font("Arial", 10, FontStyle.Bold),
                ForeColor = Color.FromArgb(61, 0, 102),
                AutoSize = true, Location = new Point(30, 100)
            });

            cbNovoStatus = new ComboBox
            {
                Location = new Point(30, 122),
                Size = new Size(340, 32),
                Font = new Font("Arial", 10),
                DropDownStyle = ComboBoxStyle.DropDownList
            };

            // Popula apenas status válidos (não permite retroceder)
            foreach (StatusPedido s in Enum.GetValues<StatusPedido>())
            {
                if ((int)s > _pedido.IdStatus || s == StatusPedido.Cancelado)
                    cbNovoStatus.Items.Add(s.ToString());
            }
            if (cbNovoStatus.Items.Count > 0) cbNovoStatus.SelectedIndex = 0;

            btnConfirmar = new Button
            {
                Text = "✔ Confirmar",
                Location = new Point(30, 175),
                Size = new Size(170, 40),
                Font = new Font("Arial", 10, FontStyle.Bold),
                BackColor = Color.FromArgb(253, 197, 0),
                ForeColor = Color.FromArgb(61, 0, 102),
                FlatStyle = FlatStyle.Flat,
                Cursor = Cursors.Hand
            };
            btnConfirmar.FlatAppearance.BorderSize = 0;
            btnConfirmar.Click += BtnConfirmar_Click;

            btnCancelar = new Button
            {
                Text = "Cancelar",
                Location = new Point(215, 175),
                Size = new Size(155, 40),
                Font = new Font("Arial", 10),
                BackColor = Color.WhiteSmoke,
                ForeColor = Color.FromArgb(61, 0, 102),
                FlatStyle = FlatStyle.Flat,
                DialogResult = DialogResult.Cancel,
                Cursor = Cursors.Hand
            };
            btnCancelar.FlatAppearance.BorderColor = Color.FromArgb(61, 0, 102);

            Controls.AddRange(new Control[] { cbNovoStatus, btnConfirmar, btnCancelar });
        }

        private void BtnConfirmar_Click(object? sender, EventArgs e)
        {
            if (cbNovoStatus.SelectedItem == null) { MessageBox.Show("Selecione um status."); return; }

            if (!Enum.TryParse<StatusPedido>(cbNovoStatus.SelectedItem.ToString(), out var novoStatus))
            {
                MessageBox.Show("Status inválido."); return;
            }

            string msg = novoStatus == StatusPedido.Cancelado
                ? $"Cancelar o pedido #{_pedido.IdPedido}?\n\nO estoque dos itens será restaurado automaticamente."
                : $"Atualizar o pedido #{_pedido.IdPedido} para '{novoStatus}'?";

            if (MessageBox.Show(msg, "Confirmar", MessageBoxButtons.YesNo, MessageBoxIcon.Question) != DialogResult.Yes)
                return;

            try
            {
                _svc.AtualizarStatus(_pedido.IdPedido, novoStatus, AuthService.AdminLogado!.IdAdmin);
                MessageBox.Show("Status atualizado com sucesso!", "Sucesso",
                    MessageBoxButtons.OK, MessageBoxIcon.Information);
                DialogResult = DialogResult.OK;
                Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Erro ao atualizar", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
