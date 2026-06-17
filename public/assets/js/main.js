$(document).ready(function () {

    // ── Máscaras ─────────────────────────────────────────────────────────────
    // formCadastro
    $('#cpf').mask('000.000.000-00');

    // formProduto (admin)
    $('#precoUnitario').mask('000.000.000.000.000,00', { reverse: true });

    // formDados | formEndereco (perfil do cliente)
    $('#telefone').mask('(00) 00000-0000');
    $('#cep').mask('00000-000');

    // ── Validação: formCadastro ───────────────────────────────────────────────
    $('#formCadastro').validate({
        rules: {
            name:           { required: true, minlength: 3 },
            login:          { required: true, email: true },
            cpf:            { required: true, minlength: 14, maxlength: 14 },
            senha:          { required: true, minlength: 6 },
            dataNascimento: { required: true }
        },
        messages: {
            name:           { required: 'O nome é obrigatório.', minlength: 'Mínimo 3 caracteres.' },
            login:          { required: 'O e-mail é obrigatório.', email: 'Digite um e-mail válido.' },
            cpf:            { required: 'O CPF é obrigatório.', minlength: 'Preencha o CPF completo.', maxlength: 'Preencha o CPF completo.' },
            senha:          { required: 'A senha é obrigatória.', minlength: 'Mínimo 6 caracteres.' },
            dataNascimento: { required: 'Informe a data de nascimento.' }
        },
        errorElement:   'span',
        errorClass:     'text-danger small d-block mt-1',
        errorPlacement: function (error, element) {
            var group = element.closest('.input-group');
            if (group.length) { error.insertAfter(group); } else { error.insertAfter(element); }
        }
    });

    // ── Validação: formProduto ───────────────────────────────────────────────
    $('#formProduto').validate({
        rules: {
            descricao:           { required: true, minlength: 3 },
            precoUnitario:       { required: true },
            quantidadeEmEstoque: { required: true }
        },
        messages: {
            descricao:           { required: 'A descrição é obrigatória.', minlength: 'Mínimo 3 caracteres.' },
            precoUnitario:       { required: 'Informe o preço.' },
            quantidadeEmEstoque: { required: 'Informe a quantidade.' }
        },
        errorElement:   'span',
        errorClass:     'text-danger small d-block mt-1',
        errorPlacement: function (error, element) {
            var group = element.closest('.input-group');
            if (group.length) { error.insertAfter(group); } else { error.insertAfter(element); }
        }
    });

    // ── Filtro cidade/estado (perfil do cliente) ────────────────────────────
    var selEstado = document.getElementById('selectEstado');
    var selCidade = document.getElementById('selectCidade');
    if (selEstado && selCidade) {
        var todasCidades = Array.from(selCidade.querySelectorAll('option[data-uf]')).map(function (opt) {
            return { valor: opt.value, uf: opt.dataset.uf };
        });
        function popularCidades(uf, cidadeSalva) {
            selCidade.innerHTML = '<option value="">Selecione a cidade...</option>';
            if (!uf) { selCidade.disabled = true; return; }
            todasCidades.filter(function (c) { return c.uf === uf; }).forEach(function (c) {
                var opt = document.createElement('option');
                opt.value       = c.valor;
                opt.textContent = c.valor;
                if (c.valor === cidadeSalva) opt.selected = true;
                selCidade.appendChild(opt);
            });
            selCidade.disabled = false;
        }
        selEstado.addEventListener('change', function () { popularCidades(this.value, null); });
        popularCidades(selEstado.value, selCidade.value);
    }

    // ── Preview de foto de perfil (configurações do cliente) ────────────────
    var avatarWrapper = document.getElementById('avatarWrapper');
    var avatarOverlay = document.getElementById('avatarOverlay');
    var inputCliente  = document.getElementById('imagem_cliente');
    var previewFoto   = document.getElementById('previewNovaFoto');
    if (avatarWrapper && avatarOverlay && inputCliente) {
        avatarWrapper.addEventListener('mouseenter', function () { avatarOverlay.style.opacity = 1; });
        avatarWrapper.addEventListener('mouseleave', function () { avatarOverlay.style.opacity = 0; });
        inputCliente.addEventListener('change', function () {
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

    // ── Preview de foto de produto (admin — cadastro de produto) ────────────
    var fotoWrapper  = document.getElementById('fotoWrapper');
    var fotoOverlay  = document.getElementById('fotoOverlay');
    var inputProduto = document.getElementById('imagem_produto');
    var previewProd  = document.getElementById('previewNovaFoto');
    if (fotoWrapper && fotoOverlay && inputProduto) {
        fotoWrapper.addEventListener('mouseenter', function () { fotoOverlay.style.opacity = 1; });
        fotoWrapper.addEventListener('mouseleave', function () { fotoOverlay.style.opacity = 0; });
        inputProduto.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                previewProd.src = e.target.result;
                new bootstrap.Modal(document.getElementById('modalPreviewFoto')).show();
            };
            reader.readAsDataURL(file);
        });
        var modalProd = document.getElementById('modalPreviewFoto');
        if (modalProd) {
            modalProd.addEventListener('hide.bs.modal', function () {
                if (!inputProduto.files || !inputProduto.files[0]) return;
                var fotoArea = document.getElementById('fotoAtual');
                if (!fotoArea || !previewProd.src) return;
                if (fotoArea.tagName === 'IMG') {
                    fotoArea.src = previewProd.src;
                } else {
                    var img = document.createElement('img');
                    img.id             = 'fotoAtual';
                    img.style.cssText  = 'width:100%;height:100%;object-fit:cover;';
                    img.src            = previewProd.src;
                    fotoArea.replaceWith(img);
                }
            });
        }
    }

    // ── SweetAlert2: handler global para data-swal-confirm ─────────────────
    document.querySelectorAll('[data-swal-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var self    = this;
            var title   = self.dataset.swalTitle || 'Tem certeza?';
            var text    = self.dataset.swalText  || 'Esta ação não pode ser desfeita.';
            var btnText = self.dataset.swalBtn   || 'Sim, confirmar';
            var icon    = self.dataset.swalIcon  || 'warning';
            Swal.fire({
                title:              title,
                text:               text,
                icon:               icon,
                showCancelButton:   true,
                confirmButtonColor: '#C68A4C',
                cancelButtonColor:  '#6c757d',
                confirmButtonText:  btnText,
                cancelButtonText:   'Cancelar',
                reverseButtons:     true,
                customClass:        { popup: 'swal-admin-popup' }
            }).then(function (result) {
                if (result.isConfirmed) self.submit();
            });
        });
    });

    // ── Preview genérico via data-preview ───────────────────────────────────
    $('input[data-preview]').on('change', function () {
        var file = this.files[0];
        if (!file) return;
        var targetId = $(this).data('preview');
        var reader   = new FileReader();
        reader.onload = function (e) {
            $('#' + targetId).attr('src', e.target.result).removeClass('d-none');
        };
        reader.readAsDataURL(file);
    });

});

