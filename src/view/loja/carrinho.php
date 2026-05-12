<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/templates/template-head.php" ?>
    <title>Carrinho — IF-E-RETAIL</title>
</head>
<body>
    <?php require_once __DIR__ . "/templates/template-nav.php" ?>

    <div class="container py-5">
        <h2 class="fw-bold mb-4" style="color: var(--coffee);">
            <i class="bi bi-cart3 me-2"></i>Meu Carrinho
        </h2>

        <?php if (!empty($itens)): ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <?php foreach ($itens as $item): ?>
                <div class="carrinho-item d-flex align-items-center gap-3 p-3 mb-3">
                    <div class="text-center" style="width: 60px; color: var(--amber);">
                        <i class="bi bi-box-seam fs-2"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold" style="color: var(--coffee);">
                            <?= htmlspecialchars($item['produto']->getDescricao()) ?>
                        </h6>
                        <small class="text-muted">Qtd: <?= $item['quantidade'] ?></small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold" style="color: var(--amber);">
                            R$ <?= number_format($item['produto']->getPrecoUnitario() * $item['quantidade'], 2, ',', '.') ?>
                        </div>
                        <small class="text-muted">
                            R$ <?= number_format($item['produto']->getPrecoUnitario(), 2, ',', '.') ?> cada
                        </small>
                    </div>
                    <form method="POST" action="<?= BASE_URL . '/loja/carrinho/' . $item['produto']->getID() . '/remover' ?>">
                        <button type="button" class="btn btn-sm btn-outline-danger"
                                onclick="this.closest('form').submit()">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="col-lg-4">
                <div class="carrinho-total p-4">
                    <h5 class="fw-bold mb-3" style="color: var(--amber);">Resumo do pedido</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>R$ <?= number_format($subtotal, 2, ',', '.') ?></span>
                    </div>
                    <hr style="border-color: var(--coffee);">
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                        <span>Total</span>
                        <span style="color: var(--amber);">R$ <?= number_format($subtotal, 2, ',', '.') ?></span>
                    </div>
                    <a href="<?= BASE_URL . '/loja/checkout' ?>" class="btn btn-amber w-100 btn-lg">
                        <i class="bi bi-credit-card me-2"></i> Finalizar compra
                    </a>
                    <a href="<?= BASE_URL . '/loja' ?>" class="btn btn-outline-light w-100 mt-2">
                        <i class="bi bi-arrow-left me-1"></i> Continuar comprando
                    </a>
                </div>
            </div>
        </div>

        <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 5rem; color: var(--line);"></i>
            <h4 class="mt-3" style="color: var(--coffee);">Seu carrinho está vazio</h4>
            <a href="<?= BASE_URL . '/loja' ?>" class="btn btn-amber mt-3">
                <i class="bi bi-arrow-left me-1"></i> Ver produtos
            </a>
        </div>
        <?php endif; ?>
    </div>

    <?php require_once __DIR__ . "/templates/template-rodape.php" ?>
</body>
</html>
