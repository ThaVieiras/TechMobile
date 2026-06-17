using TechMobile.Desktop.Infrastructure;
using TechMobile.Desktop.UI.Forms;

namespace TechMobile.Desktop
{
    /// <summary>
    /// Ponto de entrada da aplicação TechMobile Desktop.
    /// </summary>
    internal static class Program
    {
        [STAThread]
        static void Main()
        {
            ApplicationConfiguration.Initialize();

            // Testa conexão ao banco antes de abrir a aplicação
            if (!DbConnection.TestarConexao())
            {
                MessageBox.Show(
                    "Não foi possível conectar ao banco de dados MySQL.\n\n" +
                    "Verifique se o servidor está rodando e se a string de conexão\n" +
                    "em Infrastructure/DbConnection.cs está correta.",
                    "Erro de conexão — TechMobile",
                    MessageBoxButtons.OK,
                    MessageBoxIcon.Error);
                return;
            }

            Application.Run(new FormLogin());
        }
    }
}
