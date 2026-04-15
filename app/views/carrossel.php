<style>
    /* Trava a altura de todos os slides para serem idênticos */
    .nexus-item {
        height: 450px;
        /* Altura fixa para todos */
        border-radius: 0px;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    /* Garante que a imagem ocupe o espaço sem deformar */
    .nexus-img-container {
        height: 300px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .nexus-img-container img {
        max-height: 100%;
        width: auto;
        object-fit: contain;
    }

    .btn-nexus {
        background-color: #FF5733 !important;
        border: none;
        color: white !important;
        border-radius: 50px;
        transition: 0.3s;
    }

</style>

<div id="nexusHomeCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#nexusHomeCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#nexusHomeCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#nexusHomeCarousel" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="nexus-item p-5" style="background: linear-gradient(135deg, #240046 0%, #1a0035 60%, #FF5733 100%);">
                
                <div class="row w-100 align-items-center">
                    <div class="col-md-6 nexus-img-container">
                        <img src="assets/img/iphone17-pro.png" alt="Lançamento">
                    </div>
                    <div class="col-md-6 text-white">
                        <h1 class="display-5 fw-bold">Nova Era de Conexão</h1>
                        <p class="lead text-white-50">Sua conexão, sua energia. iPhone 17 Pro.</p>
                        <a href="produtos.php?busca=iphone" class="btn btn-nexus btn-lg px-5">Ver Lançamento</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="nexus-item p-5" style="background: linear-gradient(135deg, #FF5733 0%, #E04B2B 60%, #240046 100%);">
                <div class="row w-100 align-items-center">
                    <div class="col-md-6 nexus-img-container">
                        <img src="assets/img/acessorio2-sem-fundo.png" alt="Acessórios">
                    </div>
                    <div class="col-md-6 text-white">
                        <h1 class="display-5 fw-bold">Energia Extra</h1>
                        <p class="lead text-white-50">Curadoria premium de acessórios mobile.</p>
                        <a href="produtos.php?categoria=acessorio" class="btn btn-dark btn-lg px-5 rounded-pill">Explorar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="nexus-item p-5" style="background: linear-gradient(135deg, #440066 35%, #240046 100%);">
                <div class="row w-100 align-items-center">
                    <div class="col-md-6 nexus-img-container">
                        <img src="assets/img/GalaxyA54SemFundo.png" alt="Recondicionados">
                    </div>
                    <div class="col-md-6 text-white">
                        <h1 class="display-5 fw-bold">Smartphones Vitrine</h1>
                        <p class="lead text-white-50">Sustentabilidade e economia revisados pela Nexus.</p>
                        <a href="produtos.php?categoria=recondicionado" class="btn btn-nexus btn-lg px-5">Ver Ofertas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#nexusHomeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#nexusHomeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>