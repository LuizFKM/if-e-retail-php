<?php /** @var model\Cliente $cliente */ ?>
<!doctype html>
<html lang="pt-br">
<head>
    <?php require_once __DIR__ . "/templates/template-head.php" ?>
    <title>Cadastro de Cliente</title>
</head>
<body>
    <?php require_once __DIR__ . "/templates/template-menu.php" ?>
        <h1>Cadastro de Cliente</h1>
        <h3>Preencha o formulário</h3>
        <div class="form">
        <form action="<?= BASE_URL . '/clientes/cadastrar' ?>" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($cliente->getID() ?? '') ?>">

            <label for="name">Nome:</label>
            <input id="name" name="name" type="text" value="<?= htmlspecialchars($cliente->getName() ?? '') ?>" required/>

            <label for="login">Login:</label>
            <input id="login" name="login" type="text" value="<?= htmlspecialchars($cliente->getLogin() ?? '') ?>" required/>

            <label for="cpf">CPF:</label>
            <input id="cpf" name="cpf" type="text" value="<?= htmlspecialchars($cliente->getCpf() ?? '') ?>" required/>

            <label for="senha">Senha:</label>
            <input id="senha" name="senha" type="password" required/>

            <label for="dataNascimento">Data de Nascimento:</label>
            <input id="dataNascimento" name="dataNascimento" type="date" value="<?= htmlspecialchars($cliente->getDataNascimento()?->format('Y-m-d') ?? '') ?>" required/>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
    <?php require_once __DIR__ . "/templates/template-rodape.php" ?>
</body>
</html>
