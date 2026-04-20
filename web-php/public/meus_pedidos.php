<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Proteção: apenas usuários logados (RNF-01)
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$id_cliente = $_SESSION['cliente_id'];

// Busca os pedidos com o nome do status (RF-W10 / RN-05)
$sql = "SELECT p.id_pedido, p.data_pedido, p.valor_total, s.nome_status 
        FROM pedidos p
        INNER JOIN status_pedido s ON p.id_status = s.id_status
        WHERE p.id_cliente = ? 
        ORDER BY p.data_pedido DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_cliente]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Pedidos - TechMobile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group shadow-sm">
                    <a href="minha_conta.php" class="list-group-item list-group-item-action">Meus Dados</a>
                    <a href="meus_pedidos.php" class="list-group-item list-group-item-action active">Meus Pedidos</a>
                    <a href="limpar.php" class="list-group-item list-group-item-action text-danger">Sair</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="bg-white p-4 shadow-sm rounded">
                    <h2 class="fw-bold mb-4">Histórico de Pedidos</h2>

                    <?php if (count($pedidos) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pedido</th>
                                        <th>Data</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pedidos as $ped): ?>
                                        <tr>
                                            <td class="fw-bold">#<?php echo $ped['id_pedido']; ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($ped['data_pedido'])); ?></td>
                                            <td class="text-primary fw-bold">R$ <?php echo number_format($ped['valor_total'], 2, ',', '.'); ?></td>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    <?php echo $ped['nome_status']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="detalhe_pedido.php?id=<?php echo $ped['id_pedido']; ?>" class="btn btn-outline-primary btn-sm">Ver Detalhes</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-light border text-center py-5">
                            <p class="mb-0">Você ainda não realizou nenhum pedido.</p>
                            <a href="produtos.php" class="btn btn-primary mt-3">Ir para a Loja</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

</body>
</html>