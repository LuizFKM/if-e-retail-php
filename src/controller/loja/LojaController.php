<?php

namespace controller\loja;

use dao\ProdutoDAO;
use Exception;

class LojaController
{
    public function home()
    {
        try {
            $produtos = ProdutoDAO::listar();
        } catch (Exception $ex) {
            $_SESSION['flash'] = ['tipo' => 'danger', 'msg' => 'Falha ao carregar produtos: ' . $ex->getMessage()];
            $produtos = [];
        }
        require __DIR__ . "/../../view/loja/home.php";
    }

    public function verProduto(array $params)
    {
        try {
            $produto = ProdutoDAO::buscarPorId($params['id']);
            if (empty($produto))
                throw new Exception("Produto não encontrado.");
        } catch (Exception $ex) {
            $_SESSION['flash'] = ['tipo' => 'danger', 'msg' => $ex->getMessage()];
            header('Location: ' . BASE_URL . '/loja');
            exit;
        }
        require __DIR__ . "/../../view/loja/produto.php";
    }
}
