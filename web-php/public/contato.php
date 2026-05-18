<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Se o usuário estiver logado, pegamos os dados dele para facilitar
$nome_logado = $_SESSION['cliente_nome'] ?? '';
$email_logado = $_SESSION['cliente_email'] ?? '';

// Processamento do Formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];

    $stmt = $pdo->prepare("INSERT INTO contatos (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([$nome, $email, $assunto, $mensagem])) {
        $sucesso = "Sua mensagem foi enviada com sucesso! Em breve entraremos em contato.";
    } else {
        $erro = "Ocorreu um erro ao enviar sua mensagem. Tente novamente mais tarde.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contato - TechMobile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 bg-white p-5 shadow-sm rounded">
                <h2 class="fw-bold mb-4">Fale Conosco</h2>
                <p class="text-muted mb-4">Dúvidas, sugestões ou suporte técnico? Utilize o formulário abaixo.</p>

                <?php if (isset($sucesso)): ?>
                    <div class="alert alert-success"><?php echo $sucesso; ?></div>
                <?php endif; ?>

                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>

                <form action="contato.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Seu Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $nome_logado; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Seu E-mail</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email_logado; ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Assunto</label>
                            <select name="assunto" class="form-select" required>
                                <option value="">Selecione...</option>
                                <option value="Dúvida sobre Produto">Dúvida sobre Produto</option>
                                <option value="Status de Pedido">Status de Pedido</option>
                                <option value="Elogio/Sugestão">Elogio/Sugestão</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Mensagem</label>
                            <textarea name="mensagem" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-5">Enviar Mensagem</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

</body>
</html>