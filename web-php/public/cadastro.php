<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    // RNF-01: Criptografia de senha - usando password_hash 
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); 

    try {
        $sql = "INSERT INTO clientes (nome, email, senha_hash, ativo, data_cadastro) VALUES (?, ?, ?, 1, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $senha]);
        
        echo "<p style='color: green;'>✅ Cadastro realizado! <a href='login.php'>Faça Login</a></p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>❌ Erro ao cadastrar: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Techmobile - Criar Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4">Criar Conta</h3>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" placeholder="Ex: Nome Sobrenome" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" placeholder="nome@exemplo.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" placeholder="Crie uma senha forte" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Cadastrar</button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <p class="text-muted">Já tem uma conta? <a href="login.php" class="text-decoration-none">Acesse aqui</a></p>
                            <hr>
                            <a href="produtos.php" class="btn btn-link btn-sm text-secondary text-decoration-none">Voltar para a loja</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!--Aqui chama o arquivo do rodapé separado para ajudar na manutenção e organização do código-->
    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
</body>
</html>