<!doctype html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Painel Administrativo — IF-E-RETAIL</title>
</head>
<body class="admin-body">

    <!-- Topbar -->
    <header class="admin-topbar">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-shop fs-5" style="color:var(--amber);"></i>
            <span class="fw-bold" style="color:var(--amber);letter-spacing:1px;font-size:.95rem;">IF-E-RETAIL</span>
            <span style="color:rgba(255,255,255,.25);margin:0 4px;">|</span>
            <span style="color:var(--sand);font-size:.82rem;font-weight:500;">Painel Administrativo</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>/" target="_blank"
               style="color:var(--sand);border:1px solid rgba(255,255,255,.18);border-radius:6px;padding:4px 12px;font-size:.8rem;font-weight:500;transition:background .2s;"
               onmouseover="this.style.background='rgba(255,255,255,.08)'"
               onmouseout="this.style.background='transparent'">
                <i class="bi bi-box-arrow-up-right me-1"></i>Ver loja
            </a>
        </div>
    </header>

    <!-- Layout: sidebar + conteúdo -->
    <div class="d-flex flex-grow-1">
        <?php require_once __DIR__ . "/../templates/template-aside-left-admin.php" ?>
        <main class="admin-main flex-grow-1">
            <?php echo $conteudo ?? ''; ?>
        </main>
    </div>

    <?php require_once __DIR__ . "/../templates/template-rodape.php" ?>

</body>
</html>
