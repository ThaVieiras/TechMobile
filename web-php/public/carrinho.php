<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$itens_carrinho = [];
$total_geral = 0;

if (!empty($_SESSION['carrinho'])) {
    // Transforma os IDs da sessão em uma lista para o SQL
    $ids = array_keys($_SESSION['carrinho']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';

    $sql = "SELECT id_produto, nome, preco FROM produtos WHERE id_produto IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($ids);
    $produtos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($produtos_db as $p) {
        $quantidade = $_SESSION['carrinho'][$p['id_produto']];
        $subtotal = $p['preco'] * $quantidade;
        $total_geral += $subtotal;

        $itens_carrinho[] = [
            'id' => $p['id_produto'],
            'nome' => $p['nome'],
            'preco' => $p['preco'],
            'quantidade' => $quantidade,
            'subtotal' => $subtotal
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Techmobile - Seu Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <div class="container my-5">
        <h2 class="mb-4">🛒 Meu Carrinho</h2>

        <?php if (empty($itens_carrinho)): ?>
            <div class="alert alert-info">Seu carrinho está vazio. <a href="produtos.php">Voltar às compras</a></div>
        <?php else: ?>
            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produto</th>
                                <th class="text-center">Preço</th>
                                <th class="text-center">Qtd</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itens_carrinho as $item): ?>
                                <tr>
                                    <td><strong><?php echo $item['nome']; ?></strong></td>
                                    <td class="text-center">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>

                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center border border-warning rounded-pill px-2 py-1" style="border-width: 2px !important; background: white;">
                                            <a href="atualizar_carrinho.php?id=<?php echo $item['id']; ?>&acao=sub" class="btn btn-sm border-0 p-0 px-2 text-dark">
                                                <?php echo ($item['quantidade'] > 1) ? '-' : '🗑️'; ?>
                                            </a>

                                            <span class="px-2 fw-bold" style="min-width: 25px;"><?php echo $item['quantidade']; ?></span>

                                            <a href="atualizar_carrinho.php?id=<?php echo $item['id']; ?>&acao=add" class="btn btn-sm border-0 p-0 px-2 fw-bold text-dark" style="font-size: 1.1rem;"> + </a>
                                        </div>
                                    </td>

                                    <td class="text-end fw-bold text-primary">R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Total da Compra:</h4>
                        <h3 class="text-primary mb-0">R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></h3>
                    </div>
                    <div class="mt-4 d-flex justify-content-between">
                        <a href="produtos.php" class="btn btn-outline-secondary">Continuar Comprando</a>
                        <a href="checkout.php" class="btn btn-success px-5 fw-bold">Finalizar Compra</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!--Aqui chama o arquivo do rodapé separado para ajudar na manutenção e organização do código-->
    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
</body>

</html>