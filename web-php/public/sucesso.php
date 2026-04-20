<?php
session_start();
$id_pedido = $_GET['id'] ?? '000';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedido Realizado! - TechMobile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center">
    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <div class="container my-5 py-5">
        <div class="card shadow border-0 p-5">
            <h1 class="display-3 text-success">✅</h1>
            <h2 class="fw-bold">Pedido #<?php echo $id_pedido; ?> Realizado!</h2>
            <p class="lead text-muted">Obrigado pela compra. Seu pedido já está com nosso time de logística e o status atual é <strong>Novo</strong>.</p>
            <hr class="my-4">
            <p>Você receberá um e-mail com os detalhes do rastreio em breve.</p>
            <div class="mt-4">
                <a href="index.php" class="btn btn-primary btn-lg px-5 rounded-pill">Voltar para a Home</a>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
</body>
</html>