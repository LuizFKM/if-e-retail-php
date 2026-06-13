<?php /** @var \App\model\Cliente $cliente */ ?>

<h5 class="fw-bold mb-4" style="color:var(--coffee);">
    <i class="bi bi-heart-fill me-2" style="color:var(--amber);"></i>Meus Favoritos
</h5>

<?php if ($favoritos->isEmpty()): ?>
    <div class="text-center py-5">
        <i class="bi bi-heart" style="font-size:3rem;color:var(--amber);"></i>
        <p class="mt-3 text-muted">Você ainda não favoritou nenhum produto.</p>
        <a href="<?= BASE_URL . '/produtos' ?>" class="btn btn-amber mt-2">
            <i class="bi bi-shop me-1"></i>Explorar produtos
        </a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($favoritos as $produto): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm" style="border-color:var(--line);">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold" style="color:var(--coffee);">
                            <?= htmlspecialchars($produto->getDescricao()) ?>
                        </h6>
                        <p class="fw-bold mt-auto mb-3" style="color:var(--amber);font-size:1.1rem;">
                            R$ <?= number_format($produto->getPrecoUnitario(), 2, ',', '.') ?>
                        </p>

                        <div class="d-flex gap-2">
                            <!-- Remover dos favoritos -->
                            <form method="POST"
                                  action="<?= BASE_URL . '/favoritos/' . $produto->getID() . '/toggle' ?>">
                                <button type="submit"
                                        class="btn btn-sm"
                                        style="color:var(--amber);border:1px solid var(--line);"
                                        title="Remover dos favoritos">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </form>

                            <!-- Adicionar ao carrinho -->
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
