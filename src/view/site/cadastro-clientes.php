<?php /** @var App\model\Cliente $cliente */ ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Cadastro de Cliente</title>
</head>
<?php require_once __DIR__ . "/../templates/template-menu-cliente.php" ?>
<body class="view-cadastro-cliente">

<div class="container-fluid min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">

    <div class="w-100 bg-white bg-opacity-75 p-4 p-md-5 rounded-3 shadow" style="max-width: 500px;">

        <div class="text-center mb-4">
            <h2 class="fw-bold">Cadastro de Cliente</h2>
            <p class="text-muted">Preencha o formulário abaixo</p>
        </div>

        <form action="<?= BASE_URL . '/clientes/cadastrar' ?>" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($cliente->getID() ?? '') ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Nome Completo:</label>
                <input id="name" name="name" type="text" class="form-control" value="<?= htmlspecialchars($cliente->getName() ?? '') ?>" required/>
            </div>

            <div class="mb-3">
                <label for="login" class="form-label">Email:</label>
                <input id="login" name="login" type="text" class="form-control" value="<?= htmlspecialchars($cliente->getLogin() ?? '') ?>" required/>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF:</label>
                <input id="cpf" name="cpf" type="text" class="form-control" value="<?= htmlspecialchars($cliente->getCpf() ?? '') ?>" required/>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input id="senha" name="senha" type="password" class="form-control" required/>
            </div>

            <div class="mb-4">
                <label for="dataNascimento" class="form-label">Data de Nascimento:</label>
                <input id="dataNascimento" name="dataNascimento" type="date" class="form-control" value="<?= htmlspecialchars($cliente->getDataNascimento()?->format('Y-m-d') ?? '') ?>" required/>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Cadastrar</button>
            </div>

            <div class="text-center mt-4">
                <a href="<?= BASE_URL . '/login' ?>" class="text-decoration-none">Já tem uma conta? Faça login</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>