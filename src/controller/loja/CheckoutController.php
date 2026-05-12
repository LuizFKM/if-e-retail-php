<?php

namespace controller\loja;

use dao\ProdutoDAO;
use Exception;

class CheckoutController
{
    public function ver()
    {
        if (empty($_SESSION['carrinho'])) {
            header('Location: ' . BASE_URL . '/loja/carrinho');
            exit;
        }

        $itens    = [];
        $subtotal = 0;

        foreach ($_SESSION['carrinho'] as $produtoId => $quantidade) {
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

        require __DIR__ . "/../../view/loja/checkout.php";
    }

    public function finalizar()
    {
        // Ponto de extensão: criar Pedido no banco
        $_SESSION['carrinho'] = [];
        $_SESSION['flash']    = ['tipo' => 'success', 'msg' => 'Pedido realizado com sucesso!'];
        header('Location: ' . BASE_URL . '/loja');
        exit;
    }
}
