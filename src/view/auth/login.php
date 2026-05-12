<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>Login — IF-E-RETAIL</title>
    <style>
        :root {
            --coffee:      #3B2418;
            --coffee-deep: #2A170D;
            --amber:       #C68A4C;
            --amber-soft:  #E2B47A;
            --sand:        #F5EBD9;
            --cream:       #EFE4D2;
            --paper:       #FBF6EC;
            --ink:         #1B120B;
            --line:        #E2D3BB;
        }
        body {
            background-color: var(--coffee-deep);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background-color: var(--paper);
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .login-logo { color: var(--amber); font-size: 1.5rem; font-weight: 700; letter-spacing: 1px; }
        .btn-amber { background-color: var(--amber); color: var(--coffee-deep); border: none; font-weight: 600; }
        .btn-amber:hover { background-color: var(--amber-soft); color: var(--coffee-deep); }
        .form-control:focus { border-color: var(--amber); box-shadow: 0 0 0 0.2rem rgba(198,138,76,0.25); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="login-logo"><i class="bi bi-shop me-2"></i>IF-E-RETAIL</div>
            <p class="text-muted mt-1 mb-0">Faça login para continuar</p>
        </div>

        <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['tipo']) ?> alert-dismissible fade show py-2">
            <?= htmlspecialchars($_SESSION['flash']['msg']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['flash']); endif; ?>

        <form method="POST" action="<?= BASE_URL . '/login' ?>">
            <div class="mb-3">
                <label class="form-label fw-semibold" style="color: var(--coffee);">Login</label>
                <div class="input-group">
                    <span class="input-group-text" style="background-color: var(--cream); border-color: var(--line);">
                        <i class="bi bi-person" style="color: var(--amber);"></i>
                    </span>
                    <input type="text" name="login" class="form-control" style="border-color: var(--line);"
                           placeholder="Seu login" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold" style="color: var(--coffee);">Senha</label>
                <div class="input-group">
                    <span class="input-group-text" style="background-color: var(--cream); border-color: var(--line);">
                        <i class="bi bi-lock" style="color: var(--amber);"></i>
                    </span>
                    <input type="password" name="senha" class="form-control" style="border-color: var(--line);"
                           placeholder="Sua senha" required>
                </div>
            </div>

            <button type="submit" class="btn btn-amber w-100 btn-lg">
                <i class="bi bi-box-arrow-in-right me-2"></i> Entrar
            </button>
        </form>

        <hr style="border-color: var(--line); margin: 1.5rem 0;">
        <p class="text-center text-muted small mb-0">
            Não tem conta?
            <a href="<?= BASE_URL . '/loja' ?>" style="color: var(--amber);">Entrar como visitante</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YUe2LzesAfSTdNaFKHKFZHNNnhSPbNSFfbPLKGxV3oGAeRgT6ZyHD9RKM5nHMof" crossorigin="anonymous"></script>
</body>
</html>
