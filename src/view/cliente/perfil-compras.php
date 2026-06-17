<?php
/** @var \App\model\Cliente $cliente */
/** @var \Doctrine\Common\Collections\Collection $pedidos */
use App\dao\ItemPedidoDAO;
?>

<style>
.pedido-card {
    border: 1.5px solid var(--line);
    border-radius: 14px;
    overflow: hidden;
    transition: box-shadow .18s;
}
.pedido-card:hover {
    box-shadow: 0 6px 20px rgba(59,36,24,.1) !important;
}
.pedido-header {
    background: linear-gradient(90deg, var(--cream) 0%, var(--paper) 100%);
    border-bottom: 1.5px solid var(--line);
    padding: .85rem 1.25rem;
}
.badge-concluido {
    background: #d1f0e0;
    color: #1a7a46;
    font-size: .72rem;
    font-weight: 700;
    padding: .35em .75em;
    border-radius: 20px;
}
.badge-pendente {
    background: #fff3cd;
    color: #856404;
    font-size: .72rem;
    font-weight: 700;
    padding: .35em .75em;
    border-radius: 20px;
}
.table-pedido thead th {
    background: var(--cream);
    color: var(--coffee);
    font-size: .8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    border-bottom: 2px solid var(--line);
}
.table-pedido tbody tr:last-child td {
    border-bottom: none;
}
.table-pedido tfoot td {
    border-top: 2px solid var(--line);
    background: var(--paper);
}
.total-valor {
    color: var(--amber);
    font-size: 1.1rem;
    font-weight: 700;
}
</style>

<!-- Cabeçalho da seção -->
<div class="d-flex align-items-center gap-2 mb-4">
    <div class="rounded-circle d-flex align-items-center justify-content-center"
         style="width:38px;height:38px;background:var(--cream);">
        <i class="bi bi-bag-check-fill" style="color:var(--amber);font-size:1.1rem;"></i>
    </div>
    <div>
        <h5 class="mb-0 fw-bold" style="color:var(--coffee);">Histórico de Compras</h5>
        <small class="text-muted">
            <?php if (!$pedidos->isEmpty()): ?>
                <?= $pedidos->count() ?> pedido<?= $pedidos->count() !== 1 ? 's' : '' ?> realizado<?= $pedidos->count() !== 1 ? 's' : '' ?>
            <?php else: ?>
                Nenhum pedido ainda
            <?php endif; ?>
        </small>
    </div>
</div>

<?php if ($pedidos->isEmpty()): ?>
    <!-- Estado vazio -->
    <div class="text-center py-5 px-3">
        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
             style="width:90px;height:90px;background:var(--cream);border:2px dashed var(--line);">
            <i class="bi bi-bag-x" style="font-size:2.5rem;color:var(--amber);"></i>
        </div>
        <h6 class="fw-bold mb-1" style="color:var(--coffee);">Você ainda não fez nenhuma compra</h6>
        <p class="text-muted small mb-4">Explore nossa loja e encontre produtos incríveis.</p>
        <a href="<?= BASE_URL . '/produtos' ?>" class="btn btn-amber rounded-pill px-4">
            <i class="bi bi-shop me-1"></i>Ir às compras
        </a>
    </div>
<?php else: ?>
    <div class="d-flex flex-column gap-3">
        <?php foreach ($pedidos as $pedido):
            $itensPedido = ItemPedidoDAO::buscarPorPedido($pedido);
            $totalPedido = array_reduce(
                $itensPedido,
                fn($carry, $i) => $carry + ($i->getPreco() * $i->getQuantidade()),
                0
            );
            $concluido = (bool) $pedido->getStatus();
        ?>
            <div class="pedido-card card shadow-sm">

                <!-- Header do pedido -->
                <div class="pedido-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:36px;height:36px;background:var(--paper);border:1.5px solid var(--line);">
                            <i class="bi bi-receipt" style="color:var(--amber);"></i>
                        </div>
                        <div>
                            <span class="fw-bold" style="color:var(--coffee);">
                                Pedido #<?= htmlspecialchars($pedido->getID()) ?>
                            </span>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <i class="bi bi-calendar3" style="color:var(--brown);font-size:.8rem;"></i>
                                <small class="text-muted">
                                    <?= $pedido->getDataPedido()?->format('d/m/Y \à\s H:i') ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <?php if ($concluido): ?>
                        <span class="badge-concluido">
                            <i class="bi bi-check-circle-fill me-1"></i>Concluído
                        </span>
                    <?php else: ?>
                        <span class="badge-pendente">
                            <i class="bi bi-clock me-1"></i>Pendente
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Corpo: tabela de itens -->
                <div class="card-body p-0">
                    <?php if (empty($itensPedido)): ?>
                        <p class="text-muted small p-3 mb-0">Itens não disponíveis.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-pedido table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Produto</th>
                                        <th class="text-center">Qtd.</th>
                                        <th class="text-end">Preço Unit.</th>
                                        <th class="text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($itensPedido as $item): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded d-flex align-items-center justify-content-center"
                                                         style="width:32px;height:32px;background:var(--cream);flex-shrink:0;">
                                                        <i class="bi bi-box-seam" style="color:var(--amber);font-size:.85rem;"></i>
                                                    </div>
                                                    <span class="fw-semibold small" style="color:var(--coffee);">
                                                        <?= htmlspecialchars($item->getProduto()?->getDescricao() ?? 'Produto removido') ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge rounded-pill"
                                                      style="background:var(--cream);color:var(--coffee);">
                                                    <?= (int) $item->getQuantidade() ?>
                                                </span>
                                            </td>
                                            <td class="text-end align-middle text-muted small">
                                                R$ <?= number_format($item->getPreco(), 2, ',', '.') ?>
                                            </td>
                                            <td class="text-end align-middle fw-semibold pe-4" style="color:var(--coffee);">
                                                R$ <?= number_format($item->getPreco() * $item->getQuantidade(), 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold ps-4 py-3"
                                            style="color:var(--coffee);">Total do pedido:</td>
                                        <td class="text-end total-valor pe-4 py-3">
                                            R$ <?= number_format($totalPedido, 2, ',', '.') ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Rodapé com data de entrega -->
                        <div class="px-4 py-2 d-flex align-items-center gap-2"
                             style="border-top:1px solid var(--line);background:var(--paper);">
                            <i class="bi bi-truck" style="color:var(--amber);"></i>
                            <small class="text-muted">
                                Entrega prevista:
                                <strong style="color:var(--coffee);">
                                    <?= $pedido->getDataEntrega()?->format('d/m/Y') ?? 'não informada' ?>
                                </strong>
                            </small>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
