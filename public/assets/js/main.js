// Preview de imagem de perfil — usado na aba Configurações
// O script inline na view também usa este padrão; aqui fica como fallback global
$(document).ready(function () {
    // Preview via FileReader para qualquer input[data-preview]
    $('input[data-preview]').on('change', function () {
        var targetId = $(this).data('preview');
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + targetId).attr('src', e.target.result).removeClass('d-none');
        };
        reader.readAsDataURL(file);
    });

    // Máscaras de input (mesmo padrão do projeto-exemplo: jQuery Mask por ID)
    $("#cpf").mask('000.000.000-00');
    $("#cep").mask('00000-000');

    // Telefone aceita fixo (8 dígitos) e celular (9 dígitos)
    var telefoneMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    };
    var telefoneOptions = {
        onKeyPress: function (val, e, field, options) {
            field.mask(telefoneMaskBehavior.apply({}, arguments), options);
        }
    };
    $("#telefone").mask(telefoneMaskBehavior, telefoneOptions);
});
