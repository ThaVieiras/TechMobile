# TechMobile — Módulo Desktop (C# WinForms)

## Pré-requisitos
- Visual Studio 2022 ou VS Code + SDK .NET 8
- MySQL Server 8.x rodando com o banco `techmobile`
- NuGet packages: MySqlConnector, BCrypt.Net-Next, Microsoft.VisualBasic

## Estrutura de Pastas

```
desktop-csharp/
├── Domain/
│   ├── Entities/         ← POCOs: Produto, Pedido, Cliente, Administrador...
│   └── Enums/            ← PerfilAdmin, StatusPedido, CategoriaProduto
├── Infrastructure/
│   ├── DbConnection.cs   ← String de conexão MySQL
│   └── Repositories/     ← ProdutoRepository, PedidoRepository...
├── Application/
│   └── Services/         ← ProdutoService, PedidoService, AuthService...
├── UI/
│   └── Forms/            ← FormLogin, FormPrincipal, UCProdutos, UCPedidos...
├── Program.cs            ← Entry point
└── TechMobile.Desktop.csproj
```

## Configuração inicial

### 1. Ajuste a string de conexão
Edite `Infrastructure/DbConnection.cs`:
```csharp
private const string ConnStr =
    "Server=localhost;Port=3306;Database=techmobile;Uid=root;Pwd=SUA_SENHA;";
```

### 2. Instale os pacotes NuGet
```bash
dotnet restore
# ou no NuGet Package Manager:
#   MySqlConnector
#   BCrypt.Net-Next
#   Microsoft.VisualBasic
```

### 3. Execute o script SQL no banco
```sql
-- Tabela de administradores (execute em techmobile)
CREATE TABLE IF NOT EXISTS administradores (
    id_admin      INT AUTO_INCREMENT PRIMARY KEY,
    nome          VARCHAR(100) NOT NULL,
    email         VARCHAR(100) NOT NULL UNIQUE,
    senha_hash    VARCHAR(255) NOT NULL,
    perfil        ENUM('Admin','Estoque','Financeiro') NOT NULL DEFAULT 'Estoque',
    ativo         TINYINT(1) NOT NULL DEFAULT 1,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 4. Crie o primeiro administrador
No MySQL Workbench, gere o hash PHP da senha e insira:
```sql
-- hash de "admin123" gerado pelo PHP: password_hash("admin123", PASSWORD_DEFAULT)
INSERT INTO administradores (nome, email, senha_hash, perfil)
VALUES ('Admin TechMobile', 'admin@techmobile.com.br', '$2y$12$...hash...', 'Admin');
```
Ou execute o helper C# em Program.cs para gerar e inserir o primeiro admin.

### 5. Execute a aplicação
```bash
dotnet run
# ou F5 no Visual Studio
```

## Perfis de Acesso (RBAC)

| Funcionalidade      | Admin | Estoque | Financeiro |
|---------------------|-------|---------|------------|
| Dashboard           | ✓     | ✓       | ✓          |
| Produtos (CRUD)     | ✓     | ✗       | ✗          |
| Estoque (ajuste)    | ✓     | ✓       | ✗          |
| Pedidos (status)    | ✓     | ✓       | ✗          |
| Clientes            | ✓     | ✗       | ✗          |
| Relatórios          | ✓     | ✗       | ✓          |
| Exportar CSV        | ✓     | ✗       | ✓          |

## Notas importantes

- O Desktop **compartilha o mesmo banco MySQL** do módulo Web (PHP).
- Toda alteração feita no Desktop (estoque, status, produtos) reflete
  imediatamente nas consultas do site.
- Senhas são verificadas via **BCrypt** — compatível com `password_hash`
  do PHP, pois ambos usam o algoritmo bcrypt internamente.
- O campo `preco_unitario` em `itens_pedidos` é **congelado** no momento
  da compra — alterações de preço no Desktop não afetam pedidos existentes.
