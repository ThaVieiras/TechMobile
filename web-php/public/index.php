<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// 1 - Destaques da Semana
$stmt = $pdo->query("SELECT * FROM produtos WHERE ativo = 1 LIMIT 5");
$produtos_destaque = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2 - Mais Vendidos
$stmtMV = $pdo->query("SELECT * FROM produtos WHERE mais_vendido = 1 AND ativo = 1 LIMIT 5");
$mais_vendidos = $stmtMV->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMobile - Sua conexão, sua energia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- CSS em linha com o antigo -->
    <!--<style>
        /* Estética TechMobile */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F9FA;
            color: #240046;
        }

        .brand-logo {
            filter: grayscale(100%);
            opacity: 0.6;
            transition: 0.3s;
            max-height: 40px;
        }

        .brand-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
        }

        /* Botão techmobile (Coral Impulse e Roxo) */
        .btn-add {
            background-color: #FF5733 !important; /* Coral */
            border: none;
            color: white !important;
            border-radius: 50px; /* Mais arredondado conforme nova identidade */
            font-weight: bold;
            transition: 0.3s ease;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .btn-add:hover {
            background-color: #E04B2B !important;
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(255, 87, 51, 0.3);
        }

        .text-techmobile {
            color: #240046; /* Roxo */
        }
        
        .card-techmobile {
            transition: 0.3s;
            border-radius: 15px;
        }
        
        .card-techmobile:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(36, 0, 70, 0.1) !important;
        }
    </style>-->
</head>

<body>

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <section>
        <?php include __DIR__ . '/../../app/views/carrossel.php'; ?>
    </section>

    <main class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-techmobile">Destaques da Semana</h2>
            <a href="produtos.php" class="btn btn-outline-dark btn-sm rounded-pill">Ver todos</a>
        </div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
            <?php foreach ($produtos_destaque as $p): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 text-center card-techmobile">
                        <a href="detalhe_produto.php?id=<?php echo $p['id_produto']; ?>">
                            <!-- DE: -->
                            <div class="d-flex align-items-center justify-content-center p-3" style="height: 180px;">
                                <?php if (!empty($p['imagem_url'])): ?>
                                    <img src="assets/img/<?php echo $p['imagem_url']; ?>" alt="<?php echo $p['nome']; ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <div class="card-img-wrapper">
                                        <span class="text-muted small">Sem foto</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="card-body">
                            <h6 class="card-title text-truncate small">
                                <a href="detalhe_produto.php?id=<?php echo $p['id_produto']; ?>" class="text-decoration-none text-techmobile fw-bold">
                                    <?php echo $p['nome']; ?>
                                </a>
                            </h6>
                            <p class="card-text fw-bold text-techmobile">R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></p>

                            <a href="adicionar_carrinho.php?id=<?php echo $p['id_produto']; ?>" class="btn btn-add w-100">Adicionar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <section class="container my-5 pt-5 border-top">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-techmobile">Mais Vendidos</h2>
            <a href="produtos.php" class="btn btn-link text-techmobile text-decoration-none fw-bold">Ver todos</a>
        </div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
            <?php foreach ($mais_vendidos as $mv): ?>
                <div class="col">
                    <div class="card h-100 border-0 bg-transparent text-center card-techmobile">
                        <a href="detalhe_produto.php?id=<?php echo $mv['id_produto']; ?>">
                            <div class="d-flex align-items-center justify-content-center mb-2" style="height: 180px;">
                                <?php if (!empty($mv['imagem_url'])): ?>
                                    <img src="assets/img/<?php echo $mv['imagem_url']; ?>" alt="<?php echo $mv['nome']; ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <div class="bg-secondary-subtle w-100 h-100 d-flex align-items-center justify-content-center rounded">
                                        <span class="text-muted small">Sem foto</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="card-body p-2">
                            <h6 class="text-truncate small mb-1">
                                <a href="detalhe_produto.php?id=<?php echo $mv['id_produto']; ?>" class="text-decoration-none text-techmobile">
                                    <?php echo $mv['nome']; ?>
                                </a>
                            </h6>
                            <p class="fw-bold mb-1 text-techmobile">R$ <?php echo number_format($mv['preco'], 2, ',', '.'); ?></p>
                            <p class="text-muted small" style="font-size: 11px;">Até 12x sem juros</p>
                            <a href="add.php?id=<?php echo $p['id_produto']; ?>" class="btn btn-add w-100">Adicionar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="container my-5 py-5 border-top">
        <h4 class="text-center fw-bold text-techmobile mb-5">As melhores marcas estão aqui</h4>
        <div class="row justify-content-center align-items-center g-5 text-center">
            <div class="col-4 col-md-2"><a href="produtos.php?busca=Apple"><img src="assets/img/logo-apple.png" class="brand-logo img-fluid"></a></div>
            <div class="col-4 col-md-2"><a href="produtos.php?busca=Samsung"><img src="assets/img/logo-samsung.png" class="brand-logo img-fluid"></a></div>
            <div class="col-4 col-md-2"><a href="produtos.php?busca=Motorola"><img src="assets/img/logo-motorola.png" class="brand-logo img-fluid"></a></div>
            <div class="col-4 col-md-2"><a href="produtos.php?busca=Xiaomi"><img src="assets/img/logo-xiaomi.png" class="brand-logo img-fluid"></a></div>
            <div class="col-4 col-md-2"><a href="produtos.php?busca=Baseus"><img src="assets/img/logo-baseus.png" class="brand-logo img-fluid"></a></div>
            <div class="col-4 col-md-2"><a href="produtos.php?busca=Poco"><img src="assets/img/logo-poco.png" class="brand-logo img-fluid"></a></div>
        </div>
    </section>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>