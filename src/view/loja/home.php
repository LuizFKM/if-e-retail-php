<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/templates/template-head.php" ?>
    <title>IF-E-RETAIL — Loja</title>
</head>
<body>
    <?php require_once __DIR__ . "/templates/template-nav.php" ?>

    <div class="container py-5">
        <h2 class="fw-bold mb-1" style="color: var(--coffee);">Nossos Produtos</h2>
        <p class="text-muted mb-4">Encontre o que você precisa</p>

        <?php if (!empty($produtos)): ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
            <?php foreach ($produtos as $produto): ?>
            <div class="col">
                <div class="card card-produto h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2 text-center" style="font-size: 3rem; color: var(--amber);">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h5 class="card-title"><?= htmlspecialchars($produto->getDescricao()) ?></h5>
                        <p class="preco mt-auto mb-1">
                            R$ <?= number_format($produto->getPrecoUnitario(), 2, ',', '.') ?>
                        </p>
                        <span class="badge badge-estoque mb-3">
                            <?= $produto->getQuantidade() > 0 ? $produto->getQuantidade() . ' em estoque' : 'Indisponível' ?>
                        </span>
                        <a href="<?= BASE_URL . '/loja/produto/' . $produto->getID() ?>"
                           class="btn btn-amber w-100">
                            <i class="bi bi-eye me-1"></i> Ver produto
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 4rem; color: var(--line);"></i>
            <p class="mt-3 text-muted">Nenhum produto disponível no momento.</p>
        </div>
        <?php endif; ?>
    </div>

    <?php require_once __DIR__ . "/templates/template-rodape.php" ?>
</body>
</html>
