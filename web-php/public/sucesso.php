<?php
session_start();
$id_pedido = $_GET['id'] ?? '000';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Realizado! - Nexus Celulares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #240046; }
        
        /* O Neon Direcional Nexus no card de sucesso */
        .card-sucesso {
            border-radius: 20px;
            background: white;
            transition: 0.3s;
            box-shadow: -10px -10px 25px rgba(255, 87, 51, 0.2), 10px 10px 25px rgba(157, 78, 221, 0.3);
            border: 1px solid rgba(36, 0, 70, 0.1) !important;
        }

        .text-nexus { color: #240046; }
        
        .btn-nexus-home {
            background-color: #FF5733 !important; /* Coral Nexus */
            border: none;
            color: white !important;
            border-radius: 50px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-nexus-home:hover {
            background-color: #E04B2B !important;
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(255, 87, 51, 0.3);
        }

        .order-number {
            color: #240046;
            background: #f8f9fa;
            padding: 5px 15px;
            border-radius: 10px;
            border: 1px dashed #FF5733;
        }
    </style>
</head>
<body class="bg-light text-center">
    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <div class="container my-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-sucesso p-5">
                    <h1 class="display-3 mb-4">✨</h1>
                    <h2 class="fw-bold text-nexus mb-3">Pedido <span class="order-number">#<?php echo htmlspecialchars($id_pedido); ?></span> Realizado!</h2>
                    <p class="lead text-muted">Agradecemos a confiança. Sua nova tecnologia já está com nosso time de logística e o status atual é <span class="badge bg-nexus py-2 px-3" style="background-color: #240046;">Pendente</span>.</p>
                    <hr class="my-4 opacity-25">
                    <p>Fique de olho! Você receberá um e-mail com os detalhes do rastreio em breve.</p>
                    <div class="mt-4">
                        <a href="index.php" class="btn btn-nexus-home btn-lg px-5 shadow-sm">Voltar para a Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
</body>
</html>