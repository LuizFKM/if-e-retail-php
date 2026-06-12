<!doctype html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Login</title>
</head>
<?php require_once __DIR__ . "/../templates/template-menu-cliente.php" ?>
<body class="view-login">
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">

    <form class="w-100 bg-white bg-opacity-75  p-4 p-md-5 rounded-3 shadow" style="max-width: 450px;">

        <h3 class="text-center mb-4">Login</h3>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail">
        </div>

        <div class="mb-4">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" placeholder="Digite sua senha">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-outline-primary btn-lg">Entrar</button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <p class="mb-2">Ainda não tem uma conta?</p>
            <a  href="<?= BASE_URL . '/clientes/novo' ?>" class="btn btn-outline-secondary">Cadastre-se</a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>