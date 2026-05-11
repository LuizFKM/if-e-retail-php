<?php /** @var model\Admin $admin */ ?>
<!doctype html>
<html lang="pt-br">
<head>
    <?php require_once "templates/template-head.php" ?>
    <title>Cadastro de Funcionário</title>
</head>
<body>
<h1>Cadastro de Funcionário</h1>
<div class="container">
    <h3>Preencha o formulário</h3>
    <div class="form">
        <form action="<?= BASE_URL . '/admin/cadastrar' ?>" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($admin->getId() ?? '') ?>">

            <label for="name">Nome:</label>
            <input id="name" name="name" type="text" value="<?= htmlspecialchars($admin->getName() ?? '') ?>" required/>

            <label for="login">Login:</label>
            <input id="login" name="login" type="text" value="<?= htmlspecialchars($admin->getLogin() ?? '') ?>" required/>

            <label for="cpf">CPF:</label>
            <input id="cpf" name="cpf" type="text" value="<?= htmlspecialchars($admin->getCpf() ?? '') ?>" required/>

            <label for="senha">Senha:</label>
            <input id="senha" name="senha" type="password" required/>

            <label for="dataNascimento">Data de Nascimento:</label>
            <input id="dataNascimento" name="dataNascimento" type="date" value="<?= htmlspecialchars($admin->getDataNascimento()?->format('Y-m-d') ?? '') ?>" required/>

            <label for="matricula">Matrícula:</label>
            <input id="matricula" name="matricula" type="text" value="<?= htmlspecialchars($admin->getMatricula() ?? '') ?>" required/>

            <label for="setor">Setor:</label>
            <input id="setor" name="setor" type="text" value="<?= htmlspecialchars($admin->getSetor() ?? '') ?>" required/>

            <label for="cargo">Cargo:</label>
            <input id="cargo" name="cargo" type="text" value="<?= htmlspecialchars($admin->getCargo() ?? '') ?>" required/>

            <label for="dataAdmissao">Data de Admissão:</label>
            <input id="dataAdmissao" name="dataAdmissao" type="date" value="<?= htmlspecialchars($admin->getDataAdmissao()?->format('Y-m-d') ?? '') ?>" required/>

            <label for="status">Status:</label>
            <input id="status" name="status" type="text" value="<?= htmlspecialchars($admin->getStatus() ?? '') ?>" required/>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</div>
</body>
</html>
