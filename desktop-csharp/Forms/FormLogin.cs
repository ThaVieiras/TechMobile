using TechMobile.Desktop.Application.Services;
using TechMobile.Desktop.Infrastructure;

namespace TechMobile.Desktop.UI.Forms
{
    /// <summary>
    /// Tela de login administrativo — ponto de entrada da aplicação.
    /// </summary>
    public class FormLogin : Form
    {
        // ── Controles ────────────────────────────────────────────────────
        private Label lblTitulo, lblEmail, lblSenha, lblVersao;
        private TextBox txtEmail, txtSenha;
        private Button btnEntrar;
        private Panel pnlLateral, pnlForm;
        private CheckBox chkMostrarSenha;

        private readonly AuthService _auth = new();

        public FormLogin()
        {
            InitializeComponent();
        }

        private void InitializeComponent()
        {
            // ── Janela ───────────────────────────────────────────────────
            Text = "TechMobile — Login Administrativo";
            Size = new Size(900, 580);
            StartPosition = FormStartPosition.CenterScreen;
            FormBorderStyle = FormBorderStyle.FixedSingle;
            MaximizeBox = false;
            BackColor = Color.White;

            // ── Painel lateral roxo ───────────────────────────────────────
            pnlLateral = new Panel
            {
                Dock = DockStyle.Left,
                Width = 380,
                BackColor = Color.FromArgb(61, 0, 102)   // --techmobile-dark
            };

            lblTitulo = new Label
            {
                Text = "TECHMOBILE",
                ForeColor = Color.FromArgb(253, 197, 0), // --techmobile-secondary
                Font = new Font("Arial", 26, FontStyle.Bold),
                AutoSize = false,
                TextAlign = ContentAlignment.MiddleCenter,
                Bounds = new Rectangle(0, 180, 380, 50)
            };

            var lblSlogan = new Label
            {
                Text = "Sua conexão, sua energia.",
                ForeColor = Color.FromArgb(200, 200, 200),
                Font = new Font("Arial", 12, FontStyle.Italic),
                AutoSize = false,
                TextAlign = ContentAlignment.MiddleCenter,
                Bounds = new Rectangle(0, 240, 380, 30)
            };

            lblVersao = new Label
            {
                Text = "Sistema Administrativo v1.0",
                ForeColor = Color.FromArgb(150, 150, 150),
                Font = new Font("Arial", 9),
                AutoSize = false,
                TextAlign = ContentAlignment.MiddleCenter,
                Bounds = new Rectangle(0, 490, 380, 25)
            };

            pnlLateral.Controls.AddRange(new Control[] { lblTitulo, lblSlogan, lblVersao });

            // ── Painel do formulário ──────────────────────────────────────
            pnlForm = new Panel
            {
                Location = new Point(380, 0),
                Size = new Size(520, 580),
                BackColor = Color.White
            };

            var lblAcesso = new Label
            {
                Text = "Acesso Administrativo",
                Font = new Font("Arial", 18, FontStyle.Bold),
                ForeColor = Color.FromArgb(61, 0, 102),
                AutoSize = true,
                Location = new Point(60, 100)
            };

            lblEmail = new Label
            {
                Text = "E-mail",
                Font = new Font("Arial", 10, FontStyle.Bold),
                ForeColor = Color.FromArgb(75, 85, 99),
                AutoSize = true,
                Location = new Point(60, 180)
            };

            txtEmail = new TextBox
            {
                Location = new Point(60, 202),
                Size = new Size(390, 36),
                Font = new Font("Arial", 11),
                BorderStyle = BorderStyle.FixedSingle,
                PlaceholderText = "admin@techmobile.com.br"
            };

            lblSenha = new Label
            {
                Text = "Senha",
                Font = new Font("Arial", 10, FontStyle.Bold),
                ForeColor = Color.FromArgb(75, 85, 99),
                AutoSize = true,
                Location = new Point(60, 260)
            };

            txtSenha = new TextBox
            {
                Location = new Point(60, 282),
                Size = new Size(390, 36),
                Font = new Font("Arial", 11),
                BorderStyle = BorderStyle.FixedSingle,
                PasswordChar = '•',
                PlaceholderText = "Sua senha"
            };

            chkMostrarSenha = new CheckBox
            {
                Text = "Mostrar senha",
                Location = new Point(60, 326),
                AutoSize = true,
                Font = new Font("Arial", 9),
                ForeColor = Color.Gray
            };
            chkMostrarSenha.CheckedChanged += (s, e) =>
                txtSenha.PasswordChar = chkMostrarSenha.Checked ? '\0' : '•';

            btnEntrar = new Button
            {
                Text = "ENTRAR",
                Location = new Point(60, 380),
                Size = new Size(390, 46),
                Font = new Font("Arial", 12, FontStyle.Bold),
                BackColor = Color.FromArgb(253, 197, 0),
                ForeColor = Color.FromArgb(61, 0, 102),
                FlatStyle = FlatStyle.Flat,
                Cursor = Cursors.Hand
            };
            btnEntrar.FlatAppearance.BorderSize = 0;
            btnEntrar.Click += BtnEntrar_Click;

            // Enter no campo de senha também dispara o login
            txtSenha.KeyPress += (s, e) =>
            {
                if (e.KeyChar == (char)Keys.Enter) BtnEntrar_Click(s, e);
            };

            pnlForm.Controls.AddRange(new Control[]
            {
                lblAcesso, lblEmail, txtEmail, lblSenha, txtSenha,
                chkMostrarSenha, btnEntrar
            });

            Controls.AddRange(new Control[] { pnlLateral, pnlForm });
        }

        private void BtnEntrar_Click(object? sender, EventArgs e)
        {
            var email = txtEmail.Text.Trim();
            var senha = txtSenha.Text;

            if (string.IsNullOrWhiteSpace(email) || string.IsNullOrWhiteSpace(senha))
            {
                MessageBox.Show("Preencha e-mail e senha.", "Atenção",
                    MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            btnEntrar.Enabled = false;
            btnEntrar.Text = "Entrando...";

            try
            {
                if (_auth.Login(email, senha))
                {
                    var principal = new FormPrincipal();
                    principal.Show();
                    Hide();
                }
                else
                {
                    MessageBox.Show("E-mail ou senha inválidos.", "Acesso negado",
                        MessageBoxButtons.OK, MessageBoxIcon.Error);
                    txtSenha.Clear();
                    txtSenha.Focus();
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao conectar ao banco de dados:\n{ex.Message}",
                    "Erro de conexão", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            finally
            {
                btnEntrar.Enabled = true;
                btnEntrar.Text = "ENTRAR";
            }
        }
    }
}
