<?php

namespace App\controller\admin;

use App\dao\PedidoDAO;
use App\dao\ProdutoDAO;
use Exception;

class AdminController
{
    public function index()
    {
        try {
            $produtos = ProdutoDAO::listar();
            $pedidos  = PedidoDAO::listar();
        } catch (Exception $ex) {
            $produtos = [];
            $pedidos  = [];
        }

        $totalProdutos     = count($produtos);
        $totalPedidos      = count($pedidos);
        $pedidosPendentes  = count(array_filter($pedidos, fn($p) => !$p->getStatus()));
        $pedidosConcluidos = count(array_filter($pedidos, fn($p) => $p->getStatus()));
        $pedidosRecentes   = array_slice(array_reverse($pedidos), 0, 5);

        ob_start();
        require __DIR__ . '/../../view/admin/dashboard.php';
        $conteudo = ob_get_clean();
        require __DIR__ . '/../../view/layouts/painel-admin-layout.php';
    }
}
