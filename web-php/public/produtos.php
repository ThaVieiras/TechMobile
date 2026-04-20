<?php
session_start();
// Sobe dois níveis (../..) para sair de public e web-php
require_once __DIR__ . '/../../config/database.php';

// Ações dos dados que vêm da URL (Header ou Menu)
$categoria = $_GET['categoria'] ?? null;
$busca = $_GET['busca'] ?? null;

// SE o usuário digitou algo na busca
if ($busca) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE ativo = 1 AND nome LIKE ?");
    $stmt->execute(["%$busca%"]);
}
// SE NÃO, se o usuário clicou em uma categoria
elseif ($categoria) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE ativo = 1 AND categoria = ?");
    $stmt->execute([$categoria]);
}
// SE NÃO tiver busca nem categoria, mostra tudo
else {
    $stmt = $pdo->query("SELECT * FROM produtos WHERE ativo = 1");
}

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lógica para definir o título da página qd usuário clicar em uma categoria ou fizer uma buscater
$titulo_exibicao = "Nossos Produtos";

if (isset($_GET['categoria'])) {
    $cat = $_GET['categoria'];

    // Mapeamento de nomes para exibição (Tratamento de Grafia)
    $nomes_formatados = [
        'acessorios'     => 'Acessórios',
        'smartphone'     => 'Smartphones',
        'recondicionado' => 'Recondicionados',
        'oferta'         => 'Ofertas especiais'
    ];

    // Se existir no mapa, usa o nome bonito. Se não, apenas capitaliza.
    $titulo_exibicao = $nomes_formatados[$cat] ?? ucfirst($cat);
} elseif (isset($_GET['busca'])) {
    $titulo_exibicao = "Resultados para: " . htmlspecialchars($_GET['busca']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techmobile - Loja</title>
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