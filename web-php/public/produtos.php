<?php
session_start();
// Sobe dois níveis (../..) para sair de public e web-php
require_once __DIR__ . '/../../config/database.php';

// Ações dos botões - smartfone, acessórios, etc
$categoria = $_GET['categoria'] ?? null;

if ($categoria) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE categoria = ? AND ativo = 1");
    $stmt->execute([$categoria]);
} else {
    $stmt = $pdo->query("SELECT * FROM produtos WHERE ativo = 1");
}
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta dos produtos no banco
$stmt = $pdo->query("SELECT id_produto, nome, marca, preco, imagem_url FROM produtos WHERE ativo = 1");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h2 class="mb-4">Destaques da Semana</h2>
        
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
            <?php foreach ($produtos as $p): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="bg-secondary-subtle d-flex align-items-center justify-content-center" style="height: 200px;">
                             <span class="text-muted">Foto do <?php echo $p['marca']; ?></span>
                        </div>
                        <div class="card-body text-center">
                            <h6 class="card-title text-truncate"><?php echo $p['nome']; ?></h6>
                            <p class="card-text fw-bold text-primary">
                                R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?>
                            </p>
                            <a href="add.php?id=<?php echo $p['id_produto']; ?>" class="btn btn-primary btn-sm w-100">
                                Adicionar ao carrinho
                            </a>
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