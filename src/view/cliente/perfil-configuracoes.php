<?php
/** @var \App\model\Cliente $cliente */
$contato   = $cliente->getContatos()->first() ?: null;
$endereco  = $cliente->getEndereco();
$fotoAtual = $cliente->getUrlFotoPerfil();
?>
<style>
/* ── Inputs e selects com foco amber ── */
.form-control:focus,
.form-select:focus {
    border-color: var(--amber);
    box-shadow: 0 0 0 .2rem rgba(198,138,76,.2);
}
.input-group-text {
    background: var(--cream);
    border-color: var(--line);
    color: var(--amber);
}
.form-control,
.form-select {
    border-color: var(--line);
}
/* ── Card header personalizado ── */
.card-header-perfil {
    background: linear-gradient(90deg, var(--cream) 0%, var(--paper) 100%);
    border-bottom: 2px solid var(--line);
    padding: .85rem 1.25rem;
}
/* ── Badge de seção ── */
.badge-secao {
    background: var(--amber);
    color: var(--coffee-deep);
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .5px;
    padding: .3em .65em;
    border-radius: 20px;
}
/* ── Select de cidade/estado ── */
.select-perfil:disabled {
    background-color: var(--cream);
    cursor: not-allowed;
    opacity: .7;
}
/* ── Zona de Perigo ── */
.danger-card {
    border: 1.5px solid #f5c6c6;
    border-radius: 12px;
}
.danger-card .card-header {
    background: linear-gradient(90deg,#fff3f3,#fff8f8);
    border-bottom: 1.5px solid #f5c6c6;
    color: #842029;
}
</style>

<?php if (!empty($ok)): ?>
    <div class="alert border-0 d-flex align-items-center gap-2 mb-4"
         style="background:var(--cream);color:var(--coffee);border-left:4px solid var(--amber) !important;border-radius:10px;">
        <i class="bi bi-check-circle-fill fs-5" style="color:var(--amber);"></i>
        <span class="fw-semibold">Dados salvos com sucesso!</span>
    </div>
<?php endif; ?>
<?php if ($erro = filter_input(INPUT_GET, 'erro')): ?>
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" style="border-radius:10px;">
        <i class="bi bi-exclamation-circle-fill fs-5"></i>
        <span><?= htmlspecialchars($erro) ?></span>
    </div>
<?php endif; ?>

<!-- ===== Bloco 1: Dados Pessoais ===== -->
<div class="card mb-4 shadow-sm rounded-3 overflow-hidden" style="border:1.5px solid var(--line);">
    <div class="card-header-perfil d-flex align-items-center gap-2">
        <i class="bi bi-person-fill fs-5" style="color:var(--amber);"></i>
        <span class="fw-bold" style="color:var(--coffee);">Dados Pessoais</span>
        <span class="badge-secao ms-auto">PERFIL</span>
    </div>
    <div class="card-body p-4">

        <!-- ── FOTO DE PERFIL ── -->
        <div class="d-flex align-items-center gap-4 mb-4 pb-4" style="border-bottom:1px solid var(--line);">
            <div id="avatarWrapper" style="position:relative;width:100px;height:100px;cursor:pointer;flex-shrink:0;"
                 onclick="document.getElementById('imagem_cliente').click()">
                <?php if ($fotoAtual): ?>
                    <img id="avatarAtual" src="<?= htmlspecialchars($fotoAtual) ?>"
                         class="rounded-circle w-100 h-100"
                         style="object-fit:cover;border:3px solid var(--amber);">
                <?php else: ?>
                    <div id="avatarAtual"
                         class="rounded-circle w-100 h-100 d-flex align-items-center justify-content-center"
                         style="background:var(--cream);border:3px solid var(--amber);">
                        <i class="bi bi-person-fill" style="font-size:3rem;color:var(--amber);"></i>
                    </div>
                <?php endif; ?>
                <div id="avatarOverlay"
                     class="rounded-circle w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                     style="position:absolute;top:0;left:0;background:rgba(0,0,0,.45);opacity:0;transition:opacity .2s;">
                    <i class="bi bi-camera-fill text-white" style="font-size:1.4rem;"></i>
                    <span class="text-white" style="font-size:.6rem;font-weight:700;letter-spacing:.5px;margin-top:2px;">ALTERAR</span>
                </div>
            </div>
            <div>
                <p class="fw-semibold mb-1" style="color:var(--coffee);">Foto de Perfil</p>
                <p class="text-muted small mb-2">Clique no avatar para escolher uma nova imagem.</p>
                <span class="badge rounded-pill" style="background:var(--cream);color:var(--brown);font-size:.72rem;">
                    <i class="bi bi-images me-1"></i>JPG · PNG · WEBP
                </span>
            </div>
        </div>

        <!-- Input de arquivo oculto -->
        <form id="formFoto" method="POST" action="<?= BASE_URL . '/perfil/foto' ?>" enctype="multipart/form-data">
            <input type="file" name="imagem_cliente" id="imagem_cliente" accept="image/*" style="display:none;">
        </form>

        <!-- Modal de preview de foto -->
        <div class="modal fade" id="modalPreviewFoto" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
                <div class="modal-content rounded-4 overflow-hidden">
                    <div class="modal-header border-0 pb-0" style="background:var(--paper);">
                        <h6 class="modal-title fw-bold w-100 text-center" style="color:var(--coffee);">
                            <i class="bi bi-camera me-1" style="color:var(--amber);"></i>Atualizar foto do perfil
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="cancelarPreview()"></button>
                    </div>
                    <div class="modal-body text-center px-4 py-3" style="background:var(--paper);">
                        <img id="previewNovaFoto" src="" class="rounded-circle"
                             style="width:200px;height:200px;object-fit:cover;border:4px solid var(--amber);box-shadow:0 4px 20px rgba(0,0,0,.15);">
                        <p class="text-muted small mt-3 mb-0">É assim que sua foto vai aparecer no perfil.</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center gap-2 pb-4" style="background:var(--paper);">
                        <button type="button" class="btn btn-outline-secondary px-4 rounded-pill"
                                data-bs-dismiss="modal" onclick="cancelarPreview()">Cancelar</button>
                        <button type="button" class="btn btn-amber px-4 rounded-pill"
                                onclick="document.getElementById('formFoto').submit()">
                            <i class="bi bi-check-lg me-1"></i>Salvar foto
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulário de dados pessoais -->
        <form method="POST" action="<?= BASE_URL . '/perfil/dados' ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-person me-1" style="color:var(--amber);"></i>Nome Completo
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" class="form-control"
                               placeholder="Seu nome completo"
                               value="<?= htmlspecialchars($cliente->getName() ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-envelope me-1" style="color:var(--amber);"></i>E-mail de Contato
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control"
                               placeholder="seu@email.com"
                               value="<?= htmlspecialchars($contato?->getEmail() ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-telephone me-1" style="color:var(--amber);"></i>Telefone
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" name="telefone" id="telefone" class="form-control"
                               placeholder="(00) 00000-0000"
                               value="<?= htmlspecialchars($contato?->getTelefone() ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-lock me-1" style="color:var(--amber);"></i>Nova Senha
                        <span class="text-muted fw-normal">(deixe em branco para manter)</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="senha" class="form-control"
                               placeholder="••••••••" autocomplete="new-password">
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-amber rounded-pill px-4">
                    <i class="bi bi-floppy me-1"></i>Salvar dados
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== Bloco 2: Endereço ===== -->
<div class="card mb-4 shadow-sm rounded-3 overflow-hidden" style="border:1.5px solid var(--line);">
    <div class="card-header-perfil d-flex align-items-center gap-2">
        <i class="bi bi-house-fill fs-5" style="color:var(--amber);"></i>
        <span class="fw-bold" style="color:var(--coffee);">Endereço de Entrega</span>
        <span class="badge-secao ms-auto">ENTREGA</span>
    </div>
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL . '/perfil/endereco' ?>">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-signpost me-1" style="color:var(--amber);"></i>Rua
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-signpost"></i></span>
                        <input type="text" name="rua" class="form-control"
                               placeholder="Nome da rua ou avenida"
                               value="<?= htmlspecialchars($endereco?->getRua() ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-hash me-1" style="color:var(--amber);"></i>Número
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-hash"></i></span>
                        <input type="text" name="numero" class="form-control"
                               placeholder="Ex.: 123"
                               value="<?= htmlspecialchars($endereco?->getNumero() ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-info-circle me-1" style="color:var(--amber);"></i>Complemento
                        <span class="text-muted fw-normal">(opcional)</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                        <input type="text" name="complemento" class="form-control"
                               placeholder="Apto, bloco, sala..."
                               value="<?= htmlspecialchars($endereco?->getComplemento() ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-geo me-1" style="color:var(--amber);"></i>Bairro
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo"></i></span>
                        <input type="text" name="bairro" class="form-control"
                               placeholder="Nome do bairro"
                               value="<?= htmlspecialchars($endereco?->getBairro() ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-map me-1" style="color:var(--amber);"></i>Estado
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-map"></i></span>
                        <select name="estado" id="selectEstado" class="form-select select-perfil" required>
                            <option value="">UF...</option>
                            <?php
                            $ufsVistas = [];
                            foreach ($cidades as $c):
                                $uf = $c->getEstado();
                                if (in_array($uf, $ufsVistas)) continue;
                                $ufsVistas[] = $uf;
                            ?>
                                <option value="<?= htmlspecialchars($uf) ?>"
                                    <?= ($endereco?->getEstado() === $uf ? 'selected' : '') ?>>
                                    <?= htmlspecialchars($uf) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-geo-alt me-1" style="color:var(--amber);"></i>Cidade
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                        <select name="cidade" id="selectCidade" class="form-select select-perfil" required>
                            <option value="">Selecione a cidade...</option>
                            <?php foreach ($cidades as $c): ?>
                                <option value="<?= htmlspecialchars($c->getNome()) ?>"
                                        data-uf="<?= htmlspecialchars($c->getEstado()) ?>"
                                    <?= ($endereco?->getCidade() === $c->getNome() ? 'selected' : '') ?>>
                                    <?= htmlspecialchars($c->getNome()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-mailbox me-1" style="color:var(--amber);"></i>CEP
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-mailbox"></i></span>
                        <input type="text" name="cep" id="cep" class="form-control"
                               placeholder="00000-000"
                               value="<?= htmlspecialchars($endereco?->getCep() ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small" style="color:var(--coffee);">
                        <i class="bi bi-globe-americas me-1" style="color:var(--amber);"></i>País
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-globe-americas"></i></span>
                        <input type="text" name="pais" class="form-control"
                               placeholder="País"
                               value="<?= htmlspecialchars($endereco?->getPais() ?? 'Brasil') ?>" required>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-amber rounded-pill px-4">
                    <i class="bi bi-floppy me-1"></i>Salvar endereço
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== Bloco 3: Zona de Perigo ===== -->
<div class="card danger-card shadow-sm mb-2">
    <div class="card-header d-flex align-items-center gap-2 fw-bold">
        <i class="bi bi-shield-exclamation fs-5"></i>Zona de Perigo
    </div>
    <div class="card-body p-4">
        <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:44px;height:44px;background:#fff0f0;border:1.5px solid #f5c6c6;">
                <i class="bi bi-trash3 text-danger fs-5"></i>
            </div>
            <div>
                <p class="fw-semibold mb-1 text-danger">Excluir minha conta</p>
                <p class="text-muted small mb-3">
                    Ao excluir sua conta, todos os seus dados — favoritos, pedidos, endereço e foto — serão <strong>permanentemente removidos</strong> e não poderão ser recuperados.
                </p>
                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3"
                        data-bs-toggle="modal" data-bs-target="#modalExcluirConta">
                    <i class="bi bi-trash3 me-1"></i>Excluir minha conta
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="modalExcluirConta" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 overflow-hidden">
            <div class="modal-header" style="background:#fff3f3;border-bottom:1px solid #f5c6c6;">
                <h5 class="modal-title text-danger fw-bold">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirmar exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-0">Tem certeza que deseja excluir sua conta?</p>
                <p class="text-danger fw-semibold mt-2 mb-0">
                    <i class="bi bi-exclamation-circle me-1"></i>Esta ação não pode ser desfeita.
                </p>
            </div>
            <div class="modal-footer" style="background:#fafafa;">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="<?= BASE_URL . '/perfil/excluir' ?>">
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-trash3 me-1"></i>Sim, excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var avatarWrapper = document.getElementById('avatarWrapper');
    var avatarOverlay = document.getElementById('avatarOverlay');
    var inputImagem   = document.getElementById('imagem_cliente');
    var previewFoto   = document.getElementById('previewNovaFoto');

    if (avatarWrapper && avatarOverlay) {
        avatarWrapper.addEventListener('mouseenter', function () { avatarOverlay.style.opacity = 1; });
        avatarWrapper.addEventListener('mouseleave', function () { avatarOverlay.style.opacity = 0; });
    }

    if (inputImagem) {
        inputImagem.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                previewFoto.src = e.target.result;
                new bootstrap.Modal(document.getElementById('modalPreviewFoto')).show();
            };
            reader.readAsDataURL(file);
        });
    }
});

function cancelarPreview() {
    document.getElementById('imagem_cliente').value = '';
}
</script>

<script>
(function () {
    var selEstado = document.getElementById('selectEstado');
    var selCidade = document.getElementById('selectCidade');

    if (!selEstado || !selCidade) return;

    var todasCidades = Array.from(selCidade.querySelectorAll('option[data-uf]')).map(function (opt) {
        return { valor: opt.value, uf: opt.dataset.uf };
    });

    function popularCidades(uf, cidadeSalva) {
        selCidade.innerHTML = '<option value="">Selecione a cidade...</option>';
        if (!uf) { selCidade.disabled = true; return; }

        todasCidades.filter(function (c) { return c.uf === uf; }).forEach(function (c) {
            var opt = document.createElement('option');
            opt.value = c.valor;
            opt.textContent = c.valor;
            if (c.valor === cidadeSalva) opt.selected = true;
            selCidade.appendChild(opt);
        });
        selCidade.disabled = false;
    }

    selEstado.addEventListener('change', function () { popularCidades(this.value, null); });
    popularCidades(selEstado.value, selCidade.value);
}());
</script>
