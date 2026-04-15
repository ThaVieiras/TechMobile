<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<header class="p-3 bg-dark text-white sticky-top shadow-sm">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">
            
            <div class="d-flex align-items-center">
                <button class="btn text-white border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateralNexus">
                    <i class="fa-solid fa-bars fs-4"></i>
                    <span class="d-none d-md-block fw-bold">MENU</span>
                </button>

                <a href="index.php" class="ms-4">
                    <img src="assets/img/logo.png" alt="Nexus Arena" height="35" onerror="this.src='https://via.placeholder.com/120x35?text=NEXUS+ARENA'">
                </a>
            </div>

            <div class="flex-grow-1 mx-4" style="max-width: 600px;">
                <div class="input-group position-relative">
                    <input type="search" class="form-control rounded-pill ps-4" placeholder="O que deseja hoje?">
                    <button class="btn position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent pe-3" style="z-index: 5;">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex align-items-center gap-4">
                
                <div class="dropdown d-none d-lg-block">
                    <span class="small cursor-pointer d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        <i class="fa-solid fa-location-dot text-primary"></i>
                        <span id="cepTexto">Informe seu CEP</span>
                    </span>
                    <div class="dropdown-menu p-3 shadow-lg" style="width: 250px;">
                        <p class="small text-muted mb-2">Digite seu CEP para frete:</p>
                        <div class="input-group">
                            <input type="text" id="inputCep" class="form-control" placeholder="00000-000">
                            <button class="btn btn-dark" onclick="salvarCEP()">OK</button>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="text-white" title="Minha Conta"><i class="fa-regular fa-user fs-5"></i></a>
                    <a href="#" class="text-white" title="Favoritos"><i class="fa-regular fa-heart fs-5"></i></a>
                    <a href="carrinho.php" class="text-white position-relative">
                        <i class="fa-solid fa-bag-shopping fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">0</span>
                    </a>
                    <a href="contato.php" class="text-white"><i class="fa-solid fa-headset fs-5"></i></a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="menuLateralNexus" aria-labelledby="labelMenu">
  <div class="offcanvas-header border-bottom border-secondary">
    <h5 class="offcanvas-title" id="labelMenu">NEXUS Celulares</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-unstyled fw-bold fs-5">
        <li class="mb-3">
            <a href="produtos.php?categoria=smartphone" class="text-white text-decoration-none d-flex align-items-center gap-3">
                <i class="fa-solid fa-mobile-screen-button"></i> Smartphones
            </a>
        </li>
        
        <li class="mb-3">
            <a href="produtos.php?cat=apple" class="text-white text-decoration-none d-flex align-items-center gap-3">
                <i class="fa-brands fa-apple"></i> Apple
            </a>
        </li>
        
        <li class="mb-3">
            <a href="produtos.php?categoria=acessorios" class="text-white text-decoration-none d-flex align-items-center gap-3">
                <i class="fa-solid fa-plug"></i> Acessórios
            </a>
        </li>
        
        <li class="mb-3">
            <a href="produtos.php?categoria=recondicionado" class="text-white text-decoration-none d-flex align-items-center gap-3">
                <i class="fa-solid fa-arrows-rotate"></i> Recondicionados
            </a>
        </li>

        <li class="mb-3">
            <a href="produtos.php?categoria=oferta" class="text-white text-decoration-none d-flex align-items-center gap-3 text-warning">
                <i class="fa-solid fa-tag"></i> Ofertas especiais
            </a>
        </li>
        
        <hr class="border-secondary">
        
        <li class="mb-3">
            <a href="contato.php" class="text-white text-decoration-none d-flex align-items-center gap-3">
                <i class="fa-solid fa-headset"></i> Fale Conosco
            </a>
        </li>
    </ul>
</div>
</div>

<script>
// Função para o CEP funcionar sem banco de dados por enquanto
function salvarCEP() {
    const cep = document.getElementById('inputCep').value;
    if(cep.length >= 8) {
        document.getElementById('cepTexto').innerText = "CEP: " + cep;
        // Fecha o dropdown manualmente se desejar
    } else {
        alert("Digite um CEP válido");
    }
}
</script>

<!--<nav class="bg-white border-bottom py-2 shadow-sm d-none d-md-block">
    <div class="container d-flex justify-content-center gap-5">
        <a href="produtos.php?cat=smartphone" class="cat-link active">SMARTPHONES</a>
        <a href="produtos.php?cat=apple" class="cat-link">APPLE</a>
        <a href="produtos.php?cat=acessorios" class="cat-link">ACESSÓRIOS</a>
        <a href="produtos.php?cat=recondicionados" class="cat-link text-muted">RECONDICIONADOS</a>
        <a href="produtos.php?cat=ofertas" class="cat-link text-coral fw-bold">OFERTAS</a>
    </div>
</nav>-->

<style>
    /* Estética Nexus Arena */
    .action-icon { transition: 0.2s ease-in-out; color: #333 !important; }
    .action-icon:hover { color: #FF5733 !important; transform: translateY(-2px); }
    
    .cat-link {
        text-decoration: none;
        color: #333;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
        transition: 0.2s;
    }
    .cat-link:hover { color: #FF5733; }
    .cat-link.active { border-bottom: 2px solid #240046; padding-bottom: 2px; }
    .text-coral { color: #FF5733 !important; }

    /* Estilo do Dropdown para não ter seta */
    .dropdown-toggle::after { display: none; }
    
    /* Input Search Focus */
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.2rem rgba(36, 0, 70, 0.05);
        border: 1px solid #ddd !important;
    }
</style>