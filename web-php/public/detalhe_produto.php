<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: produtos.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id_produto = ? AND ativo = 1");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $produto['nome']; ?> - TechMobile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5 py-5">
        <div class="row g-5">

            <!-- Coluna da Imagem -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4 text-center rounded-4 bg-white">
                    <img src="assets/img/<?php echo $produto['imagem_url']; ?>"
                        class="img-fluid produto-img-detail"
                        alt="<?php echo $produto['nome']; ?>">
                </div>
            </div>

            <!-- Coluna dos Detalhes -->
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item">
                            <a href="index.php" class="text-decoration-none text-muted">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="produtos.php?categoria=<?php echo $produto['categoria']; ?>" class="text-decoration-none text-muted">
                                <?php echo ucfirst($produto['categoria']); ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php echo $produto['marca']; ?>
                        </li>
                    </ol>
                </nav>

                <h1 class="fw-bold text-techmobile mb-2"><?php echo $produto['nome']; ?></h1>
                <p class="text-muted mb-4">
                    Marca: <span class="fw-bold"><?php echo $produto['marca']; ?></span> |
                    Modelo: <?php echo $produto['modelo']; ?>
                </p>

                <div class="mb-4">
                    <span class="text-muted text-decoration-line-through small">
                        De: R$ <?php echo number_format($produto['preco'] * 1.15, 2, ',', '.'); ?>
                    </span>
                    <h2 class="preco-detalhe">
                        R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    </h2>
                    <p class="text-success fw-bold small">
                        Ou 12x de R$ <?php echo number_format($produto['preco'] / 12, 2, ',', '.'); ?> sem juros
                    </p>
                </div>

                <hr class="my-4 opacity-25">

                <div class="d-grid gap-2">
                    <a href="add.php?id=<?php echo $produto['id_produto']; ?>" class="btn btn-techmobile btn-lg w-100 py-3">
                        <i class="fa-solid fa-cart-shopping me-2"></i> Adicionar ao Carrinho
                    </a>
                    <a href="favoritos.php?add=<?php echo $produto['id_produto']; ?>"
                        class="btn btn-outline-techmobile py-2">
                        <i class="fa-regular fa-heart me-2"></i> Favoritar
                    </a>
                </div>

                <div class="row mt-5 g-3 text-center">
                    <div class="col-4">
                        <div class="p-2 border rounded-3 bg-light">
                            <span class="d-block fs-4">🚚</span>
                            <span class="extra-small text-muted">Frete Grátis</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded-3 bg-light">
                            <span class="d-block fs-4">🛡️</span>
                            <span class="extra-small text-muted">1 Ano Garantia</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded-3 bg-light">
                            <span class="d-block fs-4">🔄</span>
                            <span class="extra-small text-muted">Troca Fácil</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Descrição -->
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="fw-bold text-techmobile border-bottom pb-3">Descrição do Produto</h4>
                <div class="mt-4 text-muted lh-lg">
                    <?php echo nl2br($produto['descricao']); ?>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>