<?php /** @var App\model\Pedido[] $pedidos */ ?>

    <h1>Pedidos</h1>

<?php if (!empty($pedidos)): ?>
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
                    <a href="<?= BASE_URL . '/painel-administrativo/pedidos/' . $pedido->getID() ?>">Visualizar</a>
                    |
                    <form method="post" action="<?= BASE_URL . '/painel-administrativo/pedidos/' . $pedido->getID() . '/remover' ?>" style="display:inline">
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