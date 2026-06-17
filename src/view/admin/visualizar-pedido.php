<?php
/** @var App\model\Pedido $pedido */
/** @var App\model\ItemPedido[] $itensPedido */
$totalPedido = array_reduce(
    $itensPedido,
    fn($carry, $i) => $carry + ($i->getPreco() * $i->getQuantidade()),
    0
);
?>

<h1 class="mb-4">Pedido #<?= htmlspecialchars($pedido->getID()) ?></h1>

<!-- Dados gerais do pedido -->
<div class="card mb-4 shadow-sm">
    <div class="card-header fw-bold" style="background:var(--cream);color:var(--coffee);">
        <i class="bi bi-receipt me-2"></i>Informações do Pedido
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <small class="text-muted d-block">Cliente</small>
                <strong><?= htmlspecialchars($pedido->getCliente()?->getName() ?? '-') ?></strong>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Data do Pedido</small>
                <strong><?= $pedido->getDataPedido()?->format('d/m/Y H:i') ?? '-' ?></strong>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Entrega Prevista</small>
                <strong><?= $pedido->getDataEntrega()?->format('d/m/Y') ?? '-' ?></strong>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Status</small>
                <?php if ($pedido->getStatus()): ?>
                    <span class="badge bg-success">Concluído</span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark">Pendente</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Itens do pedido -->
<div class="card shadow-sm">
    <div class="card-header fw-bold" style="background:var(--cream);color:var(--coffee);">
        <i class="bi bi-box-seam me-2"></i>Itens do Pedido
    </div>
    <div class="card-body p-0">
        <?php if (empty($itensPedido)): ?>
            <p class="text-muted p-3 mb-0">Nenhum item encontrado.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background:var(--cream);">
                        <tr>
                            <th class="ps-3">Produto</th>
                            <th class="text-center">Qtd.</th>
                            <th class="text-end">Preço Unit.</th>
                            <th class="text-end pe-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itensPedido as $item): ?>
                            <tr>
                                <td class="ps-3"><?= htmlspecialchars($item->getProduto()->getDescricao()) ?></td>
                                <td class="text-center"><?= (int) $item->getQuantidade() ?></td>
                                <td class="text-end">R$ <?= number_format($item->getPreco(), 2, ',', '.') ?></td>
                                <td class="text-end pe-3 fw-bold">
                                    R$ <?= number_format($item->getPreco() * $item->getQuantidade(), 2, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold ps-3 py-3">Total:</td>
                            <td class="text-end pe-3 fw-bold py-3" style="color:var(--amber);font-size:1.1rem;">
                                R$ <?= number_format($totalPedido, 2, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="mt-4">
    <a href="<?= BASE_URL . '/painel-administrativo/pedidos' ?>" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-1"></i>Voltar aos pedidos
    </a>
</div>
