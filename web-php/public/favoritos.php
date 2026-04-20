<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Adiciona produto aos favoritos
if (isset($_GET['add'])) {
    $id = (int) $_GET['add'];
    if (!in_array($id, $_SESSION['favoritos'] ?? [])) {
        $_SESSION['favoritos'][] = $id;
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

// Remove produto dos favoritos
if (isset($_GET['remove'])) {
    $id = (int) $_GET['remove'];
    $_SESSION['favoritos'] = array_filter(
        $_SESSION['favoritos'] ?? [],
        fn($item) => $item !== $id
    );
    header("Location: favoritos.php");
    exit;
}

// Busca os produtos favoritados no banco
$favoritos = $_SESSION['favoritos'] ?? [];
$produtos = [];

if (!empty($favoritos)) {
    $placeholders = implode(',', array_fill(0, count($favoritos), '?'));
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id_produto IN ($placeholders) AND ativo = 1");
    $stmt->execute($favoritos);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Favoritos - TechMobile</title>
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
                <i class="fa-regular fa-heart me-2"></i> Meus Favoritos
            </h2>

            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-secondary px-3 py-2 rounded-pill">
                    <?php echo count($produtos); ?> produto(s)
                </span>
                <a href="minha_conta.php" class="btn btn-outline-techmobile btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Minha Conta
                </a>
            </div>
        </div>

        <?php if (empty($produtos)): ?>
            <div class="text-center py-5">
                <i class="fa-regular fa-heart fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Você ainda não tem favoritos.</h4>
                <a href="produtos.php" class="btn btn-outline-techmobile mt-3">
                    Explorar Produtos
                </a>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
                <?php foreach ($produtos as $p): ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm card-produto">
                            <div class="card-img-wrapper">
                                <img src="assets/img/<?php echo $p['imagem_url']; ?>"
                                    class="img-fluid"
                                    alt="<?php echo $p['nome']; ?>"
                                    style="max-height: 100%; object-fit: contain;"
                                    onerror="this.src='assets/img/sem-foto.png'">
                            </div>
                            <div class="card-body d-flex flex-column text-center">
                                <span class="d-block text-muted small text-uppercase fw-semibold mb-1">
                                    <?php echo $p['marca']; ?>
                                </span>
                                <h6 class="fw-bold text-dark card-nome mb-3">
                                    <?php echo $p['nome']; ?>
                                </h6>
                                <div class="mt-auto">
                                    <p class="price-tag mb-3">
                                        R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?>
                                    </p>
                                    <div class="d-grid gap-2">
                                        <a href="adicionar_carrinho.php?id=<?php echo $p['id_produto']; ?>"
                                            class="btn btn-techmobile py-2 fw-bold">
                                            <i class="fa-solid fa-cart-shopping me-1"></i> Comprar
                                        </a>
                                        <a href="favoritos.php?remove=<?php echo $p['id_produto']; ?>"
                                            class="btn btn-outline-danger btn-sm">
                                            <i class="fa-solid fa-trash me-1"></i> Remover
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>