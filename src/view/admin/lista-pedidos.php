<?php /** @var App\model\Pedido[] $pedidos */ ?>

<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Pedidos</h2>
        <span class="text-muted small"><?= count($pedidos ?? []) ?> pedido(s)</span>
    </div>

    <?php if (empty($pedidos)): ?>
        <p class="text-muted">Nenhum pedido registrado.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Data do Pedido</th>
                        <th>Entrega Prevista</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td class="fw-semibold text-muted">#<?= htmlspecialchars($pedido->getID()) ?></td>
                        <td><?= htmlspecialchars($pedido->getCliente()?->getName() ?? '—') ?></td>
                        <td><?= $pedido->getDataPedido()?->format('d/m/Y') ?? '—' ?></td>
                        <td><?= $pedido->getDataEntrega()?->format('d/m/Y') ?? '—' ?></td>
                        <td>
                            <?php if ($pedido->getStatus()): ?>
                                <span class="badge bg-success">Concluído</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Pendente</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?= BASE_URL . '/painel-administrativo/pedidos/' . $pedido->getID() ?>"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <form method="post"
                                  action="<?= BASE_URL . '/painel-administrativo/pedidos/' . $pedido->getID() . '/remover' ?>"
                                  style="display:inline"
                                  data-swal-confirm
                                  data-swal-title="Remover pedido #<?= $pedido->getID() ?>?"
                                  data-swal-text="Os itens do pedido também serão removidos."
                                  data-swal-btn="Sim, remover">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
