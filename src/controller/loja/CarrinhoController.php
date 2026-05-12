<?php

namespace controller\loja;

use dao\ProdutoDAO;
use Exception;

class CarrinhoController
{
    public function ver()
    {
        $itens    = [];
        $subtotal = 0;

        foreach ($_SESSION['carrinho'] ?? [] as $produtoId => $quantidade) {
            try {
                $produto = ProdutoDAO::buscarPorId($produtoId);
                if ($produto) {
                    $itens[]   = ['produto' => $produto, 'quantidade' => $quantidade];
                    $subtotal += $produto->getPrecoUnitario() * $quantidade;
                }
            } catch (Exception $ex) {
                continue;
            }
        }

        require __DIR__ . "/../../view/loja/carrinho.php";
    }

    public function adicionar(array $params)
    {
        $id         = $params['id'];
        $quantidade = max(1, (int) filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT));

        if (!isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id] = $quantidade;
        } else {
            $_SESSION['carrinho'][$id] += $quantidade;
        }

        $_SESSION['flash'] = ['tipo' => 'success', 'msg' => 'Produto adicionado ao carrinho!'];
        header('Location: ' . BASE_URL . '/loja/carrinho');
        exit;
    }

    public function remover(array $params)
    {
        unset($_SESSION['carrinho'][$params['id']]);
        $_SESSION['flash'] = ['tipo' => 'success', 'msg' => 'Produto removido do carrinho.'];
        header('Location: ' . BASE_URL . '/loja/carrinho');
        exit;
    }
}
