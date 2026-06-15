<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>IF E-Retail - Início</title>
</head>
<body>
    <?php require_once __DIR__ . "/../templates/template-menu-cliente.php" ?>
        <section class="hero w-100 pt-5">
            <div class="container hero-content mt-5">
                <div class="row">
                    <div class="col">
                        <div id="tag" class="border-1 rounded-5 mb-3 bi bi-stars">Nova Coleção 2026</div>
                        <p class="slogan display-4">Estilo que fala <br> por <span>você</span></p>
                        <p class="slogan-two mb-5">Peças selecionadas com qualidade premium, entrega rápida e experiência de compra incomparável.</p>
                        <a role="button" class="button-style-1">Explorar coleção</a>
                        <a role="button" class="button-style-2">Ver ofertas</a>
                    </div>
                    <div class="col">
                        <div id="carouselExample" class="carousel slide carousel-dark" data-bs-ride="carousel">
                            <div class="carousel-inner pb-5"> <div class="carousel-item active">
                                    <div class="d-flex justify-content-center">
                                        <div class="card" style="width: 18rem;">
                                            <img src="https://placehold.co/200" class="card-img-top" alt="Imagem do Produto 1">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Nome do Produto 1</h5>
                                                <p class="card-text fw-bold">R$ 99,90</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="d-flex justify-content-center">
                                        <div class="card" style="width: 18rem;">
                                            <img src="https://placehold.co/200" class="card-img-top" alt="Imagem do Produto 2">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Nome do Produto 2</h5>
                                                <p class="card-text fw-bold">R$ 149,90</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="d-flex justify-content-center">
                                        <div class="card" style="width: 18rem;">
                                            <img src="https://placehold.co/200" class="card-img-top" alt="Imagem do Produto 3">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Nome do Produto 3</h5>
                                                <p class="card-text fw-bold">R$ 199,90</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Próximo</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    <section class="em-destaque">

    </section>
    <?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>
