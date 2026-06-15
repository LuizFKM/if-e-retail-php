<!doctype html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Carrinho — IF Retail</title>
</head>
<?php require_once __DIR__ . "/../templates/template-menu-cliente.php" ?>
<body>

<div class="container py-5">
    <h2 class="page-title"><i class="bi bi-cart3 me-2"></i>Meu Carrinho</h2>

    <?php $itens = $carrinho->getItens(); ?>

    <?php if ($itens->isEmpty()): ?>
        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size:3rem;color:var(--amber);"></i>
            <p class="mt-3 text-muted">Seu carrinho está vazio.</p>
            <a href="<?= BASE_URL . '/produtos' ?>" class="btn btn-amber mt-2">
                <i class="bi bi-shop me-1"></i>Ver produtos
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive mb-4">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th class="text-center">Preço Unit.</th>
                        <th class="text-center" style="width:160px;">Quantidade</th>
                        <th class="text-end">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens as $item): ?>
                        <tr>
                            <td class="fw-semibold">
                                <?= htmlspecialchars($item->getProduto()->getDescricao()) ?>
                            </td>
                            <td class="text-center">
                                R$ <?= number_format($item->getPreco(), 2, ',', '.') ?>
                            </td>
                            <td class="text-center">
                                <!-- Formulário de atualização de quantidade -->
                                <form method="POST"
                                      action="<?= BASE_URL . '/carrinho/item/' . $item->getID() . '/quantidade' ?>"
                                      class="d-flex align-items-center justify-content-center gap-1">
                                    <input type="number"
                                           name="quantidade"
                                           value="<?= (int) $item->getQuantidade() ?>"
                                           min="0"
                                           class="form-control form-control-sm text-center"
                                           style="width:70px;">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary"
                                            title="Atualizar">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-end fw-bold" style="color:var(--amber);">
                                R$ <?= number_format($item->getPreco() * $item->getQuantidade(), 2, ',', '.') ?>
                            </td>
                            <td class="text-end">
                                <!-- Botão que abre o modal de confirmação -->
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="confirmarRemocao(
                                            '<?= BASE_URL . '/carrinho/item/' . $item->getID() . '/remover' ?>',
                                            '<?= htmlspecialchars($item->getProduto()->getDescricao(), ENT_QUOTES) ?>'
                                        )">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold" style="color:var(--coffee);">Total:</td>
                        <td class="text-end fw-bold fs-5" style="color:var(--coffee);">
                            R$ <?= number_format($carrinho->getValorTotal(), 2, ',', '.') ?>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="<?= BASE_URL . '/produtos' ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Continuar comprando
            </a>

            <form id="formFinalizar" method="POST" action="<?= BASE_URL . '/carrinho/finalizar' ?>">
                <button type="button" class="btn btn-amber btn-lg" onclick="confirmarFinalizacao()">
                    <i class="bi bi-bag-check me-2"></i>Finalizar compra
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<form id="formRemoverItem" method="POST" style="display:none;"></form>

<script>
function confirmarFinalizacao() {
    Swal.fire({
        title: 'Finalizar compra?',
        html: 'Seu pedido será confirmado e enviado para processamento.',
        icon: 'question',
        iconColor: '#C68A4C',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-bag-check me-1"></i> Confirmar pedido',
        cancelButtonText: 'Voltar',
        confirmButtonColor: '#C68A4C',
        cancelButtonColor: '#6c757d',
        customClass: {
            popup: 'rounded-4',
            confirmButton: 'rounded-pill px-4',
            cancelButton: 'rounded-pill px-4'
        }
    }).then(function (result) {
        if (result.isConfirmed) {
            document.getElementById('formFinalizar').submit();
        }
    });
}

function confirmarRemocao(action, nomeProduto) {
    Swal.fire({
        title: 'Remover item?',
        html: 'O produto <strong>' + nomeProduto + '</strong> será removido do carrinho.',
        icon: 'warning',
        iconColor: '#C68A4C',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-trash3 me-1"></i> Sim, remover',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        borderRadius: '16px',
        customClass: {
            popup: 'rounded-4',
            confirmButton: 'rounded-pill px-4',
            cancelButton: 'rounded-pill px-4'
        }
    }).then(function (result) {
        if (result.isConfirmed) {
            document.getElementById('formRemoverItem').action = action;
            document.getElementById('formRemoverItem').submit();
        }
    });
}
</script>

<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>
