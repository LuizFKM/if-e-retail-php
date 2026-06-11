<div class="d-flex">
    <aside class="sidebar d-flex flex-column p-3 gap-2">

        <a class="brand d-flex align-items-center gap-2 mb-2" href="<?= BASE_URL ?>">
            <i class="bi bi-shop fs-5"></i> IF-E-RETAIL
        </a>

        <hr>

        <span class="section-label px-2">Menu</span>

        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?= str_contains($_SERVER['REQUEST_URI'], '/produtos') ? 'active' : '' ?>"
                   href="<?= BASE_URL . '/painel-administrativo/produtos' ?>">
                    <i class="bi bi-box-seam"></i> Produtos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?= str_contains($_SERVER['REQUEST_URI'], '/pedidos') ? 'active' : '' ?>"
                   href="<?= BASE_URL . '/pedidos' ?>">
                    <i class="bi bi-cart3"></i> Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?= str_contains($_SERVER['REQUEST_URI'], '/admin') ? 'active' : '' ?>"
                   href="<?= BASE_URL . '/admin' ?>">
                    <i class="bi bi-person-badge"></i> Funcionários
                </a>
            </li>
        </ul>

        <hr>

        <span class="section-label px-2">Cadastros</span>

        <div class="d-flex flex-column gap-2 px-1">
            <a href="<?= BASE_URL . '/produtos/novo' ?>" class="btn btn-amber btn-sm d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i> Novo Produto
            </a>
            <a href="<?= BASE_URL . '/clientes/novo' ?>" class="btn btn-amber btn-sm d-flex align-items-center gap-2">
                <i class="bi bi-person-plus"></i> Novo Cliente
            </a>
            <a href="<?= BASE_URL . '/admin/novo' ?>" class="btn btn-amber btn-sm d-flex align-items-center gap-2">
                <i class="bi bi-person-badge"></i> Novo Funcionário
            </a>
        </div>

        <hr>

        <div class="mt-auto px-1">
            <small class="text-secondary">© <?= date('Y') ?> IF-E-RETAIL</small>
        </div>

    </aside>

    <div class="main-content">
