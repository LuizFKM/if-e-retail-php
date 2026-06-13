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
    <form class="w-100 bg-white bg-opacity-75 p-4 p-md-5 rounded-3 shadow"
          style="max-width: 450px;"
          method="POST"
          action="<?= BASE_URL . '/login/autenticar' ?>">

        <h3 class="text-center mb-4">Login</h3>

        <?php if (!empty($_SESSION['login_erro'])): ?>
            <div class="alert alert-danger py-2">
                <?= htmlspecialchars($_SESSION['login_erro']) ?>
            </div>
            <?php unset($_SESSION['login_erro']); ?>
        <?php endif; ?>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <!-- Novo: name="email" para ser lido por filter_input(INPUT_POST, 'email') -->
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
        </div>

        <div class="mb-4">
            <label for="senha" class="form-label">Senha</label>
            <!-- Novo: name="senha" para ser lido por filter_input(INPUT_POST, 'senha') -->
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-amber btn-lg">Entrar</button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <p class="mb-2">Ainda não tem uma conta?</p>
            <a href="<?= BASE_URL . '/clientes/novo' ?>" class="btn btn-outline-secondary">Cadastre-se</a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>
