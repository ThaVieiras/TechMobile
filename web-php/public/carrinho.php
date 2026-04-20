<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$itens_carrinho = [];
$subtotal_geral = 0;

if (!empty($_SESSION['carrinho'])) {
    $ids = array_keys($_SESSION['carrinho']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';

    $stmt = $pdo->prepare("SELECT id_produto, nome, preco FROM produtos WHERE id_produto IN ($placeholders)");
    $stmt->execute($ids);
    $produtos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($produtos_db as $p) {
        $quantidade = $_SESSION['carrinho'][$p['id_produto']];
        $subtotal = $p['preco'] * $quantidade;
        $subtotal_geral += $subtotal;

        $itens_carrinho[] = [
            'id'         => $p['id_produto'],
            'nome'       => $p['nome'],
            'preco'      => $p['preco'],
            'quantidade' => $quantidade,
            'subtotal'   => $subtotal
        ];
    }
}

// Frete
$frete = 0;
$cep = $_POST['cep'] ?? '';
if (!empty($cep)) {
    $frete = 25.00;
}

// Cupom de Desconto
$desconto = 0;
$cupom = strtoupper(trim($_POST['cupom'] ?? ''));
if ($cupom === 'TECH10') {
    $desconto = $subtotal_geral * 0.10;
}

$total_geral = ($subtotal_geral + $frete) - $desconto;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMobile - Seu Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <div class="container my-5">
        <h2 class="fw-bold text-techmobile mb-4">
            <i class="fa-solid fa-cart-shopping me-2"></i> Meu Carrinho
        </h2>

        <?php if (empty($itens_carrinho)): ?>
            <div class="text-center py-5">
                <i class="fa-solid fa-cart-shopping fa-4x text-muted mb-3 d-block"></i>
                <h4 class="text-muted">Seu carrinho está vazio.</h4>
                <a href="produtos.php" class="btn btn-outline-techmobile mt-3">Voltar às compras</a>
            </div>
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
                                    <td class="text-center">
                                        R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center border border-warning rounded-pill px-2 py-1"
                                             style="border-width: 2px !important; background: white;">
                                            <a href="atualizar_carrinho.php?id=<?php echo $item['id']; ?>&acao=sub"
                                               class="btn btn-sm border-0 p-0 px-2 text-dark">
                                                <?php echo ($item['quantidade'] > 1) ? '-' : '🗑️'; ?>
                                            </a>
                                            <span class="px-2 fw-bold" style="min-width: 25px;">
                                                <?php echo $item['quantidade']; ?>
                                            </span>
                                            <a href="atualizar_carrinho.php?id=<?php echo $item['id']; ?>&acao=add"
                                               class="btn btn-sm border-0 p-0 px-2 fw-bold text-dark">+</a>
                                        </div>
                                    </td>
                                    <td class="text-end fw-bold text-techmobile">
                                        R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-body bg-light border-top">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <form method="POST" class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Calcular Frete</label>
                                <div class="input-group">
                                    <input type="text" name="cep" class="form-control"
                                           placeholder="00000-000"
                                           value="<?php echo htmlspecialchars($cep); ?>">
                                    <button class="btn btn-outline-techmobile" type="submit">Calcular</button>
                                </div>
                                <?php if (!empty($cep)): ?>
                                    <div class="form-text text-success fw-bold">
                                        ✔ Frete calculado: R$ <?php echo number_format($frete, 2, ',', '.'); ?>
                                    </div>
                                <?php endif; ?>
                            </form>

                            <form method="POST">
                                <label class="form-label fw-bold small text-uppercase">Cupom de Desconto</label>
                                <div class="input-group">
                                    <input type="text" name="cupom" class="form-control"
                                           placeholder="Digite seu cupom"
                                           value="<?php echo htmlspecialchars($cupom); ?>">
                                    <button class="btn btn-outline-techmobile" type="submit">Aplicar</button>
                                </div>
                                <?php if ($cupom === 'TECH10'): ?>
                                    <div class="form-text text-success fw-bold">✔ Cupom TECH10 aplicado!</div>
                                <?php elseif (!empty($cupom)): ?>
                                    <div class="form-text text-danger">✘ Cupom inválido.</div>
                                <?php endif; ?>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal:</span>
                                <span>R$ <?php echo number_format($subtotal_geral, 2, ',', '.'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Frete:</span>
                                <span>R$ <?php echo number_format($frete, 2, ',', '.'); ?></span>
                            </div>
                            <?php if ($desconto > 0): ?>
                                <div class="d-flex justify-content-between mb-2 text-success fw-bold">
                                    <span>Desconto (10%):</span>
                                    <span>- R$ <?php echo number_format($desconto, 2, ',', '.'); ?></span>
                                </div>
                            <?php endif; ?>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Total:</h4>
                                <h3 class="text-techmobile mb-0 fw-bold">
                                    R$ <?php echo number_format($total_geral, 2, ',', '.'); ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white p-4">
                    <div class="d-flex justify-content-between">
                        <a href="produtos.php" class="btn btn-outline-techmobile">
                            Continuar Comprando
                        </a>
                        <a href="checkout.php" class="btn btn-techmobile px-5 fw-bold btn-lg">
                            <i class="fa-solid fa-lock me-2"></i> Finalizar Compra
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>