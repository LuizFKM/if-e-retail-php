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
            <div class="container">
                <p class="section-title">Em Destaque</p>
                <div class=" pb-5 em-destaque-content d-flex flex-wrap gap-4 justify-content-center">

                    <?php
                    if (!empty($produtos)):
                        foreach (array_slice($produtos, 0, 3) as $produto):
                            ?>
                            <div class="card" style="width: 18rem;">
                                <div class="card-body d-flex flex-column">
                                    <img class="mb-2" src="https://placehold.co/200" alt="imagem-do-produto">
                                    <h6 class="card-title fw-bold">
                                        <?= htmlspecialchars($produto->getDescricao()) ?>
                                    </h6>
                                    <p class="fw-bold mt-auto mb-3" >
                                        R$ <?= number_format($produto->getPrecoUnitario(), 2, ',', '.') ?>
                                    </p>

                                    <div class="d-flex gap-2">
                                        <?php $ehFavorito = in_array($produto->getID(), $favoritoIds ?? []); ?>
                                        <?php if (!empty($_SESSION['cliente_id'])): ?>
                                            <form method="POST"
                                                  action="<?= BASE_URL . '/favoritos/' . $produto->getID() . '/toggle' ?>">
                                                <button type="submit"
                                                        class="btn btn-sm"
                                                        style="color:<?= $ehFavorito ? 'var(--amber)' : 'var(--coffee)' ?>;border:1px solid var(--line);"
                                                        title="<?= $ehFavorito ? 'Remover dos favoritos' : 'Adicionar aos favoritos' ?>">
                                                    <i class="bi <?= $ehFavorito ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="<?= BASE_URL . '/login' ?>"
                                               class="btn btn-sm"
                                               style="color:var(--coffee);border:1px solid var(--line);"
                                               title="Faça login para favoritar">
                                                <i class="bi bi-heart"></i>
                                            </a>
                                        <?php endif; ?>

                                        <form method="POST"
                                              action="<?= BASE_URL . '/carrinho/adicionar/' . $produto->getID() ?>"
                                              class="flex-grow-1">
                                            <button type="submit" class="btn btn-amber btn-sm w-100">
                                                <i class="bi bi-cart-plus me-1"></i>Adicionar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endforeach;
                    else:
                        ?>
                        <p class="text-muted">Nenhum produto em destaque no momento.</p>
                    <?php endif; ?>
                </div>
            </div>
    </section>
    <?php require_once __DIR__ . "/../templates/template-footer.php" ?>
    <?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>
