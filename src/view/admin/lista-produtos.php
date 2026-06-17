<?php /** @var App\model\Produto[] $produtos */ ?>
<?php $erro = filter_input(INPUT_GET, 'erro', FILTER_SANITIZE_SPECIAL_CHARS); ?>

<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Produtos</h2>
        <a href="<?= BASE_URL . '/painel-administrativo/produtos/novo' ?>" class="btn btn-amber btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Novo Produto
        </a>
    </div>

    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <?php if (empty($produtos)): ?>
        <p class="text-muted">Nenhum produto cadastrado.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
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
                        <td>
                            <img src="<?= htmlspecialchars($produto->getUrlFotoProduto() ?? 'https://placehold.co/60x60') ?>"
                                 alt="Foto" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                        </td>
                        <td><?= htmlspecialchars($produto->getDescricao()) ?></td>
                        <td><?= htmlspecialchars($produto->getQuantidade()) ?></td>
                        <td>R$ <?= number_format($produto->getPrecoUnitario(), 2, ',', '.') ?></td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="<?= BASE_URL . '/painel-administrativo/produtos/' . $produto->getID() . '/editar' ?>"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form method="post"
                                      action="<?= BASE_URL . '/painel-administrativo/produtos/' . $produto->getID() . '/remover' ?>"
                                      style="display:inline"
                                      data-swal-confirm
                                      data-swal-title="Remover produto?"
                                      data-swal-text="<?= htmlspecialchars($produto->getDescricao()) ?> será removido permanentemente."
                                      data-swal-btn="Sim, remover">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Remover
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
