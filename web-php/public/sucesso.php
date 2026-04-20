<?php
session_start();
// Limpa o carrinho após compra concluída
unset($_SESSION['carrinho']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMobile - Pedido Confirmado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card border-0 shadow-sm rounded-4 p-5">
                    <i class="fa-solid fa-circle-check fa-5x text-success mb-4"></i>
                    <h2 class="fw-bold text-techmobile mb-2">Pedido Confirmado!</h2>
                    <p class="text-muted mb-4">
                        Obrigado pela sua compra. Você receberá um e-mail com os detalhes do pedido em breve.
                    </p>
                    <hr class="opacity-25 my-4">
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="meus_pedidos.php" class="btn btn-outline-techmobile px-4">
                            <i class="fa-solid fa-box me-2"></i> Meus Pedidos
                        </a>
                        <a href="produtos.php" class="btn btn-techmobile px-4">
                            <i class="fa-solid fa-bag-shopping me-2"></i> Continuar Comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>