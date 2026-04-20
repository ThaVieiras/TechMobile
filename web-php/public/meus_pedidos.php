<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT p.*, s.nome_status 
                        FROM pedidos p 
                        INNER JOIN status_pedido s ON p.id_status = s.id_status 
                        WHERE p.id_cliente = ? 
                        ORDER BY p.data_pedido DESC");
$stmt->execute([$_SESSION['cliente_id']]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMobile - Meus Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h2 class="fw-bold text-techmobile m-0">
                <i class="fa-solid fa-box me-2"></i> Meus Pedidos
            </h2>
            <a href="minha_conta.php" class="btn btn-outline-techmobile btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Minha Conta
            </a>
        </div>

        <?php if (empty($pedidos)): ?>
            <div class="text-center py-5">
                <i class="fa-solid fa-box-open fa-4x text-muted mb-3 d-block"></i>
                <h4 class="text-muted">Você ainda não tem pedidos.</h4>
                <a href="produtos.php" class="btn btn-outline-techmobile mt-3">Explorar Produtos</a>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Pedido</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td class="fw-bold text-techmobile">#<?php echo $pedido['id_pedido']; ?></td>
                                    <td class="text-muted small">
                                        <?php echo date('d/m/Y', strtotime($pedido['data_pedido'])); ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-gold text-techmobile rounded-pill px-3">
                                            <?php echo $pedido['nome_status']; ?>
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold text-techmobile">
                                        R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="detalhe_pedido.php?id=<?php echo $pedido['id_pedido']; ?>"
                                           class="btn btn-outline-techmobile btn-sm">
                                            <i class="fa-solid fa-eye me-1"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>