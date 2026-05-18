<?php
if (!session_id()) session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iPhone 17 Pro - TechMobile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <!-- HERO -->
    <section class="min-vh-100 d-flex align-items-center text-white bg-gradient-techmobile pt-5">
        <div class="container text-center">
            <p class="text-uppercase small fw-bold opacity-50 mb-2">Novidade TechMobile</p>
            <h1 class="display-1 fw-bold mb-3" style="letter-spacing: -2px;">iPhone 17 Pro</h1>
            <p class="lead fs-3 opacity-75 mb-5">Pro. Além da imaginação.</p>
            <img src="assets/img/iphone-17LancaSemFund.png"
                 class="img-fluid floating-animation"
                 style="max-height: 450px;"
                 alt="iPhone 17 Pro">
            <div class="mt-5">
               <a href="add.php?id=4" class="btn btn-techmobile-buy btn-lg px-5 py-3 rounded-pill shadow">
                    <i class="fa-solid fa-cart-shopping me-2"></i> COMPRAR AGORA
                </a>
            </div>
        </div>
    </section>

    <!-- DIFERENCIAIS -->
    <section class="py-5 bg-white">
        <div class="container py-5 text-center">
            <p class="text-uppercase small fw-bold text-muted mb-2">Por que escolher</p>
            <h2 class="fw-bold text-techmobile mb-5">Feito para quem exige mais.</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-5 rounded-4 bg-light shadow-sm h-100">
                        <i class="fa-solid fa-microchip fa-3x mb-3 text-techmobile"></i>
                        <h4 class="fw-bold">Chip A19 Bionic</h4>
                        <p class="text-muted">O chip mais avançado já colocado num smartphone. Potência extrema para IA e jogos.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-5 rounded-4 shadow-sm h-100 border-top border-4 bg-light" style="border-color: var(--techmobile-secondary) !important;">
                        <i class="fa-solid fa-camera fa-3x mb-3 text-techmobile"></i>
                        <h4 class="fw-bold">Câmera 48MP Pro</h4>
                        <p class="text-muted">Cinema no seu bolso. Grave em 4K Dolby Vision com estabilização de nível profissional.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-5 rounded-4 bg-light shadow-sm h-100">
                        <i class="fa-solid fa-bolt fa-3x mb-3 text-techmobile"></i>
                        <h4 class="fw-bold">Titânio</h4>
                        <p class="text-muted">Design em titânio aeroespacial. O iPhone mais leve e resistente da história.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ESPECIFICAÇÕES -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <p class="text-uppercase small fw-bold text-muted text-center mb-2">Ficha Técnica</p>
            <h2 class="text-center fw-bold text-techmobile mb-5">O que há por dentro.</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-5">
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <span class="text-muted text-uppercase small fw-bold">Ecrã</span>
                        <span class="fw-bold">Super Retina XDR 6.7"</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <span class="text-muted text-uppercase small fw-bold">Chip</span>
                        <span class="fw-bold">A19 Bionic</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <span class="text-muted text-uppercase small fw-bold">Câmera</span>
                        <span class="fw-bold">48MP Principal + 12MP Ultra Wide</span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <span class="text-muted text-uppercase small fw-bold">Resistência</span>
                        <span class="fw-bold">Classificação IP68</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <span class="text-muted text-uppercase small fw-bold">Vídeo</span>
                        <span class="fw-bold">4K Dolby Vision</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <span class="text-muted text-uppercase small fw-bold">Conexão</span>
                        <span class="fw-bold">USB‑C 3.0 · Wi-Fi 7</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA FINAL -->
    <section class="py-5 mb-5">
        <div class="container text-center">
            <div class="card bg-gradient-techmobile text-white p-5 rounded-5 shadow-lg border-0">
                <p class="text-uppercase small opacity-50 fw-bold mb-2">Disponível agora</p>
                <h3 class="display-6 fw-bold mb-2">A partir de R$ 9.499</h3>
                <p class="mb-4 opacity-75">Em Titânio Natural, Preto, Branco e Deserto. Até 12x sem juros.</p>
                <div class="d-flex justify-content-center">
                    <a href="adicionar_carrinho.php?id=4"
                       class="btn btn-techmobile-buy btn-lg px-5 py-3 rounded-pill shadow">
                        <i class="fa-solid fa-cart-shopping me-2"></i> COMPRAR AGORA
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>