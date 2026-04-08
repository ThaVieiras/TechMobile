<style>
    /* --- Novos Estilos para os Cards da Loja --- */
    .transition { 
        transition: all 0.3s ease; 
    }

    .hover-shadow:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 10px 20px rgba(0,0,0,0.12) !important; 
    }

    .btn-primary-custom { 
        background-color: #0d6efd; 
        border: none; 
        border-radius: 50px; 
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary-custom:hover { 
        background-color: #0a58ca; 
    }

    .btn-outline-custom {
        border-radius: 50px;
        font-weight: 600;
        border-width: 2px;
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
                <form action="produtos.php" method="GET">
                    <div class="input-group">
                        <input type="text" name="busca" class="form-control search-input"
                            placeholder="Buscar produtos por modelos"
                            value="<?php echo $_GET['busca'] ?? ''; ?>">
                        <button type="submit" class="btn btn-outline-secondary border-0 bg-light">🔍</button>
                    </div>
                </form>
            </div>

            <div class="col-md-4 d-flex justify-content-end align-items-center gap-4">
                <a href="#" class="text-secondary fs-4">❤️</a>
                <a href="carrinho.php" class="text-secondary fs-4 position-relative">
                    🛒 <span class="badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle" style="font-size: 10px;">
                        <?php echo count($_SESSION['carrinho'] ?? []); ?>
                    </span>
                </a>

                <div class="user-links ms-2">
                    <a href="contato.php" class="text-muted text-decoration-none me-3">Contato</a>
                    <?php if (isset($_SESSION['cliente_nome'])): ?>
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