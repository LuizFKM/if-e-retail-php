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
});
