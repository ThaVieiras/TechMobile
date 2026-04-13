<div class="top-bar text-center">
    Tecnologia a um clique de distância.
</div>

<header class="bg-white border-bottom shadow-sm">
    <link rel="stylesheet" href="assets/css/style.css">
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

            <div class="col-md-4 d-flex justify-content-end align-items-center gap-3">
                <a href="#" class="text-decoration-none fs-5" title="Favoritos">❤️</a>

                <a href="carrinho.php" class="text-secondary position-relative me-2">
                    <span class="fs-4">🛒</span>
                    <span class="badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle" style="font-size: 0.6rem;">
                        <?php echo count($_SESSION['carrinho'] ?? []); ?>
                    </span>
                </a>

                <div class="vr mx-2 text-muted" style="height: 30px; opacity: 0.2;"></div>

                <div class="user-menu d-flex flex-column lh-sm">
                    <a href="contato.php" class="text-muted text-decoration-none small fw-bold hover-blue">Contato</a>
                    <?php if (isset($_SESSION['cliente_nome'])): ?>
                        <span class="small text-muted">Olá, <a href="minha_conta.php" class="text-primary fw-bold text-decoration-none"><?php echo explode(' ', $_SESSION['cliente_nome'])[0]; ?></a></span>
                        <a href="limpar.php" class="text-danger extra-small text-decoration-none">Sair</a>
                    <?php else: ?>
                        <a href="login.php" class="text-dark text-decoration-none small fw-bold hover-blue">Minha Conta</a>
                        <a href="cadastro.php" class="text-muted text-decoration-none extra-small">Cadastre-se</a>
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