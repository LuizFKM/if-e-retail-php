<?php
/** @var App\model\Pedido $pedido */
/** @var App\model\ItemPedido[] $itensPedido */
$totalPedido = array_reduce(
    $itensPedido,
    fn($carry, $i) => $carry + ($i->getPreco() * $i->getQuantidade()),
    0
);
?>

<div class="p-4">

    <!-- Cabeçalho -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="<?= BASE_URL . '/painel-administrativo/pedidos' ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="mb-0">Pedido <span class="text-muted fw-normal">#<?= htmlspecialchars($pedido->getID()) ?></span></h2>
        <?php if ($pedido->getStatus()): ?>
            <span class="badge bg-success fs-6">Concluído</span>
        <?php else: ?>
            <span class="badge bg-warning text-dark fs-6">Pendente</span>
        <?php endif; ?>
    </div>

    <div class="row g-4">

        <!-- Dados do pedido -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm" style="border-color:var(--line);">
                <div class="card-header fw-semibold" style="background:var(--cream);color:var(--coffee);">
                    <i class="bi bi-receipt me-2"></i>Informações do Pedido
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    <div>
                        <small class="text-muted d-block">Cliente</small>
                        <span class="fw-semibold"><?= htmlspecialchars($pedido->getCliente()?->getName() ?? '—') ?></span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Data do Pedido</small>
                        <span><?= $pedido->getDataPedido()?->format('d/m/Y \à\s H:i') ?? '—' ?></span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Entrega Prevista</small>
                        <span><?= $pedido->getDataEntrega()?->format('d/m/Y') ?? '—' ?></span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Total do Pedido</small>
                        <span class="fw-bold fs-5" style="color:var(--amber);">
                            R$ <?= number_format($totalPedido, 2, ',', '.') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm" style="border-color:var(--line);">
                <div class="card-header fw-semibold" style="background:var(--cream);color:var(--coffee);">
                    <i class="bi bi-gear me-2"></i>Ações
                </div>
                <div class="card-body d-flex flex-column gap-2">
                    <!-- Alternar status -->
                    <form method="post" action="<?= BASE_URL . '/painel-administrativo/pedidos/' . $pedido->getID() . '/status' ?>">
                        <?php if ($pedido->getStatus()): ?>
                            <button type="submit" class="btn btn-outline-warning w-100">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reabrir pedido
                            </button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-1"></i> Marcar como concluído
                            </button>
                        <?php endif; ?>
                    </form>

                    <!-- Remover pedido -->
                    <form method="post"
                          action="<?= BASE_URL . '/painel-administrativo/pedidos/' . $pedido->getID() . '/remover' ?>"
                          data-swal-confirm
                          data-swal-title="Remover pedido #<?= $pedido->getID() ?>?"
                          data-swal-text="Os itens do pedido também serão removidos permanentemente."
                          data-swal-btn="Sim, remover">
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-1"></i> Remover pedido
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Itens do pedido -->
    <div class="card shadow-sm mt-4" style="border-color:var(--line);">
        <div class="card-header fw-semibold" style="background:var(--cream);color:var(--coffee);">
            <i class="bi bi-box-seam me-2"></i>Itens do Pedido
            <span class="text-muted fw-normal">(<?= count($itensPedido) ?> <?= count($itensPedido) === 1 ? 'item' : 'itens' ?>)</span>
        </div>
        <div class="card-body p-0">
            <?php if (empty($itensPedido)): ?>
                <p class="text-muted p-3 mb-0">Nenhum item encontrado.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
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
                                    <td class="ps-3">
                                        <?php $prod = $item->getProduto(); ?>
                                        <?php if ($prod): ?>
                                            <?php if ($prod->getUrlFotoProduto()): ?>
                                                <img src="<?= htmlspecialchars($prod->getUrlFotoProduto()) ?>"
                                                     alt="" style="width:36px;height:36px;object-fit:cover;border-radius:4px;" class="me-2">
                                            <?php endif; ?>
                                            <?= htmlspecialchars($prod->getDescricao()) ?>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic">Produto removido</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?= (int) $item->getQuantidade() ?></td>
                                    <td class="text-end">R$ <?= number_format($item->getPreco(), 2, ',', '.') ?></td>
                                    <td class="text-end pe-3 fw-semibold">
                                        R$ <?= number_format($item->getPreco() * $item->getQuantidade(), 2, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr style="background:var(--cream);">
                                <td colspan="3" class="text-end fw-bold ps-3 py-3">Total:</td>
                                <td class="text-end pe-3 fw-bold py-3" style="color:var(--amber);font-size:1.15rem;">
                                    R$ <?= number_format($totalPedido, 2, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
