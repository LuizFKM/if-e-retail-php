<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/templates/template-head.php" ?>
    <title>Checkout — IF-E-RETAIL</title>
</head>
<body>
    <?php require_once __DIR__ . "/templates/template-nav.php" ?>

    <div class="container py-5">
        <h2 class="fw-bold mb-4" style="color: var(--coffee);">
            <i class="bi bi-credit-card me-2"></i>Finalizar Compra
        </h2>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm" style="background-color: var(--cream);">
                    <div class="card-header fw-bold border-0" style="background-color: var(--coffee); color: var(--sand);">
                        <i class="bi bi-geo-alt me-2"></i>Dados de entrega
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL . '/loja/checkout/finalizar' ?>">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nome completo</label>
                                <input type="text" class="form-control" style="border-color: var(--line);"
                                       value="<?= htmlspecialchars($_SESSION['usuario_nome'] ?? '') ?>" required>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Endereço</label>
                                    <input type="text" class="form-control" style="border-color: var(--line);" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">CEP</label>
                                    <input type="text" class="form-control" style="border-color: var(--line);" required>
                                </div>
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Cidade</label>
                                    <input type="text" class="form-control" style="border-color: var(--line);" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Estado</label>
                                    <input type="text" class="form-control" style="border-color: var(--line);" required>
                                </div>
                            </div>
                            <hr style="border-color: var(--line);">
                            <h6 class="fw-bold mb-3" style="color: var(--coffee);">
                                <i class="bi bi-credit-card me-2"></i>Pagamento
                            </h6>
                            <div class="mb-3">
                                <select class="form-select" style="border-color: var(--line);" required>
                                    <option value="">Selecione a forma de pagamento</option>
                                    <option>Cartão de crédito</option>
                                    <option>Cartão de débito</option>
                                    <option>PIX</option>
                                    <option>Boleto</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-amber btn-lg w-100">
                                <i class="bi bi-check-circle me-2"></i> Confirmar pedido
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm" style="background-color: var(--coffee); color: var(--sand);">
                    <div class="card-header fw-bold border-0" style="background-color: var(--coffee-deep); color: var(--amber);">
                        <i class="bi bi-receipt me-2"></i>Resumo do pedido
                    </div>
                    <div class="card-body">
                        <?php foreach ($itens as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?= htmlspecialchars($item['produto']->getDescricao()) ?>
                                <small class="text-secondary">x<?= $item['quantidade'] ?></small>
                            </span>
                            <span>R$ <?= number_format($item['produto']->getPrecoUnitario() * $item['quantidade'], 2, ',', '.') ?></span>
                        </div>
                        <?php endforeach; ?>
                        <hr style="border-color: var(--coffee-deep);">
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span style="color: var(--amber);">R$ <?= number_format($subtotal, 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . "/templates/template-rodape.php" ?>
</body>
</html>
