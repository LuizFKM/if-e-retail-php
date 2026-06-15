<?php /** @var \App\model\Cliente $cliente */ ?>

<style>
.card-produto {
    border: 1.5px solid var(--line);
    border-radius: 14px;
    transition: transform .18s, box-shadow .18s;
    overflow: hidden;
}
.card-produto:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(59,36,24,.12) !important;
}
.produto-thumb {
    background: var(--cream);
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid var(--line);
}
.btn-fav-remove {
    background: var(--cream);
    border: 1.5px solid var(--line);
    color: var(--amber);
    border-radius: 8px;
    transition: background .15s, color .15s;
}
.btn-fav-remove:hover {
    background: #fff0f0;
    border-color: #f5c6c6;
    color: #dc3545;
}
</style>

<!-- Cabeçalho da seção -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center gap-2">
        <div class="rounded-circle d-flex align-items-center justify-content-center"
             style="width:38px;height:38px;background:var(--cream);">
            <i class="bi bi-heart-fill" style="color:var(--amber);font-size:1.1rem;"></i>
        </div>
        <div>
            <h5 class="mb-0 fw-bold" style="color:var(--coffee);">Meus Favoritos</h5>
            <small class="text-muted">
                <?php if (!$favoritos->isEmpty()): ?>
                    <?= $favoritos->count() ?> produto<?= $favoritos->count() !== 1 ? 's' : '' ?> salvo<?= $favoritos->count() !== 1 ? 's' : '' ?>
                <?php else: ?>
                    Nenhum produto salvo ainda
                <?php endif; ?>
            </small>
        </div>
    </div>
    <?php if (!$favoritos->isEmpty()): ?>
        <a href="<?= BASE_URL . '/produtos' ?>" class="btn btn-amber btn-sm rounded-pill px-3">
            <i class="bi bi-shop me-1"></i>Ver mais produtos
        </a>
    <?php endif; ?>
</div>

<?php if ($favoritos->isEmpty()): ?>
    <!-- Estado vazio -->
    <div class="text-center py-5 px-3">
        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
             style="width:90px;height:90px;background:var(--cream);border:2px dashed var(--line);">
            <i class="bi bi-heart" style="font-size:2.5rem;color:var(--amber);"></i>
        </div>
        <h6 class="fw-bold mb-1" style="color:var(--coffee);">Sua lista de favoritos está vazia</h6>
        <p class="text-muted small mb-4">Explore nossa loja e salve os produtos que você mais gosta.</p>
        <a href="<?= BASE_URL . '/produtos' ?>" class="btn btn-amber rounded-pill px-4">
            <i class="bi bi-shop me-1"></i>Explorar produtos
        </a>
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($favoritos as $produto): ?>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="card-produto card h-100 shadow-sm">

                    <!-- Thumbnail do produto -->
                    <div class="produto-thumb">
                        <i class="bi bi-box-seam" style="font-size:3rem;color:var(--line);"></i>
                    </div>

                    <div class="card-body d-flex flex-column p-3">
                        <!-- Badge de estoque -->
                        <?php if ($produto->getQuantidade() > 0): ?>
                            <span class="badge rounded-pill mb-2 align-self-start"
                                  style="background:var(--cream);color:var(--brown);font-size:.7rem;">
                                <i class="bi bi-check-circle me-1"></i>Em estoque
                            </span>
                        <?php else: ?>
                            <span class="badge rounded-pill bg-secondary mb-2 align-self-start"
                                  style="font-size:.7rem;">
                                <i class="bi bi-x-circle me-1"></i>Esgotado
                            </span>
                        <?php endif; ?>

                        <h6 class="fw-bold mb-1 lh-sm" style="color:var(--coffee);">
                            <?= htmlspecialchars($produto->getDescricao()) ?>
                        </h6>

                        <p class="fw-bold mt-auto mb-3" style="color:var(--amber);font-size:1.15rem;">
                            R$ <?= number_format($produto->getPrecoUnitario(), 2, ',', '.') ?>
                        </p>

                        <div class="d-flex gap-2">
                            <form method="POST"
                                  action="<?= BASE_URL . '/favoritos/' . $produto->getID() . '/toggle' ?>">
                                <button type="submit" class="btn btn-fav-remove btn-sm px-2"
                                        title="Remover dos favoritos">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </form>
                            <form method="POST"
                                  action="<?= BASE_URL . '/carrinho/adicionar/' . $produto->getID() ?>"
                                  class="flex-grow-1">
                                <button type="submit" class="btn btn-amber btn-sm w-100 rounded-pill"
                                        <?= $produto->getQuantidade() <= 0 ? 'disabled' : '' ?>>
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
