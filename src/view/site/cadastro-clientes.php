<?php /** @var App\model\Cliente $cliente */ ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Cadastro de Cliente</title>
</head>
<?php require_once __DIR__ . "/../templates/template-menu-cliente.php" ?>
<body class="view-cadastro-cliente">

<div class="container-fluid min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">

    <div class="w-100 bg-white bg-opacity-75 p-4 p-md-5 rounded-3 shadow" style="max-width: 500px;">

        <div class="text-center mb-4">
            <h3 class="fw-bold mb-1" style="color:var(--coffee);">Criar conta</h3>
            <p class="text-muted small">Preencha os dados abaixo para se cadastrar</p>
        </div>

        <?php if (!empty($erro)): ?>
            <div class="alert border-0 d-flex align-items-center gap-2 mb-4"
                 style="background:#fff0f0;border-left:4px solid #dc3545 !important;border-radius:10px;">
                <i class="bi bi-exclamation-circle-fill fs-5 text-danger"></i>
                <span><?= htmlspecialchars($erro) ?></span>
            </div>
        <?php endif; ?>

        <form id="formCadastro" action="<?= BASE_URL . '/clientes/cadastrar' ?>" method="POST" novalidate>
            <input type="hidden" name="id" value="<?= htmlspecialchars($cliente->getID() ?? '') ?>">

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold small" style="color:var(--coffee);">
                    <i class="bi bi-person me-1" style="color:var(--amber);"></i>Nome Completo
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream);border-color:var(--line);color:var(--amber);">
                        <i class="bi bi-person"></i>
                    </span>
                    <input id="name" name="name" type="text" class="form-control"
                           placeholder="Seu nome completo"
                           style="border-color:var(--line);"
                           value="<?= htmlspecialchars($cliente->getName() ?? '') ?>" required/>
                </div>
            </div>

            <div class="mb-3">
                <label for="login" class="form-label fw-semibold small" style="color:var(--coffee);">
                    <i class="bi bi-envelope me-1" style="color:var(--amber);"></i>E-mail
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream);border-color:var(--line);color:var(--amber);">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input id="login" name="login" type="email" class="form-control"
                           placeholder="seu@email.com"
                           style="border-color:var(--line);"
                           value="<?= htmlspecialchars($cliente->getLogin() ?? '') ?>" required/>
                </div>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label fw-semibold small" style="color:var(--coffee);">
                    <i class="bi bi-credit-card me-1" style="color:var(--amber);"></i>CPF
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream);border-color:var(--line);color:var(--amber);">
                        <i class="bi bi-credit-card"></i>
                    </span>
                    <input id="cpf" name="cpf" type="text" class="form-control"
                           placeholder="000.000.000-00"
                           style="border-color:var(--line);"
                           value="<?= htmlspecialchars($cliente->getCpf() ?? '') ?>" required/>
                </div>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label fw-semibold small" style="color:var(--coffee);">
                    <i class="bi bi-lock me-1" style="color:var(--amber);"></i>Senha
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream);border-color:var(--line);color:var(--amber);">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input id="senha" name="senha" type="password" class="form-control"
                           placeholder="Mínimo 6 caracteres"
                           style="border-color:var(--line);" required/>
                </div>
            </div>

            <div class="mb-4">
                <label for="dataNascimento" class="form-label fw-semibold small" style="color:var(--coffee);">
                    <i class="bi bi-calendar3 me-1" style="color:var(--amber);"></i>Data de Nascimento
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream);border-color:var(--line);color:var(--amber);">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <input id="dataNascimento" name="dataNascimento" type="date" class="form-control"
                           min="1900-01-01"
                           max="<?= date('Y-m-d', strtotime('-1 day')) ?>"
                           style="border-color:var(--line);"
                           value="<?= htmlspecialchars($cliente->getDataNascimento()?->format('Y-m-d') ?? '') ?>" required/>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-amber btn-lg rounded-pill">
                    <i class="bi bi-person-check me-2"></i>Criar conta
                </button>
            </div>

            <div class="text-center mt-4 pt-3" style="border-top:1px solid var(--line);">
                <span class="text-muted small">Já tem uma conta?</span>
                <a href="<?= BASE_URL . '/login' ?>"
                   class="btn btn-outline-secondary btn-sm rounded-pill px-4 ms-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Faça login
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>

<script>
$(document).ready(function () {
    // Método customizado: CPF precisa ter 11 dígitos numéricos (ignora máscara)
    $.validator.addMethod('cpfCompleto', function (value) {
        return value.replace(/\D/g, '').length === 11;
    }, 'Preencha o CPF completo (11 dígitos).');

    $('#formCadastro').validate({
        rules: {
            name:           { required: true, minlength: 3 },
            login:          { required: true, email: true },
            cpf:            { required: true, cpfCompleto: true },
            senha:          { required: true, minlength: 6 },
            dataNascimento: { required: true, min: '1900-01-01', max: new Date().toISOString().split('T')[0] }
        },
        messages: {
            name: {
                required:  'Informe seu nome completo.',
                minlength: 'O nome deve ter pelo menos 3 caracteres.'
            },
            login: {
                required: 'Informe seu e-mail.',
                email:    'Digite um e-mail válido (ex.: nome@email.com).'
            },
            cpf: {
                required: 'Informe seu CPF.'
            },
            senha: {
                required:  'Crie uma senha.',
                minlength: 'A senha deve ter pelo menos 6 caracteres.'
            },
            dataNascimento: {
                required: 'Informe sua data de nascimento.',
                min: 'Data inválida (mínimo: 01/01/1900).',
                max: 'A data de nascimento não pode ser hoje ou no futuro.'
            }
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function (el) { $(el).addClass('is-invalid'); },
        unhighlight: function (el) { $(el).removeClass('is-invalid'); },
        errorPlacement: function (error, element) { error.insertAfter(element); },
        submitHandler: function (form) { form.submit(); }
    });
});
</script>
