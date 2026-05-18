<?php
session_start();
// Conexão com o banco (ajustado para o seu caminho de pastas)
require_once __DIR__ . '/../../config/database.php';

// Captura dados da URL
$categoria = $_GET['categoria'] ?? null;
$busca = $_GET['busca'] ?? null;

// --- AJUSTE DE QA: NORMALIZAÇÃO DE CATEGORIA ---
// Se o link vier como "recondicionados", transformamos em "recondicionado" para bater com o banco
if ($categoria === 'recondicionados') {
    $categoria = 'recondicionado';
}

// Lógica de Consulta ao Banco
if ($busca) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE ativo = 1 AND (nome LIKE ? OR descricao LIKE ?)");
    $stmt->execute(["%$busca%", "%$busca%"]);
} elseif ($categoria) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE ativo = 1 AND categoria = ?");
    $stmt->execute([$categoria]);
} else {
    $stmt = $pdo->query("SELECT * FROM produtos WHERE ativo = 1");
}

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Definição do Título da Página
$nomes_formatados = [
    'acessorios'     => 'Acessórios',
    'smartphone'     => 'Smartphones',
    'recondicionado' => 'Recondicionados',
    'oferta'         => 'Ofertas Especiais'
];

$titulo_exibicao = "Nossos Produtos";
if ($categoria) {
    $titulo_exibicao = $nomes_formatados[$categoria] ?? ucfirst($categoria);
} elseif ($busca) {
    $titulo_exibicao = "Resultados para: " . htmlspecialchars($busca);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techmobile Celulares - <?php echo $titulo_exibicao; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para os ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!--<style>
        :root {
            --techmobile-purple: #240046;
            --techmobile-coral: #FF5733;
        }
        .text-techmobile { color: var(--techmobile-purple); }
        .btn-techmobile { background-color: var(--techmobile-coral); color: white; border: none; transition: 0.3s; }
        .btn-techmobile:hover { background-color: #e44d2d; color: white; transform: scale(1.02); }
        .btn-outline-techmobile { border: 2px solid var(--techmobile-purple); color: var(--techmobile-purple); transition: 0.3s; }
        .btn-outline-techmobile:hover { background-color: var(--techmobile-purple); color: white; }
        .card-produto { transition: transform 0.3s, box-shadow 0.3s; border-radius: 15px; overflow: hidden; }
        .card-produto:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .price-tag { color: var(--techmobile-purple); font-size: 1.25rem; font-weight: 800; }
    </style>-->
</head>

<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <!-- Carrossel (Opcional apenas na index, mas mantido conforme seu código) -->
    <section class="container mt-4">
        <?php include __DIR__ . '/../../app/views/carrossel.php'; ?>
    </section>

    <main class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h2 class="fw-bold text-techmobile m-0"><?php echo $titulo_exibicao; ?></h2>
            <span class="badge bg-secondary px-3 py-2 rounded-pill"><?php echo count($produtos); ?> produtos</span>
        </div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
            <?php if (count($produtos) > 0): ?>
                <?php foreach ($produtos as $p): ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm card-produto">

                            <!-- Imagem -->
                            <div class="card-img-wrapper">
                                <img src="assets/img/<?php echo $p['imagem_url']; ?>"
                                    class="img-fluid"
                                    alt="<?php echo $p['nome']; ?>"
                                    style="max-height: 100%; object-fit: contain;"
                                    onerror="this.src='assets/img/sem-foto.png'">
                            </div>

                            <!-- Corpo do Card -->
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
                                        <a href="detalhe_produto.php?id=<?php echo $p['id_produto']; ?>"
                                            class="btn btn-outline-techmobile btn-sm fw-bold">
                                            <i class="fa-solid fa-plus me-1"></i> Detalhes
                                        </a>
                                        <a href="add.php?id=<?php echo $p['id_produto']; ?>" class="btn btn-techmobile py-2 fw-bold">
                                            <i class="fa-solid fa-cart-shopping me-1"></i> Comprar
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fa-solid fa-box-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Nenhum produto encontrado.</h4>
                    <a href="index.php" class="btn btn-outline-techmobile mt-3">Voltar para a Loja</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Marcas -->
        <div class="container mt-5 pt-5 text-center border-top">
            <p class="text-muted small fw-bold text-uppercase mb-4" style="letter-spacing: 2px;">Parceiros Oficiais</p>
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 opacity-75">
                <img src="assets/img/logo-apple.png" alt="Apple" height="30">
                <img src="assets/img/logo-samsung.png" alt="Samsung" height="25">
                <img src="assets/img/logo-motorola.png" alt="Motorola" height="30">
                <img src="assets/img/logo-xiaomi.png" alt="Xiaomi" height="30">
                <img src="assets/img/logo-baseus.png" alt="Baseus" height="25">
                <img src="assets/img/logo-huawei.png" alt="Huawei" height="25">
                <img src="assets/img/logo-poco.png" alt="Poco" height="25">
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>