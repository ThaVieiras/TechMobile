<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$id_pedido = $_GET['id'] ?? null;
$id_cliente = $_SESSION['cliente_id'];

if (!$id_pedido) {
    header("Location: meus_pedidos.php");
    exit;
}

// 1. Busca os dados gerais do pedido (Garante que o pedido pertence ao cliente logado - Segurança)
$stmtPedido = $pdo->prepare("SELECT p.*, s.nome_status 
                             FROM pedidos p 
                             INNER JOIN status_pedido s ON p.id_status = s.id_status 
                             WHERE p.id_pedido = ? AND p.id_cliente = ?");
$stmtPedido->execute([$id_pedido, $id_cliente]);
$pedido = $stmtPedido->fetch(PDO::FETCH_ASSOC);

if (!$pedido) {
    echo "Pedido não encontrado ou acesso negado.";
    exit;
}

// 2. Busca os itens desse pedido (JOIN com produtos para pegar nome e imagem)
$stmtItens = $pdo->prepare("SELECT i.*, pr.nome, pr.imagem_url 
                            FROM itens_pedidos i 
                            INNER JOIN produtos pr ON i.id_produto = pr.id_produto 
                            WHERE i.id_pedido = ?");
$stmtItens->execute([$id_pedido]);
$itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Pedido #<?php echo $id_pedido; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Pedido #<?php echo $id_pedido; ?></h2>
            <a href="meus_pedidos.php" class="btn btn-secondary btn-sm">Voltar</a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold">Resumo</h5>
                        <p class="mb-1 text-muted">Data: <?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></p>
                        <p class="mb-1">Status: <span class="badge bg-primary"><?php echo $pedido['nome_status']; ?></span></p>
                        <hr>
                        <h4 class="text-primary fw-bold">Total: R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Itens Comprados</h5>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Qtd</th>
                                        <th>Preço Unit.</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($itens as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="assets/img/<?php echo $item['imagem_url']; ?>" width="40" class="me-2">
                                                    <span><?php echo $item['nome']; ?></span>
                                                </div>
                                            </td>
                                            <td><?php echo $item['quantidade']; ?></td>
                                            <td>R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?></td>
                                            <td class="fw-bold">R$ <?php echo number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

</body>
</html>