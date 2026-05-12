<?php $qtdCarrinho = array_sum($_SESSION['carrinho'] ?? []); ?>
<nav class="navbar navbar-loja navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL . '/loja' ?>">
            <i class="bi bi-shop"></i> IF-E-RETAIL
        </a>

        <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navLoja">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navLoja">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL . '/loja' ?>">
                        <i class="bi bi-grid me-1"></i>Produtos
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <a href="<?= BASE_URL . '/loja/carrinho' ?>" class="btn btn-amber position-relative">
                    <i class="bi bi-cart3"></i>
                    <?php if ($qtdCarrinho > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                              style="background-color: var(--coffee); color: var(--amber);">
                            <?= $qtdCarrinho ?>
                        </span>
                    <?php endif; ?>
                </a>

                <?php if (!empty($_SESSION['usuario_id'])): ?>
                    <span class="text-secondary small">Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
                    <a href="<?= BASE_URL . '/logout' ?>" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL . '/login' ?>" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-person"></i> Entrar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<?php if (!empty($_SESSION['flash'])): ?>
<div class="container mt-3">
    <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['tipo']) ?> alert-dismissible fade show">
        <i class="bi bi-<?= $_SESSION['flash']['tipo'] === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
        <?= htmlspecialchars($_SESSION['flash']['msg']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php unset($_SESSION['flash']); endif; ?>
