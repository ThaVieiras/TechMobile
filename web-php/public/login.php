<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT id_cliente, nome, senha_hash FROM clientes WHERE email = ? AND ativo = 1");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validar senha usando a criptografia do PHP (RNF-01)
    if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
        $_SESSION['cliente_id'] = $usuario['id_cliente'];
        $_SESSION['cliente_nome'] = $usuario['nome'];
        
        header("Location: produtos.php");
        exit;
    } else {
        $erro = "E-mail ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Techmobile - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 text-center">
                        <h3 class="mb-4">Acessar Conta</h3>
                        <?php if(isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Seu e-mail" required>
                            </div>
                            <div class="mb-4">
                                <input type="password" name="senha" class="form-control" placeholder="Sua senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Entrar</button>
                        </form>
                        <p class="small text-muted">Não tem conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!--Aqui chama o arquivo do rodapé separado para ajudar na manutenção e organização do código-->
    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
</body>
</html>