<!doctype html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Login</title>
</head>
<?php require_once __DIR__ . "/../templates/template-menu-cliente.php" ?>
<body class="view-login">
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">

    <!-- Novo: action e method adicionados para enviar para LoginController@autenticar -->
    <form id="formLogin" class="w-100 bg-white bg-opacity-75 p-4 p-md-5 rounded-3 shadow"
          style="max-width: 450px;"
          method="POST"
          action="<?= BASE_URL . '/login/autenticar' ?>">

        <div class="text-center mb-4">
            <h3 class="fw-bold mb-1" style="color:var(--coffee);">Bem-vindo de volta</h3>
            <p class="text-muted small">Entre com sua conta para continuar</p>
        </div>

        <?php if (!empty($_SESSION['login_erro'])): ?>
            <div class="alert border-0 d-flex align-items-center gap-2 mb-4"
                 style="background:#fff0f0;border-left:4px solid #dc3545 !important;border-radius:10px;">
                <i class="bi bi-exclamation-circle-fill fs-5 text-danger"></i>
                <span><?= htmlspecialchars($_SESSION['login_erro']) ?></span>
            </div>
            <?php unset($_SESSION['login_erro']); ?>
        <?php endif; ?>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold small" style="color:var(--coffee);">
                <i class="bi bi-envelope me-1" style="color:var(--amber);"></i>E-mail
            </label>
            <div class="input-group">
                <span class="input-group-text" style="background:var(--cream);border-color:var(--line);color:var(--amber);">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" class="form-control" id="email" name="email"
                       placeholder="seu@email.com"
                       style="border-color:var(--line);" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="senha" class="form-label fw-semibold small" style="color:var(--coffee);">
                <i class="bi bi-lock me-1" style="color:var(--amber);"></i>Senha
            </label>
            <div class="input-group">
                <span class="input-group-text" style="background:var(--cream);border-color:var(--line);color:var(--amber);">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password" class="form-control" id="senha" name="senha"
                       placeholder="••••••••"
                       style="border-color:var(--line);" required>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-amber btn-lg rounded-pill">
                <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
            </button>
        </div>

        <div class="text-center mt-4 pt-3" style="border-top:1px solid var(--line);">
            <span class="text-muted small">Ainda não tem uma conta?</span>
            <a href="<?= BASE_URL . '/clientes/novo' ?>"
               class="btn btn-outline-secondary btn-sm rounded-pill px-4 ms-2">
                <i class="bi bi-person-plus me-1"></i>Cadastre-se
            </a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>
