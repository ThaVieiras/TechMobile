<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// 1 - Destaques da Semana (Conforme o Wireframe)
$stmt = $pdo->query("SELECT * FROM produtos WHERE ativo = 1 LIMIT 5");
$produtos_destaque = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2 - Mais Vendidos (Conforme o Wireframe)
$stmtMV = $pdo->query("SELECT * FROM produtos WHERE mais_vendido = 1 AND ativo = 1 LIMIT 5");
$mais_vendidos = $stmtMV->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMobile - Tecnologia a um clique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .brand-logo {
            filter: grayscale(100%);
            opacity: 0.5;
            transition: 0.3s;
            max-height: 40px;
        }

        .brand-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
        }

        /* Arredondar o botão conforme o Wireframe */
        .btn-add {
            border-radius: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <section>
        <?php include __DIR__ . '/../../app/views/carrossel.php'; ?>
    </section>

    <main class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Destaques da Semana</h2>
            <a href="produtos.php" class="btn btn-outline-primary btn-sm">Ver todos</a>
        </div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
            <?php foreach ($produtos_destaque as $p): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 text-center">

                        <div class="d-flex align-items-center justify-content-center p-3" style="height: 180px;">
                            <?php if (!empty($p['imagem_url'])): ?>
                                <img src="assets/img/<?php echo $p['imagem_url']; ?>" alt="<?php echo $p['nome']; ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                            <?php else: ?>
                                <div class="bg-secondary-subtle w-100 h-100 d-flex align-items-center justify-content-center rounded">
                                    <span class="text-muted small">Sem foto</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-truncate small"><?php echo $p['nome']; ?></h6>
                            <p class="card-text fw-bold text-primary">R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></p>
                            <a href="add.php?id=<?php echo $p['id_produto']; ?>" class="btn btn-primary btn-sm w-100 btn-add">Adicionar ao carrinho</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <section class="container my-5 pt-5 border-top">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Mais Vendidos</h2>
            <a href="produtos.php" class="btn btn-link text-decoration-none">Ver todos</a>
        </div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
            <?php foreach ($mais_vendidos as $mv): ?>
                <div class="col">
                    <div class="card h-100 border-0 bg-transparent text-center">
                        <div class="d-flex align-items-center justify-content-center mb-2" style="height: 180px;">
                            <span class="text-muted small">Imagem <?php echo $mv['nome']; ?></span>
                        </div>
                        <div class="card-body p-2">
                            <h6 class="text-truncate small mb-1"><?php echo $mv['nome']; ?></h6>
                            <p class="fw-bold mb-1">R$ <?php echo number_format($mv['preco'], 2, ',', '.'); ?></p>
                            <p class="text-muted small" style="font-size: 11px;">Até 12x sem juros</p>
                            <a href="add.php?id=<?php echo $mv['id_produto']; ?>" class="btn btn-primary btn-sm w-100 btn-add">Adicionar ao carrinho</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="container my-5 py-5 border-top">
        <h4 class="text-center fw-bold mb-5">Compre por marcas</h4>
        <div class="row justify-content-center align-items-center g-5 text-center">
            <div class="col-4 col-md-2"><img src="assets/img/logo-apple.png" class="brand-logo img-fluid"></div>
            <div class="col-4 col-md-2"><img src="assets/img/logo-samsung.png" class="brand-logo img-fluid"></div>
            <div class="col-4 col-md-2"><img src="assets/img/logo-motorola.png" class="brand-logo img-fluid"></div>
            <div class="col-4 col-md-2"><img src="assets/img/logo-xiaomi.png" class="brand-logo img-fluid"></div>
            <div class="col-4 col-md-2"><img src="assets/img/logo-lg.png" class="brand-logo img-fluid"></div>
            <div class="col-4 col-md-2"><img src="assets/img/logo-poco.png" class="brand-logo img-fluid"></div>
        </div>
    </section>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

</body>

</html>