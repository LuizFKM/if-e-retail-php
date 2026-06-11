<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Produtos</title>
</head>
<body>

<h1>Produtos</h1>

<?php if (isset($produto)): ?>
    <h2>Resultado da busca</h2>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><td><?= htmlspecialchars($produto->getID()) ?></td></tr>
        <tr><th>Descrição</th><td><?= htmlspecialchars($produto->getDescricao()) ?></td></tr>
        <tr><th>Quantidade</th><td><?= htmlspecialchars($produto->getQuantidade()) ?></td></tr>
        <tr><th>Preço Unitário</th><td>R$ <?= number_format($produto->getPrecoUnitario(), 2, ',', '.') ?></td></tr>
        <tr><th>Status</th><td><?= htmlspecialchars($produto->getStatus()) ?></td></tr>
    </table>
    <p><a href="<?= BASE_URL . '/produtos' ?>">Ver todos os produtos</a></p>
<?php elseif (!empty($produtos)): ?>
    <table border="1" cellpadding="6">
        <thead>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Qtd.</th>
            <th>Preço Unit.</th>
            <th class="text-center">Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= htmlspecialchars($produto->getID()) ?></td>
                <td><?= htmlspecialchars($produto->getDescricao()) ?></td>
                <td><?= htmlspecialchars($produto->getQuantidade()) ?></td>
                <td>R$ <?= number_format($produto->getPrecoUnitario(), 2, ',', '.') ?></td>
                <td>
                    <a class="btn btn-outline-secondary bi bi-eye" href="<?= BASE_URL . '/produtos/' . $produto->getID() ?>"> Visualizar</a>
                    |
                    <form method="post" action="<?= BASE_URL . 'painel-admnistrativo/produtos/' . $produto->getID() . '/remover' ?>" style="display:inline">
                        <button type="submit" class="btn btn-outline-danger bi bi-trash" onclick="return confirm('Remover produto?')"> Remover</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum produto cadastrado.</p>
<?php endif; ?>
<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>
