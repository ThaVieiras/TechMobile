<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$itens_carrinho = [];
$subtotal_geral = 0;

if (!empty($_SESSION['carrinho'])) {
    $ids = array_keys($_SESSION['carrinho']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';

    $sql = "SELECT id_produto, nome, preco FROM produtos WHERE id_produto IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($ids);
    $produtos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($produtos_db as $p) {
        $quantidade = $_SESSION['carrinho'][$p['id_produto']];
        $subtotal = $p['preco'] * $quantidade;
        $subtotal_geral += $subtotal;

        $itens_carrinho[] = [
            'id' => $p['id_produto'],
            'nome' => $p['nome'],
            'preco' => $p['preco'],
            'quantidade' => $quantidade,
            'subtotal' => $subtotal
        ];
    }
}

// RN-04: Frete e Cupom
$frete = 0;
$cep = $_POST['cep'] ?? '';
if (!empty($cep)) {
    $frete = 25.00;
}

$desconto = 0;
$cupom = $_POST['cupom'] ?? '';
if ($cupom === 'NEXUS10') {
    $desconto = $subtotal_geral * 0.10;
}

$total_geral = ($subtotal_geral + $frete) - $desconto;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Celulares - Seu Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #240046; }
        .text-nexus { color: #240046; }
        .bg-nexus { background-color: #240046; color: white; }
        
        .btn-nexus-buy {
            background-color: #FF5733 !important;
            border: none;
            color: white !important;
            border-radius: 50px;
            transition: 0.3s;
        }
        .btn-nexus-buy:hover { background-color: #E04B2B !important; transform: scale(1.05); }

        .btn-outline-nexus {
            color: #240046;
            border: 2px solid #240046;
            border-radius: 50px;
            font-weight: bold;
        }
        .btn-outline-nexus:hover { background-color: #240046; color: white; }

        .qty-control {
            border: 2px solid #240046 !important;
            border-radius: 50px;
            background: white;
        }
    </style>
</head>

<body class="bg-light">
    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <div class="container my-5">
        <h2 class="fw-bold mb-4 text-nexus"><i class="fa-solid fa-cart-shopping me-2"></i> Meu Carrinho</h2>

        <?php if (empty($itens_carrinho)): ?>
            <div class="card border-0 shadow-sm p-5 text-center rounded-4">
                <i class="fa-solid fa-cart-arrow-down fa-3x mb-3 text-muted"></i>
                <p class="lead text-muted">Seu carrinho está vazio.</p>
                <div class="d-flex justify-content-center">
                    <a href="produtos.php" class="btn btn-nexus-buy px-4">Voltar às compras</a>
                </div>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Produto</th>
                                <th class="text-center">Preço</th>
                                <th class="text-center">Qtd</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itens_carrinho as $item): ?>
                                <tr>
                                    <td class="ps-4 text-nexus fw-bold"><?php echo $item['nome']; ?></td>
                                    <td class="text-center">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center qty-control px-2 py-1">
                                            <a href="atualizar_carrinho.php?id=<?php echo $item['id']; ?>&acao=sub" class="text-decoration-none text-nexus px-2 fw-bold">
                                                <?php if ($item['quantidade'] > 1): ?>
                                                    <i class="fa-solid fa-minus"></i>
                                                <?php else: ?>
                                                    <i class="fa-solid fa-trash-can text-danger"></i>
                                                <?php endif; ?>
                                            </a>
                                            <span class="px-2 fw-bold"><?php echo $item['quantidade']; ?></span>
                                            <a href="atualizar_carrinho.php?id=<?php echo $item['id']; ?>&acao=add" class="text-decoration-none text-nexus px-2 fw-bold">
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-nexus">R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-body bg-white border-top p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <form method="POST" class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted"><i class="fa-solid fa-truck-fast me-1"></i> Calcular Frete</label>
                                <div class="input-group">
                                    <input type="text" name="cep" class="form-control rounded-start-pill border-end-0" placeholder="00000-000" value="<?php echo $cep; ?>">
                                    <button class="btn btn-outline-nexus rounded-end-pill" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>

                            <form method="POST">
                                <label class="form-label fw-bold small text-uppercase text-muted"><i class="fa-solid fa-ticket me-1"></i> Cupom de Desconto</label>
                                <div class="input-group">
                                    <input type="text" name="cupom" class="form-control rounded-start-pill border-end-0" placeholder="Ex: NEXUS10" value="<?php echo $cupom; ?>">
                                    <button class="btn btn-outline-nexus rounded-end-pill" type="submit">
                                        <i class="fa-solid fa-tag"></i>
                                    </button>
                                </div>
                                <?php if ($cupom === 'NEXUS10'): ?>
                                    <div class="form-text text-success fw-bold mt-2"><i class="fa-solid fa-sparkles"></i> Cupom NEXUS10 aplicado com sucesso!</div>
                                <?php endif; ?>
                            </form>
                        </div>

                        <div class="col-md-6 bg-light p-4 rounded-4">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted"><i class="fa-solid fa-list-ul me-1"></i> Subtotal:</span>
                                <span class="fw-bold">R$ <?php echo number_format($subtotal_geral, 2, ',', '.'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted"><i class="fa-solid fa-truck me-1"></i> Frete:</span>
                                <span class="fw-bold">R$ <?php echo number_format($frete, 2, ',', '.'); ?></span>
                            </div>
                            <?php if ($desconto > 0): ?>
                                <div class="d-flex justify-content-between mb-3 text-success fw-bold">
                                    <span><i class="fa-solid fa-percent me-1"></i> Desconto:</span>
                                    <span>- R$ <?php echo number_format($desconto, 2, ',', '.'); ?></span>
                                </div>
                            <?php endif; ?>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 fw-bold">Total:</h4>
                                <h3 class="text-nexus mb-0 fw-bold">R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white p-4 border-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                        <a href="produtos.php" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fa-solid fa-arrow-left me-1"></i> Continuar Comprando
                        </a>
                        <a href="checkout.php" class="btn btn-nexus-buy px-5 fw-bold btn-lg shadow">
                            <i class="fa-solid fa-cart-check me-2"></i> FINALIZAR COMPRA
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
</body>
</html>