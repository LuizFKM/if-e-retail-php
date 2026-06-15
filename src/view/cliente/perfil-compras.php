<?php
/** @var \App\model\Cliente $cliente */
/** @var \Doctrine\Common\Collections\Collection $pedidos */
use App\dao\ItemPedidoDAO;
?>

<h5 class="fw-bold mb-4" style="color:var(--coffee);">
    <i class="bi bi-bag-check-fill me-2" style="color:var(--amber);"></i>Histórico de Compras
</h5>

<?php if ($pedidos->isEmpty()): ?>
    <div class="text-center py-5">
        <i class="bi bi-bag-x" style="font-size:3rem;color:var(--amber);"></i>
        <p class="mt-3 text-muted">Você ainda não realizou nenhuma compra.</p>
        <a href="<?= BASE_URL . '/produtos' ?>" class="btn btn-amber mt-2">
            <i class="bi bi-shop me-1"></i>Ir às compras
        </a>
    </div>
<?php else: ?>
    <?php foreach ($pedidos as $pedido): ?>
        <?php
            // Busca os itens do pedido via ItemPedidoDAO (não usa o ManyToMany legado de Pedido::$itens)
            $itensPedido = ItemPedidoDAO::buscarPorPedido($pedido);
            $totalPedido = array_reduce($itensPedido, fn($carry, $i) => $carry + ($i->getPreco() * $i->getQuantidade()), 0);
        ?>
        <div class="card mb-3 shadow-sm" style="border-color:var(--line);">
            <div class="card-header d-flex justify-content-between align-items-center"
                 style="background:var(--cream);">
                <div>
                    <span class="fw-bold" style="color:var(--coffee);">
                        Pedido #<?= htmlspecialchars($pedido->getID()) ?>
                    </span>
                    <span class="text-muted ms-3 small">
                        <?= $pedido->getDataPedido()?->format('d/m/Y') ?>
                    </span>
                </div>
                <span class="badge <?= $pedido->getStatus() ? 'bg-success' : 'bg-warning text-dark' ?>">
                    <?= $pedido->getStatus() ? 'Concluído' : 'Pendente' ?>
                </span>
            </div>
            <div class="card-body">
                <?php if (empty($itensPedido)): ?>
                    <p class="text-muted small mb-0">Itens não disponíveis.</p>
                <?php else: ?>
                    <table class="table table-sm mb-2">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th class="text-center">Qtd.</th>
                                <th class="text-end">Preço Unit.</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itensPedido as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item->getProduto()->getDescricao()) ?></td>
                                    <td class="text-center"><?= (int) $item->getQuantidade() ?></td>
                                    <td class="text-end">R$ <?= number_format($item->getPreco(), 2, ',', '.') ?></td>
                                    <td class="text-end">
                                        R$ <?= number_format($item->getPreco() * $item->getQuantidade(), 2, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold" style="color:var(--amber);">
                                    R$ <?= number_format($totalPedido, 2, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <small class="text-muted">
                        Entrega prevista: <?= $pedido->getDataEntrega()?->format('d/m/Y') ?>
                    </small>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
