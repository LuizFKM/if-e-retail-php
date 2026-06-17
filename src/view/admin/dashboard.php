<?php
/**
 * @var int $totalProdutos
 * @var int $totalPedidos
 * @var int $pedidosPendentes
 * @var int $pedidosConcluidos
 * @var App\model\Pedido[] $pedidosRecentes
 */
?>

<div class="p-4">

    <!-- Saudação -->
    <div class="mb-4">
        <h2 class="mb-0">Painel Administrativo</h2>
        <p class="text-muted mb-0">Visão geral do sistema</p>
    </div>

    <!-- Cards de stats -->
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm h-100" style="border-left:4px solid var(--amber);border-color:var(--line);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;background:var(--cream);">
                        <i class="bi bi-box-seam fs-4" style="color:var(--amber);"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-3 lh-1" style="color:var(--coffee);"><?= $totalProdutos ?></div>
                        <div class="text-muted small mt-1">Produtos</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm h-100" style="border-left:4px solid #6c757d;border-color:var(--line);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;background:var(--cream);">
                        <i class="bi bi-cart3 fs-4 text-secondary"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-3 lh-1" style="color:var(--coffee);"><?= $totalPedidos ?></div>
                        <div class="text-muted small mt-1">Pedidos no total</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm h-100" style="border-left:4px solid #ffc107;border-color:var(--line);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;background:#fff8e1;">
                        <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-3 lh-1" style="color:var(--coffee);"><?= $pedidosPendentes ?></div>
                        <div class="text-muted small mt-1">Pendentes</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm h-100" style="border-left:4px solid #198754;border-color:var(--line);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;background:#e8f5e9;">
                        <i class="bi bi-check-circle fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-3 lh-1" style="color:var(--coffee);"><?= $pedidosConcluidos ?></div>
                        <div class="text-muted small mt-1">Concluídos</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Atalhos rápidos -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-color:var(--line);">
                <div class="card-header fw-semibold" style="background:var(--cream);color:var(--coffee);">
                    <i class="bi bi-lightning-charge me-2"></i>Atalhos
                </div>
                <div class="card-body d-flex flex-wrap gap-2">
                    <a href="<?= BASE_URL . '/painel-administrativo/produtos/novo' ?>" class="btn btn-amber btn-sm">
                        <i class="bi bi-plus-circle me-1"></i>Novo Produto
                    </a>
                    <a href="<?= BASE_URL . '/painel-administrativo/produtos' ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-box-seam me-1"></i>Ver Produtos
                    </a>
                    <a href="<?= BASE_URL . '/painel-administrativo/pedidos' ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-cart3 me-1"></i>Ver Pedidos
                    </a>
                    <a href="<?= BASE_URL . '/' ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-shop me-1"></i>Ver Loja
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pedidos recentes -->
    <div class="card shadow-sm" style="border-color:var(--line);">
        <div class="card-header d-flex justify-content-between align-items-center fw-semibold"
             style="background:var(--cream);color:var(--coffee);">
            <span><i class="bi bi-clock-history me-2"></i>Pedidos Recentes</span>
            <a href="<?= BASE_URL . '/painel-administrativo/pedidos' ?>" class="btn btn-outline-secondary btn-sm">Ver todos</a>
        </div>
        <div class="card-body p-0">
            <?php if (empty($pedidosRecentes)): ?>
                <p class="text-muted p-3 mb-0">Nenhum pedido registrado ainda.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:var(--cream);">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th class="pe-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pedidosRecentes as $pedido): ?>
                            <tr>
                                <td class="ps-3 text-muted fw-semibold">#<?= $pedido->getID() ?></td>
                                <td><?= htmlspecialchars($pedido->getCliente()?->getName() ?? '—') ?></td>
                                <td><?= $pedido->getDataPedido()?->format('d/m/Y') ?? '—' ?></td>
                                <td>
                                    <?php if ($pedido->getStatus()): ?>
                                        <span class="badge bg-success">Concluído</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pendente</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-3 text-end">
                                    <a href="<?= BASE_URL . '/painel-administrativo/pedidos/' . $pedido->getID() ?>"
                                       class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
