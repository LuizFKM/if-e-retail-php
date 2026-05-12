<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/templates/template-head.php" ?>
    <title>Funcionários</title>
</head>
<body>
    <?php require_once __DIR__ . "/templates/template-menu.php" ?>
        <h1>Funcionários</h1>

    <?php if (isset($admin)): ?>
    <h2>Resultado da busca</h2>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><td><?= htmlspecialchars($admin->getID()) ?></td></tr>
        <tr><th>Nome</th><td><?= htmlspecialchars($admin->getName()) ?></td></tr>
        <tr><th>CPF</th><td><?= htmlspecialchars($admin->getCpf()) ?></td></tr>
        <tr><th>Matrícula</th><td><?= htmlspecialchars($admin->getMatricula()) ?></td></tr>
        <tr><th>Setor</th><td><?= htmlspecialchars($admin->getSetor()) ?></td></tr>
        <tr><th>Cargo</th><td><?= htmlspecialchars($admin->getCargo()) ?></td></tr>
        <tr><th>Data de Admissão</th><td><?= htmlspecialchars($admin->getDataAdmissao()?->format('d/m/Y') ?? '-') ?></td></tr>
    </table>
    <p><a href="<?= BASE_URL . '/admin' ?>">Ver todos os funcionários</a></p>
    <?php elseif (!empty($admins)): ?>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Cargo</th>
                <th>Setor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
            <tr>
                <td><?= htmlspecialchars($admin->getID()) ?></td>
                <td><?= htmlspecialchars($admin->getName()) ?></td>
                <td><?= htmlspecialchars($admin->getCpf()) ?></td>
                <td><?= htmlspecialchars($admin->getCargo()) ?></td>
                <td><?= htmlspecialchars($admin->getSetor()) ?></td>
                <td>
                    <a href="<?= BASE_URL . '/admin/' . $admin->getID() ?>">Visualizar</a>
                    |
                    <form method="post" action="<?= BASE_URL . '/admin/' . $admin->getID() . '/remover' ?>" style="display:inline">
                        <button type="submit" onclick="return confirm('Remover funcionário?')">Remover</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>Nenhum funcionário cadastrado.</p>
    <?php endif; ?>
    <?php require_once __DIR__ . "/templates/template-rodape.php" ?>
</body>
</html>
