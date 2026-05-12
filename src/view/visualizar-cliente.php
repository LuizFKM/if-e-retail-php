<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/templates/template-head.php" ?>
    <title>Visualizar Cliente</title>
</head>
<body>
    <?php require_once __DIR__ . "/templates/template-menu.php" ?>
        <h1>Visualizar Cliente</h1>
    <p><a href="<?= BASE_URL . '/clientes' ?>">← Voltar para Clientes</a></p>

    <?php if (!empty($cliente)): ?>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><td><?= htmlspecialchars($cliente->getID()) ?></td></tr>
        <tr><th>Nome</th><td><?= htmlspecialchars($cliente->getName()) ?></td></tr>
        <tr><th>CPF</th><td><?= htmlspecialchars($cliente->getCpf()) ?></td></tr>
        <tr><th>Data de Nascimento</th><td><?= htmlspecialchars($cliente->getDataNascimento()?->format('d/m/Y') ?? '-') ?></td></tr>
        <tr><th>Tipo</th><td><?= htmlspecialchars($cliente->getTipo()) ?></td></tr>
    </table>
    <br>
    <form method="post" action="<?= BASE_URL . '/clientes/' . $cliente->getID() . '/remover' ?>">
        <button type="submit" onclick="return confirm('Remover este cliente?')">Remover</button>
    </form>
    <?php else: ?>
    <p>Cliente não encontrado.</p>
    <?php endif; ?>
    <?php require_once __DIR__ . "/templates/template-rodape.php" ?>
</body>
</html>
