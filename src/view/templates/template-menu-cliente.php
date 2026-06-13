<div class="menu-cliente sticky-top">
    <nav class="container nav d-flex justify-content-between align-items-center pt-4 pb-4">
        <div>
            <a class="navbar-brand" href="<?= BASE_URL . '/' ?>">IF Retail</a>
        </div>
        <div>
            <ul class="d-flex mb-0 gap-4 list-style-none list-unstyled">
                <li>
                    <a href="<?= BASE_URL . '/' ?>" role="button">Início</a>
                </li>
                <li>
                    <!-- Novo: href adicionado para a vitrine de produtos -->
                    <a href="<?= BASE_URL . '/produtos' ?>" role="button">Produtos</a>
                </li>
            </ul>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <!-- Novo: coração aponta para a aba de favoritos do perfil -->
            <a class="bi bi-heart" href="<?= BASE_URL . '/perfil/favoritos' ?>" title="Favoritos"></a>
            <!-- Novo: carrinho aponta para a página do carrinho -->
            <a class="bi bi-cart3" href="<?= BASE_URL . '/carrinho' ?>" title="Carrinho"></a>

            <?php if (!empty($_SESSION['cliente_id'])): ?>
                <?php
                    // Exibe nome e link de perfil quando o cliente está logado
                    try {
                        $clienteMenu = \App\dao\ClienteDAO::buscarPorId((int) $_SESSION['cliente_id']);
                    } catch (\Exception $e) {
                        $clienteMenu = null;
                    }
                ?>
                <a href="<?= BASE_URL . '/perfil' ?>"
                   class="d-flex align-items-center gap-2"
                   style="color:var(--coffee);font-weight:bold;">
                    <?php if ($clienteMenu && $clienteMenu->getUrlFotoPerfil()): ?>
                        <img src="<?= htmlspecialchars($clienteMenu->getUrlFotoPerfil()) ?>"
                             class="rounded-circle"
                             style="width:28px;height:28px;object-fit:cover;border:2px solid var(--amber);"
                             alt="Foto">
                    <?php else: ?>
                        <i class="bi bi-person-circle" style="font-size:1.4rem;color:var(--amber);"></i>
                    <?php endif; ?>
                    <span><?= htmlspecialchars($clienteMenu ? ($clienteMenu->getName() ?? 'Perfil') : 'Perfil') ?></span>
                </a>
                <a href="<?= BASE_URL . '/logout' ?>"
                   class="login-button-cliente"
                   role="button">Sair</a>
            <?php else: ?>
                <a class="login-button-cliente"
                   role="button"
                   href="<?= BASE_URL . '/login' ?>">Entrar</a>
            <?php endif; ?>
        </div>
    </nav>
</div>
<style>
    .bi{
        cursor: pointer;
        color:black
    }
</style>
