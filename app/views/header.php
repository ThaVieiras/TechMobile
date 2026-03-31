<style>
    .top-bar {
        background-color: #0e409dff; 
        color: white;
        font-size: 13px;
        padding: 8px 0;
        letter-spacing: 1px;
    }
    /* Estilo para os links do menu conforme o Wireframe */
    .nav-link-custom {
        color: #1a1a1a;
        text-decoration: none;
        font-weight: 800; /* Mais negrito */
        font-size: 15px;
        padding: 10px 15px;
        transition: 0.3s;
    }
    .nav-link-custom:hover {
        color: #0056b3;
    }
    .search-input {
        border-radius: 5px; /* Menos arredondado para bater com o design */
        background-color: #f1f3f4;
        border: 1px solid #ddd;
        padding: 10px 20px;
    }
    .user-links {
        font-size: 13px;
        color: #666;
    }
</style>

<div class="top-bar text-center">
    Tecnologia a um clique de distância.
</div>

<header class="bg-white border-bottom shadow-sm">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-md-2">
                <a href="index.php">
                    <img src="assets/img/logoTechMobile.png" alt="TechMobile" height="55">
                </a>
            </div>

            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control search-input" placeholder="Buscar produtos por modelos">
                    <button class="btn btn-outline-secondary border-0 bg-light">🔍</button>
                </div>
            </div>

            <div class="col-md-4 d-flex justify-content-end align-items-center gap-4">
                <a href="#" class="text-secondary fs-4">❤️</a>
                <a href="carrinho.php" class="text-secondary fs-4 position-relative">
                    🛒 <span class="badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle" style="font-size: 10px;">
                        <?php echo count($_SESSION['carrinho'] ?? []); ?>
                    </span>
                </a>
                <div class="user-links ms-2">
                    <?php if(isset($_SESSION['cliente_nome'])): ?>
                        Olá, <strong><?php echo explode(' ', $_SESSION['cliente_nome'])[0]; ?></strong> | 
                        <a href="limpar.php" class="text-decoration-none">Sair</a>
                    <?php else: ?>
                        <a href="login.php" class="text-muted text-decoration-none">Cadastra-se/Minha Conta</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-5 mt-3">
            <a href="produtos.php?categoria=smartphone" class="nav-link-custom">SMARTPHONE</a>
            <a href="produtos.php?categoria=acessorios" class="nav-link-custom">ACESSÓRIOS</a>
            <a href="produtos.php?categoria=recondicionados" class="nav-link-custom">RECONDICIONADOS</a>
            <a href="produtos.php?categoria=ofertas" class="nav-link-custom text-danger">OFERTAS</a>
        </div>
    </div>
</header>