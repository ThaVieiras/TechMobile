<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirma = $_POST['confirma_senha'];

    if ($senha !== $confirma) {
        $erro = "As senhas não coincidem.";
    } else {
        $check = $pdo->prepare("SELECT id_cliente FROM clientes WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $erro = "Este e-mail já está cadastrado.";
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO clientes (nome, email, senha_hash, ativo) VALUES (?, ?, ?, 1)");
            $stmt->execute([$nome, $email, $hash]);
            $sucesso = "Cadastro realizado com sucesso!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMobile - Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-user-plus fa-3x text-techmobile mb-2"></i>
                        <h4 class="fw-bold text-techmobile">Criar Conta</h4>
                        <p class="text-muted small">Rápido e gratuito!</p>
                    </div>

                    <?php if ($erro): ?>
                        <div class="alert alert-danger rounded-3 small">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i><?php echo $erro; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($sucesso): ?>
                        <div class="alert alert-success rounded-3 small">
                            <i class="fa-solid fa-circle-check me-2"></i><?php echo $sucesso; ?>
                            <a href="login.php" class="fw-bold text-decoration-none">Fazer login</a>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Nome Completo</label>
                            <input type="text" name="nome" class="form-control rounded-pill px-4"
                                placeholder="Seu nome" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">E-mail</label>
                            <input type="email" name="email" class="form-control rounded-pill px-4"
                                placeholder="seu@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Senha</label>
                            <input type="password" name="senha" class="form-control rounded-pill px-4"
                                placeholder="Mínimo 6 caracteres" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Confirmar Senha</label>
                            <input type="password" name="confirma_senha" class="form-control rounded-pill px-4"
                                placeholder="Repita a senha" required>
                        </div>
                        <button type="submit" class="btn btn-techmobile w-100 py-2">
                            <i class="fa-solid fa-user-plus me-2"></i> Criar Conta
                        </button>
                    </form>

                    <hr class="my-4 opacity-25">

                    <p class="text-center small text-muted mb-0">
                        Já tem conta?
                        <a href="login.php" class="text-techmobile fw-bold text-decoration-none">Fazer login</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>