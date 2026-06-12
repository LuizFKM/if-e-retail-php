<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/templates/template-head.php" ?>
    <title>Pedidos</title>
</head>
<body>
    <?php require_once __DIR__ . "/templates/template-aside-left-admin.php" ?>
        <h1>Pedidos</h1>

    <?php if (isset($pedido)): ?>
    <h2>Resultado da busca</h2>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><td><?= htmlspecialchars($pedido->getID()) ?></td></tr>
        <tr><th>Data do Pedido</th><td><?= htmlspecialchars($pedido->getDataPedido()?->format('d/m/Y H:i') ?? '-') ?></td></tr>
        <tr><th>Data de Entrega</th><td><?= htmlspecialchars($pedido->getDataEntrega()?->format('d/m/Y H:i') ?? '-') ?></td></tr>
        <tr><th>Status</th><td><?= $pedido->getStatus() ? 'Concluído' : 'Pendente' ?></td></tr>
        <tr><th>Cliente</th><td><?= htmlspecialchars($pedido->getCliente()?->getName() ?? '-') ?></td></tr>
    </table>
    <p><a href="<?= BASE_URL . '/pedidos' ?>">Ver todos os pedidos</a></p>
    <?php elseif (!empty($pedidos)): ?>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Data do Pedido</th>
                <th>Data de Entrega</th>
                <th>Status</th>
                <th>Cliente</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?= htmlspecialchars($pedido->getID()) ?></td>
                <td><?= htmlspecialchars($pedido->getDataPedido()?->format('d/m/Y') ?? '-') ?></td>
                <td><?= htmlspecialchars($pedido->getDataEntrega()?->format('d/m/Y') ?? '-') ?></td>
                <td><?= $pedido->getStatus() ? 'Concluído' : 'Pendente' ?></td>
                <td><?= htmlspecialchars($pedido->getCliente()?->getName() ?? '-') ?></td>
                <td>
                    <a href="<?= BASE_URL . '/pedidos/' . $pedido->getID() ?>">Visualizar</a>
                    |
                    <form method="post" action="<?= BASE_URL . '/pedidos/' . $pedido->getID() . '/remover' ?>" style="display:inline">
                        <button type="submit" onclick="return confirm('Remover pedido?')">Remover</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>Nenhum pedido cadastrado.</p>
    <?php endif; ?>
    <?php require_once __DIR__ . "/templates/template-rodape.php" ?>
</body>
</html>
