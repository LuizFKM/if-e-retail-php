<?php
/** @var \App\model\Cliente $cliente */
$contato  = $cliente->getContatos()->first() ?: null;
$endereco = $cliente->getEndereco();
$fotoAtual = $cliente->getUrlFotoPerfil();
?>

<h5 class="fw-bold mb-4" style="color:var(--coffee);">
    <i class="bi bi-gear-fill me-2" style="color:var(--amber);"></i>Configurações da Conta
</h5>

<?php if (!empty($ok)): ?>
    <div class="alert alert-success py-2">Dados salvos com sucesso!</div>
<?php endif; ?>
<?php if ($erro = filter_input(INPUT_GET, 'erro')): ?>
    <div class="alert alert-danger py-2"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>


<!-- ===== Bloco 1: Dados pessoais ===== -->
<div class="card mb-4 shadow-sm" style="border-color:var(--line);">
    <div class="card-header fw-bold" style="background:var(--cream);color:var(--coffee);">
        <i class="bi bi-person me-2"></i>Dados Pessoais
    </div>
    <div class="card-body">

        <!-- ── FOTO DE PERFIL — preview estilo Facebook ── -->
        <label class="form-label fw-semibold d-block mb-3">Foto de Perfil</label>

        <!-- Avatar clicável com overlay de câmera -->
        <div class="d-flex align-items-center gap-4 mb-3">
            <div id="avatarWrapper" style="position:relative;width:110px;height:110px;cursor:pointer;"
                 onclick="$('#imagem_cliente').click()">

                <!-- Foto atual ou ícone padrão -->
                <?php if ($fotoAtual): ?>
                    <img id="avatarAtual"
                         src="<?= htmlspecialchars($fotoAtual) ?>"
                         class="rounded-circle w-100 h-100"
                         style="object-fit:cover;border:3px solid var(--amber);">
                <?php else: ?>
                    <div id="avatarAtual"
                         class="rounded-circle w-100 h-100 d-flex align-items-center justify-content-center"
                         style="background:var(--cream);border:3px solid var(--amber);">
                        <i class="bi bi-person-fill" style="font-size:3.5rem;color:var(--amber);"></i>
                    </div>
                <?php endif; ?>

                <!-- Overlay escuro com ícone de câmera ao hover -->
                <div id="avatarOverlay"
                     class="rounded-circle w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                     style="position:absolute;top:0;left:0;
                            background:rgba(0,0,0,0.45);
                            opacity:0;transition:opacity .2s;">
                    <i class="bi bi-camera-fill text-white" style="font-size:1.6rem;"></i>
                    <span class="text-white" style="font-size:0.65rem;font-weight:600;letter-spacing:.5px;">
                        ALTERAR
                    </span>
                </div>
            </div>

            <div class="text-muted small" style="max-width:200px;">
                Clique na foto para escolher uma nova imagem.<br>
                Formatos aceitos: JPG, PNG, WEBP.
            </div>
        </div>

        <!-- Input de arquivo oculto — acionado pelo clique no avatar -->
        <form id="formFoto"
              method="POST"
              action="<?= BASE_URL . '/perfil/foto' ?>"
              enctype="multipart/form-data">
            <input type="file"
                   name="imagem_cliente"
                   id="imagem_cliente"
                   accept="image/*"
                   style="display:none;">
        </form>

        <!-- ─────────────────────────────────────────────────────────
             Modal de preview — abre assim que o usuário escolhe o arquivo
        ────────────────────────────────────────────────────────── -->
        <div class="modal fade" id="modalPreviewFoto" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
                <div class="modal-content" style="border-radius:16px;overflow:hidden;">

                    <!-- Cabeçalho estilo Facebook -->
                    <div class="modal-header border-0 pb-0"
                         style="background:var(--paper);">
                        <h6 class="modal-title fw-bold w-100 text-center" style="color:var(--coffee);">
                            Atualizar foto do perfil
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                onclick="cancelarPreview()"></button>
                    </div>

                    <div class="modal-body text-center px-4 py-3" style="background:var(--paper);">

                        <!-- Preview circular da nova foto -->
                        <div style="position:relative;display:inline-block;">
                            <img id="previewNovaFoto"
                                 src=""
                                 class="rounded-circle"
                                 style="width:200px;height:200px;
                                        object-fit:cover;
                                        border:4px solid var(--amber);
                                        box-shadow:0 4px 20px rgba(0,0,0,.15);">
                        </div>

                        <p class="text-muted small mt-3 mb-0">
                            É assim que sua foto vai aparecer no perfil e no menu.
                        </p>
                    </div>

                    <!-- Botões: Salvar ou Cancelar -->
                    <div class="modal-footer border-0 justify-content-center gap-2 pb-4"
                         style="background:var(--paper);">
                        <button type="button"
                                class="btn btn-outline-secondary px-4"
                                data-bs-dismiss="modal"
                                onclick="cancelarPreview()">
                            Cancelar
                        </button>
                        <button type="button"
                                class="btn btn-amber px-4"
                                onclick="document.getElementById('formFoto').submit()">
                            <i class="bi bi-check-lg me-1"></i>Salvar foto do perfil
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <!-- ── fim modal preview ── -->

        <hr style="border-color:var(--line);">

        <!-- Formulário de dados pessoais -->
        <form method="POST" action="<?= BASE_URL . '/perfil/dados' ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control"
                           value="<?= htmlspecialchars($cliente->getName() ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail (contato)</label>
                    <!-- Nota: Contato::$email é distinto de UserModel::$login (e-mail de acesso).
                         Não unificamos os dois campos para não quebrar o fluxo de cadastro existente. -->
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($contato?->getEmail() ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-control"
                           value="<?= htmlspecialchars($contato?->getTelefone() ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nova Senha
                        <small class="text-muted">(deixe em branco para manter)</small>
                    </label>
                    <input type="password" name="senha" class="form-control" autocomplete="new-password">
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-amber">
                    <i class="bi bi-check-lg me-1"></i>Salvar dados
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== Bloco 2: Endereço ===== -->
<div class="card mb-4 shadow-sm" style="border-color:var(--line);">
    <div class="card-header fw-bold" style="background:var(--cream);color:var(--coffee);">
        <i class="bi bi-geo-alt me-2"></i>Endereço de Entrega
    </div>
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL . '/perfil/endereco' ?>">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Rua</label>
                    <input type="text" name="rua" class="form-control"
                           value="<?= htmlspecialchars($endereco?->getRua() ?? '') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Número</label>
                    <input type="text" name="numero" class="form-control"
                           value="<?= htmlspecialchars($endereco?->getNumero() ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Complemento</label>
                    <input type="text" name="complemento" class="form-control"
                           value="<?= htmlspecialchars($endereco?->getComplemento() ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bairro</label>
                    <input type="text" name="bairro" class="form-control"
                           value="<?= htmlspecialchars($endereco?->getBairro() ?? '') ?>" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Cidade</label>
                    <input type="text" name="cidade" class="form-control"
                           value="<?= htmlspecialchars($endereco?->getCidade() ?? '') ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <input type="text" name="estado" class="form-control" maxlength="2"
                           value="<?= htmlspecialchars($endereco?->getEstado() ?? '') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">CEP</label>
                    <input type="text" name="cep" class="form-control" id="cep"
                           value="<?= htmlspecialchars($endereco?->getCep() ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">País</label>
                    <input type="text" name="pais" class="form-control"
                           value="<?= htmlspecialchars($endereco?->getPais() ?? 'Brasil') ?>" required>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-amber">
                    <i class="bi bi-check-lg me-1"></i>Salvar endereço
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== Bloco 3: Excluir conta ===== -->
<div class="card shadow-sm" style="border-color:#f5c6c6;">
    <div class="card-header fw-bold" style="background:#fff3f3;color:#842029;">
        <i class="bi bi-exclamation-triangle me-2"></i>Zona de Perigo
    </div>
    <div class="card-body">
        <p class="text-muted small">
            Ao excluir sua conta, todos os seus dados (favoritos, pedidos e foto) serão permanentemente removidos.
        </p>
        <button type="button" class="btn btn-outline-danger btn-sm"
                data-bs-toggle="modal" data-bs-target="#modalExcluirConta">
            <i class="bi bi-trash me-1"></i>Excluir minha conta
        </button>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="modalExcluirConta" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirmar exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir sua conta? Esta ação <strong>não pode ser desfeita</strong>.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="<?= BASE_URL . '/perfil/excluir' ?>">
                    <button type="submit" class="btn btn-danger">Sim, excluir minha conta</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Vanilla JS puro — não depende do jQuery que carrega depois no rodapé
document.addEventListener('DOMContentLoaded', function () {

    var avatarWrapper  = document.getElementById('avatarWrapper');
    var avatarOverlay  = document.getElementById('avatarOverlay');
    var inputImagem    = document.getElementById('imagem_cliente');
    var previewFoto    = document.getElementById('previewNovaFoto');

    // Hover no avatar: mostra/esconde overlay de câmera
    if (avatarWrapper && avatarOverlay) {
        avatarWrapper.addEventListener('mouseenter', function () {
            avatarOverlay.style.opacity = 1;
        });
        avatarWrapper.addEventListener('mouseleave', function () {
            avatarOverlay.style.opacity = 0;
        });
    }

    // Quando o usuário escolhe um arquivo: lê localmente e abre modal de preview
    if (inputImagem) {
        inputImagem.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;

            var reader = new FileReader();
            reader.onload = function (e) {
                previewFoto.src = e.target.result;
                // Bootstrap já carregado via CDN no <head> ou rodapé
                var modal = new bootstrap.Modal(document.getElementById('modalPreviewFoto'));
                modal.show();
            };
            reader.readAsDataURL(file);
        });
    }
});

// Cancelar preview: limpa o input para não enviar arquivo acidentalmente
function cancelarPreview() {
    document.getElementById('imagem_cliente').value = '';
}
</script>
