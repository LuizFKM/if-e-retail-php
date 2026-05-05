<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
</head>
<body>
    <h1>Clientes</h1>
    <p><a href="<?= BASE_URL ?>">← Início</a></p>

    <?php if (!empty($clientes)): ?>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= htmlspecialchars($cliente->getID()) ?></td>
                <td><?= htmlspecialchars($cliente->getName()) ?></td>
                <td><?= htmlspecialchars($cliente->getCpf()) ?></td>
                <td>
                    <a href="<?= BASE_URL . '/clientes/' . $cliente->getID() ?>">Visualizar</a>
                    |
                    <form method="post" action="<?= BASE_URL . '/clientes/' . $cliente->getID() . '/remover' ?>" style="display:inline">
                        <button type="submit" onclick="return confirm('Remover cliente?')">Remover</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>Nenhum cliente cadastrado.</p>
    <?php endif; ?>
</body>
</html>
