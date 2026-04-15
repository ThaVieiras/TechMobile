<header class="py-2 bg-white border-bottom sticky-top shadow-sm">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center g-0">
            
            <div class="col-md-3 d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-link text-nexus text-decoration-none d-flex align-items-center gap-2 fw-bold p-0" 
                            type="button" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-bars fa-lg"></i> <span class="d-none d-lg-inline">MENU</span>
                    </button>
                    <ul class="dropdown-menu shadow border-0 mt-3 rounded-3 py-3" style="min-width: 250px;">
                        <li><a class="dropdown-item py-2" href="produtos.php?cat=smartphone"><i class="fa-solid fa-mobile-screen-button me-2 opacity-50"></i> Smartphones</a></li>
                        <li><a class="dropdown-item py-2" href="produtos.php?cat=apple"><i class="fa-brands fa-apple me-2 opacity-50"></i> Apple</a></li>
                        <li><a class="dropdown-item py-2" href="produtos.php?tipo=smartwatch"><i class="fa-brands fa-apple me-2 opacity-50"></i> Smartwatches</a></li>
                        <li><a class="dropdown-item py-2" href="produtos.php?tipo=tab"><i class="fa-brands fa-apple me-2 opacity-50"></i> Tablets</a></li>
                        <li><a class="dropdown-item py-2" href="produtos.php?tipo=cabo"><i class="fa-brands fa-apple me-2 opacity-50"></i> Cabos e Carregadores</a></li>
                        <li><a class="dropdown-item py-2" href="produtos.php?tipo=buds"><i class="fa-brands fa-apple me-2 opacity-50"></i> Fones de Ouvido</a></li>
                        <li><a class="dropdown-item py-2" href="produtos.php?cat=acessorios"><i class="fa-solid fa-headphones me-2 opacity-50"></i> Acessórios</a></li>
                        <li><a class="dropdown-item py-2" href="produtos.php?cat=recondicionados"><i class="fa-solid fa-recycle me-2 opacity-50"></i> Recondicionados</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger fw-bold" href="produtos.php?cat=ofertas"><i class="fa-solid fa-fire me-2"></i> Ofertas</a></li>
                    </ul>
                </div>

                <a href="index.php">
                    <img src="assets/img/NexusCelulares.png" alt="Nexus" style="width: 300px; height: 65px; object-fit: contain;">
                </a>
            </div>

            <div class="col-md-5">
                <form action="produtos.php" method="GET" class="position-relative">
                    <input type="text" name="busca" class="form-control border-0 rounded-pill ps-4" 
                           placeholder="O que deseja?" 
                           style="height: 36px; background-color: #f2f2f2; font-size: 0.85rem;">
                    <button class="btn position-absolute end-0 top-50 translate-middle-y me-2 border-0" type="submit">
                        <i class="fa-solid fa-magnifying-glass text-muted" style="font-size: 0.8rem;"></i>
                    </button>
                </form>
            </div>

            <div class="col-md-4 d-flex align-items-center justify-content-end gap-3 gap-lg-4">
                
                <div class="d-none d-xl-block text-muted text-end border-end pe-3" style="line-height: 1;">
                    <a href="#" class="text-decoration-none text-muted" style="font-size: 0.7rem;">
                        <i class="fa-solid fa-location-dot me-1"></i> Informe seu CEP <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.5rem;"></i>
                    </a>
                </div>

                <a href="#" class="text-dark action-icon" id="userDropdown" data-bs-toggle="dropdown">
                    <i class="fa-regular fa-circle-user fa-xl"></i>
                </a>

                <a href="carrinho.php" class="text-dark action-icon position-relative">
                    <i class="fa-solid fa-bag-shopping fa-xl"></i>
                    <?php if (!empty($_SESSION['carrinho'])): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.5rem;">
                            <?php echo array_sum($_SESSION['carrinho']); ?>
                        </span>
                    <?php endif; ?>
                </a>

                <a href="#" class="text-dark action-icon">
                    <i class="fa-solid fa-headset fa-xl"></i>
                </a>
            </div>

        </div>
    </div>
</header>

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