<?php
if (!session_id()) session_start();
// Tentativa de include silencioso para não poluir a tela com Warnings
@include 'header.php';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Animação de subir e descer */
    .floating-animation {
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-25px); } /* Sobe 25 pixels */
        100% { transform: translateY(0px); }
    }
    .bg-gradient-nexus {
        background: linear-gradient(135deg, #252525ff 0%, #240046 100%);
    }
    
    /* Estilo do Botão Comprar */
    .btn-nexus-buy {
        background-color: white;
        color: #240046;
        border: none;
        transition: all 0.3s ease; /* Faz a transição de cor ser suave */
        font-weight: bold;
    }

    /* Efeito ao passar o mouse (Hover) */
    .btn-nexus-buy:hover {
        background-color: #FF5733 !important; /* Laranja Nexus */
        color: white !important;
        transform: scale(1.1); /* Dá um leve zoom no botão */
        box-shadow: 0 10px 20px rgba(255, 87, 51, 0.4); /* Brilho laranja ao redor */
    }

    .text-nexus { color: #240046; }
</style>

<section class="vh-100 d-flex align-items-center text-white bg-gradient-nexus">
    <div class="container text-center">
        <h1 class="display-1 fw-bold mb-3" style="letter-spacing: -2px;">iPhone 17 Pro</h1>
        <p class="lead fs-3 opacity-75 mb-5">Pro. Além da imaginação.</p>
        <img src="assets/img/iphone-17LancaSemFund.png" class="img-fluid floating-animation" style="max-height: 450px;" alt="iPhone 17 Pro">
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-5 text-center">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-5 rounded-4 bg-light shadow-sm">
                    <i class="fa-solid fa-microchip fa-3x mb-3 text-nexus"></i>
                    <h4 class="fw-bold">Chip A19 Bionic</h4>
                    <p class="text-muted">Potência extrema para IA.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-5 rounded-4 bg-light shadow-sm border-top border-4 border-primary">
                    <i class="fa-solid fa-camera fa-3x mb-3 text-nexus"></i>
                    <h4 class="fw-bold">48MP Pro</h4>
                    <p class="text-muted">Cinema no seu bolso.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-5 rounded-4 bg-light shadow-sm">
                    <i class="fa-solid fa-bolt fa-3x mb-3 text-nexus"></i>
                    <h4 class="fw-bold">Titânio</h4>
                    <p class="text-muted">Leveza e resistência.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-5">
        <h2 class="text-center fw-bold mb-5 display-6">O que há por dentro.</h2>

        <div class="row g-5 justify-content-center">
            <div class="col-md-5 border-bottom pb-4 d-flex justify-content-between align-items-center">
                <span class="text-muted text-uppercase small fw-bold">Ecrã</span>
                <span class="fw-bold">Super Retina XDR 6.7"</span>
            </div>

            <div class="col-md-5 border-bottom pb-4 d-flex justify-content-between align-items-center">
                <span class="text-muted text-uppercase small fw-bold">Resistência</span>
                <span class="fw-bold">Classificação IP68</span>
            </div>

            <div class="col-md-5 border-bottom pb-4 d-flex justify-content-between align-items-center">
                <span class="text-muted text-uppercase small fw-bold">Vídeo</span>
                <span class="fw-bold">4K Dolby Vision</span>
            </div>

            <div class="col-md-5 border-bottom pb-4 d-flex justify-content-between align-items-center">
                <span class="text-muted text-uppercase small fw-bold">Conexão</span>
                <span class="fw-bold">USB‑C 3.0 (Wi-Fi 7)</span>
            </div>
        </div>
    </div>
</section>

<section class="py-5 mb-5">
    <div class="container text-center">
        <div class="card bg-gradient-nexus text-white p-5 rounded-5 shadow-lg border-0">
            <h3 class="display-6 fw-bold mb-4">A partir de R$ 9.499</h3>
            <p class="mb-4 opacity-75">Disponível em Titânio Natural, Preto, Branco e Deserto.</p>
            <div class="d-flex justify-content-center gap-3">
                 <a href="carrinho.php?acao=add&id=1" class="btn btn-nexus-buy btn-lg px-5 py-3 rounded-pill shadow">
                    COMPRAR AGORA
                </a>
            </div>
        </div>
    </div>
</section>


<?php @include __DIR__ . '/footer.php'; ?>