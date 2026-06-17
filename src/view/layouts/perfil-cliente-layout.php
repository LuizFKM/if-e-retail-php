<!doctype html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Meu Perfil — IF Retail</title>
    <style>
    /* ── Abas de navegação do perfil ── */
    .perfil-nav .nav-link {
        color: var(--brown);
        border-radius: 10px;
        padding: .5rem 1rem;
        font-weight: 600;
        font-size: .88rem;
        border: 1.5px solid transparent;
        transition: background .15s, color .15s, border-color .15s;
        display: flex;
        align-items: center;
        gap: .4rem;
    }
    .perfil-nav .nav-link:hover {
        background: var(--cream);
        color: var(--coffee);
    }
    .perfil-nav .nav-link.active {
        background: var(--amber);
        color: var(--coffee-deep);
        border-color: var(--amber);
    }
    /* ── Banner do cabeçalho ── */
    .perfil-banner {
        background: linear-gradient(135deg, var(--coffee-deep) 0%, var(--coffee) 100%);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .perfil-banner::before {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(198,138,76,.15);
    }
    .perfil-banner::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 40%;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(198,138,76,.08);
    }
    .avatar-perfil {
        width: 72px; height: 72px;
        border: 3px solid var(--amber);
        object-fit: cover;
        flex-shrink: 0;
    }
    .avatar-placeholder {
        width: 72px; height: 72px;
        border: 3px solid var(--amber);
        background: rgba(198,138,76,.15);
        flex-shrink: 0;
    }
    </style>
</head>
<body>
<?php require_once __DIR__ . "/../templates/template-menu-cliente.php" ?>

<div class="container py-4">

    <!-- Banner do perfil -->
    <div class="perfil-banner">
        <div class="d-flex align-items-center gap-3 position-relative">
            <?php if (!empty($cliente) && $cliente->getUrlFotoPerfil()): ?>
                <img src="<?= htmlspecialchars($cliente->getUrlFotoPerfil()) ?>"
                     alt="Foto de perfil"
                     class="rounded-circle avatar-perfil">
            <?php else: ?>
                <div class="rounded-circle avatar-placeholder d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-fill" style="font-size:2rem;color:var(--amber);"></i>
                </div>
            <?php endif; ?>
            <div>
                <h4 class="mb-0 fw-bold text-white">
                    <?= htmlspecialchars($cliente->getName() ?? 'Cliente') ?>
                </h4>
                <small style="color:var(--amber-soft);">
                    <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($cliente->getLogin() ?? '') ?>
                </small>
            </div>
        </div>
    </div>

    <!-- Abas de navegação -->
    <?php
    $uri = $_SERVER['REQUEST_URI'];
    $isFavoritos     = str_contains($uri, '/perfil/favoritos');
    $isCompras       = str_contains($uri, '/perfil/compras');
    $isConfiguracoes = str_contains($uri, '/perfil/configuracoes');
    ?>
    <ul class="nav perfil-nav gap-1 mb-4">
        <li class="nav-item">
            <a class="nav-link <?= $isFavoritos ? 'active' : '' ?>"
               href="<?= BASE_URL . '/perfil/favoritos' ?>">
                <i class="bi bi-heart<?= $isFavoritos ? '-fill' : '' ?>"></i> Favoritos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $isCompras ? 'active' : '' ?>"
               href="<?= BASE_URL . '/perfil/compras' ?>">
                <i class="bi bi-bag<?= $isCompras ? '-check-fill' : '-check' ?>"></i> Compras
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $isConfiguracoes ? 'active' : '' ?>"
               href="<?= BASE_URL . '/perfil/configuracoes' ?>">
                <i class="bi bi-gear<?= $isConfiguracoes ? '-fill' : '' ?>"></i> Configurações
            </a>
        </li>
    </ul>

    <!-- Conteúdo da aba ativa -->
    <?php echo $conteudo ?? ''; ?>

</div>

<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>
