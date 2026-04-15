<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Capturamos os parâmetros da URL
$categoria = $_GET['categoria'] ?? $_GET['cat'] ?? null; // Aceita 'categoria' ou 'cat'
$busca     = $_GET['busca'] ?? null;
$tipo      = $_GET['tipo'] ?? null;

// 1. SE FOR BUSCA
if ($busca) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE ativo = 1 AND (nome LIKE ? OR descricao LIKE ?)");
    $stmt->execute(["%$busca%", "%$busca%"]);
} 
// 2. SE FOR MARCA (Ex: Apple, Samsung, Huawei)
elseif ($categoria == 'apple' || $categoria == 'samsung' || $categoria == 'huawei') {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE ativo = 1 AND marca = ?");
    $stmt->execute([$categoria]);
}
// 3. SE FOR TIPO ESPECÍFICO (Filtro inteligente que já corrigimos)
elseif ($tipo) {
    if ($tipo == 'buds' || $tipo == 'fone') {
        $stmt = $pdo->query("SELECT * FROM produtos WHERE ativo = 1 AND (nome LIKE '%buds%' OR nome LIKE '%airpods%' OR nome LIKE '%fone%')");
    } elseif ($tipo == 'cabo') {
        $stmt = $pdo->query("SELECT * FROM produtos WHERE ativo = 1 AND (nome LIKE '%cabo%' OR nome LIKE '%carregador%' OR nome LIKE '%magsafe%')");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE ativo = 1 AND (nome LIKE ? OR categoria = ?)");
        $stmt->execute(["%$tipo%", $tipo]);
    }
}
// 4. SE FOR CATEGORIA DO BANCO (smartphone, recondicionado, acessorios)
elseif ($categoria) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE ativo = 1 AND categoria = ?");
    $stmt->execute([$categoria]);
}
// 5. PADRÃO: MOSTRA TUDO (Evita o Fatal Error)
else {
    $stmt = $pdo->query("SELECT * FROM produtos WHERE ativo = 1");
}

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- LÓGICA DE TÍTULO DA PÁGINA ---
$titulo_exibicao = "Nossos Produtos";

if ($tipo) {
    $titulo_exibicao = ucfirst($tipo) . "s"; // Ex: Smartwatch -> Smartwatchs
} elseif ($categoria) {
    $nomes_formatados = [
        'acessorios'     => 'Acessórios',
        'smartphone'     => 'Smartphones',
        'recondicionado' => 'Recondicionados',
        'oferta'         => 'Ofertas especiais'
    ];
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
     <title>Nexus Celulares - Sua conexão, sua energia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <section class="container my-4">
        <?php include __DIR__ . '/../../app/views/carrossel.php'; ?>
    </section>

    <main class="container my-5">
        <h2 class="mb-4 fw-bold text-uppercase border-bottom pb-2" style="letter-spacing: 1px;"><?php echo $titulo_exibicao; ?></h2>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
            <?php foreach ($produtos as $p): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm transition hover-shadow">

                        <div class="p-4 d-flex align-items-center justify-content-center" style="height: 200px;">
                            <img src="assets/img/<?php echo $p['imagem_url']; ?>"
                                class="img-fluid"
                                alt="<?php echo $p['nome']; ?>"
                                style="max-height: 100%;"
                                onerror="this.src='assets/img/sem-foto.png'">
                        </div>

                        <div class="card-body d-flex flex-column text-center">
                            <p class="text-muted small mb-1 text-uppercase" style="letter-spacing: 1px;">
                                <?php echo $p['marca']; ?>
                            </p>
                            <h6 class="fw-bold mb-3"><?php echo $p['nome']; ?></h6>

                            <div class="mt-auto">
                                <p class="text-primary fw-bold h5 mb-3">
                                    R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?>
                                </p>

                                <a href="detalhe_produto.php?id=<?php echo $p['id_produto']; ?>"
                                    class="btn btn-outline-primary btn-outline-custom w-100 btn-sm mb-2">
                                    Ver Detalhes
                                </a>

                                <a href="adicionar_carrinho.php?id=<?php echo $p['id_produto']; ?>"
                                    class="btn btn-primary btn-primary-custom w-100 py-2">
                                    Comprar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="container my-5 text-center">
            <h4 class="fw-bold mb-4">Compre por marcas</h4>
            <div class="d-flex justify-content-center align-items-center gap-5 grayscale-logos">
                <img src="assets/img/logo-apple.png" alt="Apple" height="40">
                <img src="assets/img/logo-samsung.png" alt="Samsung" height="40">
                <img src="assets/img/logo-motorola.png" alt="Motorola" height="40">
                <img src="assets/img/logo-xiaomi.png" alt="Xiaomi" height="40">
                <img src="assets/img/logo-lg.png" alt="LG" height="40">
                <img src="assets/img/logo-huawei.png" alt="Huawei" height="40">
                <img src="assets/img/logo-poco.png" alt="Poco" height="40">
            </div>
        </div>

    </main>
    <!--Aqui chama o arquivo do rodapé separado para ajudar na manutenção e organização do código-->
    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

</body>

</html>