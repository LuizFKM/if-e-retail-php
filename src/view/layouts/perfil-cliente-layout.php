<!doctype html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Meu Perfil — IF Retail</title>
</head>
<body>
<?php require_once __DIR__ . "/../templates/template-menu-cliente.php" ?>

<div class="container py-5">

    <!-- Cabeçalho do perfil: avatar + nome do cliente -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <?php if (!empty($cliente) && $cliente->getUrlFotoPerfil()): ?>
            <img src="<?= htmlspecialchars($cliente->getUrlFotoPerfil()) ?>"
                 alt="Foto de perfil"
                 class="rounded-circle"
                 style="width:72px;height:72px;object-fit:cover;border:3px solid var(--amber);">
        <?php else: ?>
            <i class="bi bi-person-circle" style="font-size:72px;color:var(--amber);"></i>
        <?php endif; ?>
        <div>
            <h4 class="mb-0 fw-bold" style="color:var(--coffee);">
                <?= htmlspecialchars($cliente->getName() ?? 'Cliente') ?>
            </h4>
            <small class="text-muted"><?= htmlspecialchars($cliente->getLogin() ?? '') ?></small>
        </div>
    </div>

    <!-- Navegação por abas (nav-pills) — aba ativa detectada pela URL atual -->
    <ul class="nav nav-pills mb-4 gap-2">
        <li class="nav-item">
            <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/perfil/favoritos') ? 'active' : '' ?>"
               href="<?= BASE_URL . '/perfil/favoritos' ?>"
               style="<?= str_contains($_SERVER['REQUEST_URI'], '/perfil/favoritos') ? 'background-color:var(--amber);color:var(--coffee-deep);' : 'color:var(--coffee);' ?>">
                <i class="bi bi-heart me-1"></i> Favoritos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/perfil/compras') ? 'active' : '' ?>"
               href="<?= BASE_URL . '/perfil/compras' ?>"
               style="<?= str_contains($_SERVER['REQUEST_URI'], '/perfil/compras') ? 'background-color:var(--amber);color:var(--coffee-deep);' : 'color:var(--coffee);' ?>">
                <i class="bi bi-bag-check me-1"></i> Compras
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/perfil/configuracoes') ? 'active' : '' ?>"
               href="<?= BASE_URL . '/perfil/configuracoes' ?>"
               style="<?= str_contains($_SERVER['REQUEST_URI'], '/perfil/configuracoes') ? 'background-color:var(--amber);color:var(--coffee-deep);' : 'color:var(--coffee);' ?>">
                <i class="bi bi-gear me-1"></i> Configurações
            </a>
        </li>
    </ul>

    <!-- Conteúdo da aba ativa, gerado via ob_start() no controller -->
    <?php echo $conteudo ?? ''; ?>

</div>

<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>