// ── Funções globais (chamadas via onclick no HTML) ───────────────────────────

function cancelarPreview() {
    var inputC = document.getElementById('imagem_cliente');
    var inputP = document.getElementById('imagem_produto');
    if (inputC) inputC.value = '';
    if (inputP) inputP.value = '';
    var preview = document.getElementById('previewNovaFoto');
    if (preview) preview.src = '';
}

function confirmarFinalizacao() {
    Swal.fire({
        title:              'Finalizar compra?',
        html:               'Seu pedido será confirmado e enviado para processamento.',
        icon:               'question',
        iconColor:          '#C68A4C',
        showCancelButton:   true,
        confirmButtonText:  '<i class="bi bi-bag-check me-1"></i> Confirmar pedido',
        cancelButtonText:   'Voltar',
        confirmButtonColor: '#C68A4C',
        cancelButtonColor:  '#6c757d',
        reverseButtons:     true,
        customClass: { popup: 'rounded-4', confirmButton: 'rounded-pill px-4', cancelButton: 'rounded-pill px-4' }
    }).then(function (result) {
        if (result.isConfirmed) document.getElementById('formFinalizar').submit();
    });
}

function confirmarRemocao(action, nomeProduto) {
    Swal.fire({
        title:              'Remover item?',
        html:               'O produto <strong>' + nomeProduto + '</strong> será removido do carrinho.',
        icon:               'warning',
        iconColor:          '#C68A4C',
        showCancelButton:   true,
        confirmButtonText:  '<i class="bi bi-trash3 me-1"></i> Sim, remover',
        cancelButtonText:   'Cancelar',
        confirmButtonColor: '#dc3545',
        cancelButtonColor:  '#6c757d',
        reverseButtons:     true,
        customClass: { popup: 'rounded-4', confirmButton: 'rounded-pill px-4', cancelButton: 'rounded-pill px-4' }
    }).then(function (result) {
        if (result.isConfirmed) {
            document.getElementById('formRemoverItem').action = action;
            document.getElementById('formRemoverItem').submit();
        }
    });
}
