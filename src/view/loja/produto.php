<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/templates/template-head.php" ?>
    <title><?= htmlspecialchars($produto->getDescricao()) ?> — IF-E-RETAIL</title>
</head>
<body>
    <?php require_once __DIR__ . "/templates/template-nav.php" ?>

    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL . '/loja' ?>" style="color: var(--amber);">Loja</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($produto->getDescricao()) ?></li>
            </ol>
        </nav>

        <div class="row g-5 align-items-start">
            <div class="col-md-5 text-center">
                <div class="rounded-3 p-5 d-flex align-items-center justify-content-center"
                     style="background-color: var(--cream); min-height: 300px;">
                    <i class="bi bi-box-seam" style="font-size: 8rem; color: var(--amber);"></i>
                </div>
            </div>

            <div class="col-md-7">
                <h1 class="fw-bold mb-2" style="color: var(--coffee);">
                    <?= htmlspecialchars($produto->getDescricao()) ?>
                </h1>

                <p class="produto-preco mb-1">
                    R$ <?= number_format($produto->getPrecoUnitario(), 2, ',', '.') ?>
                </p>

                <span class="badge badge-estoque mb-4">
                    <?= $produto->getQuantidade() > 0 ? $produto->getQuantidade() . ' em estoque' : 'Indisponível' ?>
                </span>

                <?php if ($produto->getQuantidade() > 0): ?>
                <form method="POST" action="<?= BASE_URL . '/loja/carrinho/' . $produto->getID() . '/adicionar' ?>">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <label class="fw-semibold">Quantidade:</label>
                        <input type="number" name="quantidade" value="1"
                               min="1" max="<?= $produto->getQuantidade() ?>"
                               class="form-control" style="width: 80px; border-color: var(--line);">
                    </div>
                    <button type="submit" class="btn btn-amber btn-lg w-100">
                        <i class="bi bi-cart-plus me-2"></i> Adicionar ao carrinho
                    </button>
                </form>
                <?php else: ?>
                <button class="btn btn-secondary btn-lg w-100" disabled>Indisponível</button>
                <?php endif; ?>

                <hr style="border-color: var(--line); margin: 1.5rem 0;">
                <a href="<?= BASE_URL . '/loja' ?>" class="text-decoration-none" style="color: var(--amber);">
                    <i class="bi bi-arrow-left me-1"></i> Voltar para a loja
                </a>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . "/templates/template-rodape.php" ?>
</body>
</html>
