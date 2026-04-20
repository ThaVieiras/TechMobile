<?php
// Certifique-se de que a sessão já foi iniciada na index.php ou inicie aqui se necessário
?>
<!-- <style>
    /* 1. Top Bar TechMobile */
    .top-bar-tech {
        background-color: #1a1a1a !important;
        color: #FDC500 !important;
        font-size: 11px;
        padding: 6px 0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* 2. Cabeçalho Principal */
    .header-tech {
        background-color: #3D0066 !important; /* Roxo Profundo */
        border-bottom: 3px solid #FDC500 !important; /* Dourado */
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    /* 3. Busca TechMobile */
    .search-input-tech {
        border-radius: 50px !important;
        background-color: rgba(255, 255, 255, 0.15) !important;
        border: 1px solid #FDC500 !important;
        color: white !important;
        padding: 10px 25px !important;
    }

    .search-input-tech:focus {
        background-color: white !important;
        color: #3D0066 !important;
        box-shadow: 0 0 15px rgba(253, 197, 0, 0.4) !important;
        outline: none;
    }

    /* 4. Ícones e Links */
    .nav-icon-tech {
        color: #FDC500 !important;
        font-size: 1.3rem;
        transition: 0.3s;
        text-decoration: none;
    }

    .nav-link-tech {
        color: white !important;
        font-weight: 700 !important;
        font-size: 13px;
        text-decoration: none;
        transition: 0.3s;
    }

    .nav-link-tech:hover {
        color: #FDC500 !important;
    }
</style>-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techmobile Celulares - <?php echo $titulo_exibicao; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para os ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    <!-- Barra Superior -->
    <div class="top-bar-techmobile text-center">
        Tecnologia a um clique de distância.
    </div>

    <!-- Cabeçalho Principal -->
    <header class="header-techmobile py-3">
        <link rel="stylesheet" href="assets/css/style.css">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-md-3">
                    <a href="index.php">
                        <!-- Lembre-se de trocar para logoNexus.png quando o branding estiver pronto -->
                        <img src="assets/img/logo-TechMobile3.png" alt="TechMobile" class="logo-header">
                    </a>
                </div>

                <!-- Busca -->
                <div class="col-md-6">
                    <form action="produtos.php" method="GET">
                        <div class="input-group">
                            <input type="text" name="busca" class="form-control search-input-techmobile"
                                placeholder="Buscar produtos por modelos"
                                value="<?php echo $_GET['busca'] ?? ''; ?>">
                            <button type="submit" class="btn btn-outline-techmobile border-0" style="background: transparent;">
                                <i class="fa-solid fa-magnifying-glass text-gold"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Ícones e Usuário -->
                <div class="col-md-3 d-flex justify-content-end align-items-center gap-4">
                    <a href="favoritos.php" class="nav-icon-techmobile" title="Favoritos"><i class="fa-regular fa-heart"></i></a>

                    <a href="carrinho.php" class="nav-icon-techmobile position-relative">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span class="badge bg-gold text-techmobile rounded-pill position-absolute top-0 start-100 translate-middle" style="font-size: 0.6rem;">
                            <?php echo count($_SESSION['carrinho'] ?? []); ?>
                        </span>
                    </a>

                    <div class="vr-header vr mx-2 bg-gold"></div>

                    <div class="user-menu d-flex flex-column lh-sm">
                        <?php if (isset($_SESSION['cliente_id'])): ?>
                            <span class="small text-white">Olá, <a href="minha_conta.php" class="text-gold fw-bold text-decoration-none">
                                    <?php echo explode(' ', $_SESSION['cliente_nome'])[0]; ?>
                                </a>
                            </span>
                            <a href="limpar.php" class="text-white extra-small text-decoration-none opacity-75">Sair</a>
                        <?php else: ?>
                            <a href="login.php" class="nav-link-techmobile small">Minha Conta</a>
                            <a href="cadastro.php" class="text-white text-decoration-none extra-small opacity-50">Cadastre-se</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Categorias -->
            <div class="d-flex justify-content-center gap-5 mt-3">
                <a href="produtos.php?categoria=smartphone" class="nav-link-techmobile">SMARTPHONE</a>
                <a href="produtos.php?categoria=acessorios" class="nav-link-techmobile">ACESSÓRIOS</a>
                <a href="produtos.php?categoria=recondicionado" class="nav-link-techmobile">RECONDICIONADOS</a>
                <a href="produtos.php?categoria=oferta" class="nav-link-techmobile text-gold">OFERTAS</a>
            </div>
        </div>
    </header>

</body>