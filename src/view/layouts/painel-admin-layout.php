<!doctype html>
<html lang="pt-BR">
<head>
    <?php require_once __DIR__ . "/../templates/template-head.php" ?>
    <title>Painel Administrativo</title>
</head>
<body>
<?php require_once __DIR__ . "/../templates/template-aside-left-admin.php" ?>
<?php echo $conteudo ?? ''; ?>
<?php require_once __DIR__ . "/../templates/template-rodape.php" ?>
</body>
</html>
