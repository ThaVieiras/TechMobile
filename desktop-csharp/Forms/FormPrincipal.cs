using TechMobile.Desktop.Application.Services;
using TechMobile.Desktop.Domain.Enums;

namespace TechMobile.Desktop.UI.Forms
{
    /// <summary>
    /// Janela principal com menu lateral (sidebar) e área de conteúdo dinâmica.
    /// Controla a navegação entre os módulos conforme o perfil RBAC.
    /// </summary>
    public class FormPrincipal : Form
    {
        private Panel pnlSidebar, pnlConteudo, pnlHeader;
        private Label lblUsuario, lblPerfil;
        private Button? _btnAtivo;

        // Cores da identidade TechMobile
        private static readonly Color CorSidebar  = Color.FromArgb(61, 0, 102);
        private static readonly Color CorBtnAtivo = Color.FromArgb(253, 197, 0);
        private static readonly Color CorBtnHover = Color.FromArgb(80, 0, 130);
        private static readonly Color CorTexto    = Color.White;
        private static readonly Color CorGold     = Color.FromArgb(253, 197, 0);

        public FormPrincipal()
        {
            InitializeComponent();
            ConfigurarMenuPorPerfil();
            CarregarModulo(new UCDashboard());
        }

        private void InitializeComponent()
        {
            Text = "TechMobile — Sistema Administrativo";
            Size = new Size(1280, 800);
            MinimumSize = new Size(1100, 700);
            StartPosition = FormStartPosition.CenterScreen;
            BackColor = Color.FromArgb(245, 246, 250);
            FormClosed += (s, e) => Application.Exit();

            // ── Header superior ───────────────────────────────────────────
            pnlHeader = new Panel
            {
                Dock = DockStyle.Top,
                Height = 60,
                BackColor = Color.White,
                Padding = new Padding(20, 0, 20, 0)
            };

            var lblLogo = new Label
            {
                Text = "TECHMOBILE",
                Font = new Font("Arial", 14, FontStyle.Bold),
                ForeColor = CorSidebar,
                AutoSize = true,
                Location = new Point(260, 18)
            };

            lblUsuario = new Label
            {
                Text = $"Olá, {AuthService.AdminLogado?.Nome?.Split(' ')[0]}",
                Font = new Font("Arial", 10, FontStyle.Bold),
                ForeColor = CorSidebar,
                AutoSize = true,
                Anchor = AnchorStyles.Right | AnchorStyles.Top
            };

            lblPerfil = new Label
            {
                Text = AuthService.AdminLogado?.Perfil.ToString() ?? "",
                Font = new Font("Arial", 8),
                ForeColor = Color.Gray,
                AutoSize = true,
                Anchor = AnchorStyles.Right | AnchorStyles.Top
            };

            pnlHeader.Controls.AddRange(new Control[] { lblLogo, lblUsuario, lblPerfil });
            pnlHeader.Resize += (s, e) =>
            {
                lblUsuario.Location = new Point(pnlHeader.Width - 160, 14);
                lblPerfil.Location  = new Point(pnlHeader.Width - 160, 33);
            };

            // ── Sidebar ───────────────────────────────────────────────────
            pnlSidebar = new Panel
            {
                Dock = DockStyle.Left,
                Width = 230,
                BackColor = CorSidebar,
                Padding = new Padding(0, 10, 0, 10)
            };

            var lblMenu = new Label
            {
                Text = "MENU",
                ForeColor = Color.FromArgb(150, 150, 180),
                Font = new Font("Arial", 8, FontStyle.Bold),
                AutoSize = false,
                TextAlign = ContentAlignment.MiddleLeft,
                Bounds = new Rectangle(20, 10, 190, 25)
            };
            pnlSidebar.Controls.Add(lblMenu);

            // ── Área de conteúdo ──────────────────────────────────────────
            pnlConteudo = new Panel
            {
                Dock = DockStyle.Fill,
                BackColor = Color.FromArgb(245, 246, 250),
                Padding = new Padding(20)
            };

            Controls.AddRange(new Control[] { pnlConteudo, pnlSidebar, pnlHeader });
        }

        /// <summary>
        /// Adiciona botão de menu na sidebar com evento de navegação.
        /// </summary>
        private Button CriarBotaoMenu(string texto, string icone, int posY, Action aoClicar)
        {
            var btn = new Button
            {
                Text = $"  {icone}  {texto}",
                TextAlign = ContentAlignment.MiddleLeft,
                Bounds = new Rectangle(0, posY, 230, 46),
                Font = new Font("Arial", 10),
                ForeColor = CorTexto,
                BackColor = CorSidebar,
                FlatStyle = FlatStyle.Flat,
                Cursor = Cursors.Hand,
                Tag = texto
            };
            btn.FlatAppearance.BorderSize = 0;
            btn.FlatAppearance.MouseOverBackColor = CorBtnHover;

            btn.Click += (s, e) =>
            {
                AtivarBotao(btn);
                aoClicar();
            };
            return btn;
        }

        private void AtivarBotao(Button btn)
        {
            if (_btnAtivo != null)
            {
                _btnAtivo.BackColor = CorSidebar;
                _btnAtivo.ForeColor = CorTexto;
            }
            btn.BackColor = CorBtnAtivo;
            btn.ForeColor = CorSidebar;
            _btnAtivo = btn;
        }

        private void CarregarModulo(UserControl modulo)
        {
            pnlConteudo.Controls.Clear();
            modulo.Dock = DockStyle.Fill;
            pnlConteudo.Controls.Add(modulo);
        }

        /// <summary>
        /// Monta o menu conforme o perfil RBAC do admin logado.
        /// </summary>
        private void ConfigurarMenuPorPerfil()
        {
            var perfil = AuthService.AdminLogado?.Perfil ?? PerfilAdmin.Estoque;
            int y = 50;

            void Add(string txt, string icon, Action acao)
            {
                var btn = CriarBotaoMenu(txt, icon, y, acao);
                pnlSidebar.Controls.Add(btn);
                y += 48;
            }

            // Dashboard — todos
            Add("Dashboard",    "🏠", () => CarregarModulo(new UCDashboard()));

            // Produtos — Admin
            if (perfil == PerfilAdmin.Admin)
            {
                Add("Produtos",   "📦", () => CarregarModulo(new UCProdutos()));
                y += 4; // separador visual
            }

            // Estoque — Admin e Estoque
            if (perfil is PerfilAdmin.Admin or PerfilAdmin.Estoque)
                Add("Estoque",    "📊", () => CarregarModulo(new UCEstoque()));

            // Pedidos — Admin e Estoque
            if (perfil is PerfilAdmin.Admin or PerfilAdmin.Estoque)
                Add("Pedidos",    "🛒", () => CarregarModulo(new UCPedidos()));

            // Clientes — Admin
            if (perfil == PerfilAdmin.Admin)
                Add("Clientes",   "👥", () => CarregarModulo(new UCClientes()));

            // Relatórios — Admin e Financeiro
            if (perfil is PerfilAdmin.Admin or PerfilAdmin.Financeiro)
                Add("Relatórios", "📈", () => CarregarModulo(new UCRelatorios()));

            // Sair — todos
            y += 20;
            var btnSair = CriarBotaoMenu("Sair", "🔓", y, () =>
            {
                if (MessageBox.Show("Deseja sair do sistema?", "Confirmar saída",
                    MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    AuthService.Logout();
                    var login = new FormLogin();
                    login.Show();
                    Close();
                }
            });
            btnSair.BackColor = Color.FromArgb(40, 0, 70);
            pnlSidebar.Controls.Add(btnSair);
        }
    }
}
