<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT id_cliente, nome, senha_hash FROM clientes WHERE email = ? AND ativo = 1");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
        $_SESSION['cliente_id']   = $usuario['id_cliente'];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMobile - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-circle-user fa-3x text-techmobile mb-2"></i>
                        <h4 class="fw-bold text-techmobile">Acessar Conta</h4>
                        <p class="text-muted small">Bem-vindo de volta!</p>
                    </div>

                    <?php if (isset($erro)): ?>
                        <div class="alert alert-danger rounded-3 small">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i><?php echo $erro; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">E-mail</label>
                            <input type="email" name="email" class="form-control rounded-pill px-4"
                                   placeholder="seu@email.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Senha</label>
                            <input type="password" name="senha" class="form-control rounded-pill px-4"
                                   placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-techmobile w-100 py-2">
                            <i class="fa-solid fa-right-to-bracket me-2"></i> Entrar
                        </button>
                    </form>

                    <hr class="my-4 opacity-25">

                    <p class="text-center small text-muted mb-0">
                        Não tem conta?
                        <a href="cadastro.php" class="text-techmobile fw-bold text-decoration-none">Cadastre-se aqui</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>