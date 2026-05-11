<?php /** @var model\Produto $produto */ ?>
<!doctype html>
<html lang="pt-br">
<head>

    <?php require_once "templates/template-head.php" ?>
    <title>Cadastro de produtos</title>
</head>

<body>
<h1> Cadastro de produtos</h1>
<div class="container">
    <h3>Preencha o formulario</h3>

    <div class="form">
        <form action="<?= BASE_URL . '/produtos/cadastrar' ?>" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($produto->getId() ?? '') ?>">

            <label for="descricao">Descrição do produto:</label>
            <input id="descricao" name="descricao" type="text" value="<?= htmlspecialchars($produto->getDescricao() ?? '') ?>" required/>
            <label for="precoUnitario">Preço Unitário:</label>
            <input id="precoUnitario" name="precoUnitario" type="number" value="<?= htmlspecialchars($produto->getPrecoUnitario() ?? '')?>" required/>
            <label for="quantidadeEmEstoque">Quantidade em estoque:</label>
            <input id="quantidadeEmEstoque" name="quantidadeEmEstoque" type="number" value="<?= htmlspecialchars($produto->getQuantidade() ?? '')?>" required/>
            <button type="submit">Cadastrar</button>
        </form>

    </div>
</div>

</body>
</html>
