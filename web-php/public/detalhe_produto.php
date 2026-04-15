<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Captura o ID do produto vindo da URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: produtos.php");
    exit;
}

// Busca os detalhes do produto no banco (RF-W03)
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
    <title><?php echo $produto['nome']; ?> - TechMobile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5 py-5">
    <div class="row g-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 text-center rounded-4 bg-white">
                <img src="assets/img/<?php echo $produto['imagem_url']; ?>" 
                     class="img-fluid" 
                     alt="<?php echo $produto['nome']; ?>"
                     style="max-height: 500px; object-fit: contain;">
            </div>
        </div>

        <div class="col-md-6">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item"><a href="produtos.php?categoria=<?php echo $produto['categoria']; ?>" class="text-decoration-none text-muted"><?php echo ucfirst($produto['categoria']); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $produto['marca']; ?></li>
                </ol>
            </nav>

            <h1 class="fw-bold text-nexus mb-2"><?php echo $produto['nome']; ?></h1>
            <p class="text-muted mb-4">Marca: <span class="fw-bold"><?php echo $produto['marca']; ?></span> | Modelo: <?php echo $produto['modelo']; ?></p>

            <div class="mb-4">
                <span class="text-muted text-decoration-line-through small">De: R$ <?php echo number_format($produto['preco'] * 1.15, 2, ',', '.'); ?></span>
                <h2 class="display-5 fw-bold text-nexus">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></h2>
                <p class="text-success fw-bold small">Ou 12x de R$ <?php echo number_format($produto['preco'] / 12, 2, ',', '.'); ?> sem juros</p>
            </div>

            <hr class="my-4 text-muted opacity-25">

            <div class="d-grid gap-2">
                <a href="add.php?id=<?php echo $produto['id_produto']; ?>" class="btn btn-nexus btn-lg py-3 fw-bold shadow-sm">
                    ADICIONAR AO CARRINHO
                </a>
                <button class="btn btn-outline-dark rounded-pill mt-2">❤️ Favoritar</button>
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

    <div class="row mt-5">
        <div class="col-12">
            <h4 class="fw-bold text-nexus border-bottom pb-3">Descrição do Produto</h4>
            <div class="mt-4 text-muted lh-lg">
                <?php echo nl2br($produto['descricao']); ?>
            </div>
        </div>
    </div>
</main>

<style>
    .text-nexus { color: #240046; }
    .btn-nexus {
        background-color: #FF5733 !important;
        border: none;
        color: white !important;
        border-radius: 50px;
        transition: 0.3s;
    }
    .btn-nexus:hover {
        background-color: #E04B2B !important;
        transform: scale(1.02);
    }
    .extra-small { font-size: 0.7rem; font-weight: bold; }
</style>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

</body>
</html>