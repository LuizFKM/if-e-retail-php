<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once "templates/template-head.php"?>
    <title>IF E-Retail - Início</title>
</head>
<body>
    <?php require_once "templates/template-menu-cliente.php" ?>
    <div class="container">
        <p>IF E-Retail</p>
        <nav>
            <ul>
                <li><a href="<?= BASE_URL . '/clientes' ?>">Clientes</a></li>
                <li><a href="<?= BASE_URL . '/produtos' ?>">Produtos</a></li>
                <li><a href="<?= BASE_URL . '/pedidos' ?>">Pedidos</a></li>
                <li><a href="<?= BASE_URL . '/admin' ?>">Funcionários</a></li>
            </ul>
        </nav>
    </div>

    <?php require_once "templates/template-rodape.php" ?>

</body>
</html>
