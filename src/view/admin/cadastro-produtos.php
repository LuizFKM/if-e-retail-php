<?php /** @var App\model\Produto $produto */ ?>
<?php
$erro      = filter_input(INPUT_GET, 'erro', FILTER_SANITIZE_SPECIAL_CHARS);
$fotoAtual = $produto->getUrlFotoProduto();
?>

<div class="p-4">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="<?= BASE_URL . '/painel-administrativo/produtos' ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="mb-0"><?= $produto->getID() ? 'Editar Produto' : 'Cadastro de Produto' ?></h2>
            <p class="text-muted mb-0 small"><?= $produto->getID() ? 'Atualize os dados do produto' : 'Preencha os dados do produto' ?></p>
        </div>
    </div>

    <?php if ($erro): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" style="border-radius:10px;">
            <i class="bi bi-exclamation-circle-fill fs-5"></i>
            <span><?= htmlspecialchars($erro) ?></span>
        </div>
    <?php endif; ?>

    <form id="formProduto"
          action="<?= BASE_URL . '/painel-administrativo/produtos/cadastrar' ?>"
          method="POST"
          enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= htmlspecialchars($produto->getId() ?? '') ?>">
        <!-- Input de arquivo oculto — acionado pelo clique na foto -->
        <input type="file" name="imagem_produto" id="imagem_produto" accept="image/*" style="display:none;">

        <div class="row g-4">

            <!-- Coluna esquerda: foto -->
            <div class="col-md-4 d-flex flex-column align-items-center gap-3">

                <!-- Área clicável da foto -->
                <div id="fotoWrapper"
                     onclick="document.getElementById('imagem_produto').click()"
                     style="position:relative;width:180px;height:180px;cursor:pointer;border-radius:12px;overflow:hidden;border:3px solid var(--amber);flex-shrink:0;">

                    <?php if ($fotoAtual): ?>
                        <img id="fotoAtual"
                             src="<?= htmlspecialchars($fotoAtual) ?>"
                             style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <div id="fotoAtual"
                             class="w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                             style="background:var(--cream);">
                            <i class="bi bi-image" style="font-size:3rem;color:var(--amber);"></i>
                            <span class="small text-muted mt-1">Sem foto</span>
                        </div>
                    <?php endif; ?>

                    <!-- Overlay de hover -->
                    <div id="fotoOverlay"
                         class="w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                         style="position:absolute;top:0;left:0;background:rgba(0,0,0,.45);opacity:0;transition:opacity .2s;">
                        <i class="bi bi-camera-fill text-white" style="font-size:1.6rem;"></i>
                        <span class="text-white mt-1" style="font-size:.65rem;font-weight:700;letter-spacing:.5px;">ALTERAR FOTO</span>
                    </div>
                </div>

                <span class="badge rounded-pill" style="background:var(--cream);color:var(--brown);font-size:.72rem;">
                    <i class="bi bi-images me-1"></i>JPG · PNG · WEBP
                </span>
                <p class="text-muted small text-center mb-0">Clique na imagem para escolher a foto do produto.</p>
            </div>

            <!-- Coluna direita: campos -->
            <div class="col-md-8 d-flex flex-column gap-3">

                <div>
                    <label for="descricao" class="form-label fw-semibold small" style="color:var(--coffee);">Descrição do produto</label>
                    <input id="descricao" name="descricao" type="text" class="form-control"
                           placeholder="Ex.: Camiseta Básica Branca"
                           value="<?= htmlspecialchars($produto->getDescricao() ?? '') ?>" required>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="precoUnitario" class="form-label fw-semibold small" style="color:var(--coffee);">Preço Unitário (R$)</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:var(--cream);border-color:var(--line);color:var(--amber);">R$</span>
                            <input id="precoUnitario" name="precoUnitario" type="text"
                                   class="form-control"
                                   placeholder="0,00"
                                   value="<?= $produto->getPrecoUnitario() ? number_format((float)$produto->getPrecoUnitario(), 2, ',', '.') : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="quantidadeEmEstoque" class="form-label fw-semibold small" style="color:var(--coffee);">Qtd. em estoque</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:var(--cream);border-color:var(--line);color:var(--amber);">
                                <i class="bi bi-boxes"></i>
                            </span>
                            <input id="quantidadeEmEstoque" name="quantidadeEmEstoque" type="number"
                                   min="0" class="form-control"
                                   placeholder="0"
                                   value="<?= htmlspecialchars($produto->getQuantidade() ?? '') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-amber px-4">
                        <i class="bi bi-floppy me-1"></i>Salvar produto
                    </button>
                    <a href="<?= BASE_URL . '/painel-administrativo/produtos' ?>" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>

            </div>
        </div>

    </form>
</div>

<!-- Modal de preview da foto -->
<div class="modal fade" id="modalPreviewFoto" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content rounded-4 overflow-hidden">
            <div class="modal-header border-0 pb-0" style="background:var(--paper);">
                <h6 class="modal-title fw-bold w-100 text-center" style="color:var(--coffee);">
                    <i class="bi bi-image me-1" style="color:var(--amber);"></i>Foto do produto
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="cancelarPreview()"></button>
            </div>
            <div class="modal-body text-center px-4 py-3" style="background:var(--paper);">
                <img id="previewNovaFoto" src="" alt="Preview"
                     style="width:200px;height:200px;object-fit:cover;border-radius:12px;border:3px solid var(--amber);box-shadow:0 4px 20px rgba(0,0,0,.12);">
                <p class="text-muted small mt-3 mb-0">É assim que a foto vai aparecer no produto.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2 pb-4" style="background:var(--paper);">
                <button type="button" class="btn btn-outline-secondary px-4 rounded-pill"
                        data-bs-dismiss="modal" onclick="cancelarPreview()">Cancelar</button>
                <button type="button" class="btn btn-amber px-4 rounded-pill"
                        data-bs-dismiss="modal">
                    <i class="bi bi-check-lg me-1"></i>Usar esta foto
                </button>
            </div>
        </div>
    </div>
</div>

