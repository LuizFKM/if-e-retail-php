<!doctype html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Produtos — IF Retail</title>
</head>
<?php require_once __DIR__ . "/../templates/template-menu-cliente.php" ?>
<body>

<div class="container py-5">
    <h2 class="page-title">Nossos Produtos</h2>

    <?php if (empty($produtos)): ?>
        <p class="text-muted">Nenhum produto disponível no momento.</p>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm" style="border-color:var(--line);">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold" style="color:var(--coffee);">
                                <?= htmlspecialchars($produto->getDescricao()) ?>
                            </h6>
                            <p class="card-text text-muted small">
                                Estoque: <?= (int) $produto->getQuantidade() ?>
                            </p>
                            <p class="fw-bold mt-auto mb-3" style="color:var(--amber);font-size:1.1rem;">
                                R$ <?= number_format($produto->getPrecoUnitario(), 2, ',', '.') ?>
                            </p>

                            <div class="d-flex gap-2">
                                <!-- Botão de favoritar: toggle via POST -->
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
                                    <!-- Não logado: coração leva para o login -->
                                    <a href="<?= BASE_URL . '/login' ?>"
                                       class="btn btn-sm"
                                       style="color:var(--coffee);border:1px solid var(--line);"
                                       title="Faça login para favoritar">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                <?php endif; ?>

                                <!-- Botão adicionar ao carrinho -->
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
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>
