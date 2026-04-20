<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Segurança: Se não estiver logado, manda para o login (RNF-01)
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$id_cliente = $_SESSION['cliente_id'];

// Busca os dados atuais do cliente no banco (RF-W09)
$stmt = $pdo->prepare("SELECT nome, email, telefone, cpf FROM clientes WHERE id_cliente = ?");
$stmt->execute([$id_cliente]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucesso!</strong> Seus dados foram atualizados com segurança.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Erro!</strong> Não foi possível atualizar os dados. Tente novamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Conta - TechMobile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group shadow-sm">
                    <a href="minha_conta.php" class="list-group-item list-group-item-action active">Meus Dados</a>
                    <a href="meus_pedidos.php" class="list-group-item list-group-item-action">Meus Pedidos</a>
                    <a href="limpar.php" class="list-group-item list-group-item-action text-danger">Sair</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="bg-white p-4 shadow-sm rounded">
                    <h2 class="fw-bold mb-4">Meus Dados</h2>
                    
                    <form action="atualizar_perfil.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" value="<?php echo $cliente['nome']; ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" value="<?php echo $cliente['email']; ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefone</label>
                                <input type="text" name="telefone" class="form-control" value="<?php echo $cliente['telefone'] ?? ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CPF</label>
                                <input type="text" class="form-control" value="<?php echo $cliente['cpf'] ?? ''; ?>" disabled>
                            </div>
                            
                            <h4 class="mt-4">Endereço de Entrega</h4>
                            <div class="col-12">
                                <label class="form-label">Endereço Completo (Rua, nº, Bairro)</label>
                                <textarea name="endereco" class="form-control" rows="2" placeholder="Ex: Rua das Flores, 123 - Itaquera"></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-5">Salvar Alterações</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

</body>
</html>