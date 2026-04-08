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

    <main class="container my-5 bg-white p-5 shadow-sm rounded">
        <div class="row">
            <div class="col-md-6 text-center">
                <img src="assets/img/<?php echo $produto['imagem_url']; ?>" 
                     alt="<?php echo $produto['nome']; ?>" 
                     class="img-fluid rounded" style="max-height: 450px;">
            </div>

            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="produtos.php">Produtos</a></li>
                        <li class="breadcrumb-item active"><?php echo $produto['marca']; ?></li>
                    </ol>
                </nav>

                <h1 class="fw-bold"><?php echo $produto['nome']; ?></h1>
                <p class="text-muted">Marca: <?php echo $produto['marca']; ?> | Modelo: <?php echo $produto['modelo']; ?></p>
                
                <h2 class="text-primary fw-bold my-4">
                    R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                </h2>

                <div class="my-4">
                    <h5>Descrição do Produto</h5>
                    <p class="text-secondary"><?php echo nl2br($produto['descricao']); ?></p>
                </div>

                <hr>

                <a href="add.php?id=<?php echo $produto['id_produto']; ?>" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow">
                    Adicionar ao Carrinho
                </a>
                
                <p class="text-center mt-3 small text-muted">
                    💳 Parcelamento em até 12x sem juros no cartão.
                </p>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

</body>
</html>