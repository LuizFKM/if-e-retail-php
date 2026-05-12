<?php

namespace controller\admin;

use dao\AdminDAO;
use dao\ClienteDAO;
use dao\PedidoDAO;
use dao\ProdutoDAO;
use Exception;

class HomeController
{
    public function index()
    {
        require __DIR__ . '/../../view/admin/home.php';
    }
}
