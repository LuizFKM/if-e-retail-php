<?php
namespace App\controller\admin;

use App\dao\PedidoDAO;
use Exception;

class PedidoController{

    public function listar(){
        try{
            $pedidos = PedidoDAO::listar();
            ob_start();
            require __DIR__ . "/../../view/admin/lista-pedidos.php";
            $conteudo = ob_get_clean();
        }catch(Exception $ex){
            echo "erro ao listar pedidos" . $ex->getMessage();
        }
        require __DIR__ . "/../../view/layouts/painel-admin-layout.php";
    }

    public function buscar(array $params){
        try{
            $id = $params['id'];
            $pedido = PedidoDAO::buscarPorId($id);
            if(empty($pedido)){
                echo "pedido nao encontrado";
            }
        }catch(Exception $ex){
            echo "erro ao buscar pedido" . $ex->getMessage();
        } finally {
            require __DIR__ . "/../../view/lista-pedidos.php";
        }
    }

    public function remover(array $params){
        try{
            $id = $params['id'];
            $pedido = PedidoDAO::buscarPorId($id);
            if(empty($pedido)){
                echo "pedido nao encontrado";
            }
            PedidoDAO::deletar($pedido);
        }catch(Exception $ex){
            echo "erro ao remover pedido" . $ex->getMessage();
        } finally {
            header('Location: ' . BASE_URL . '/pedidos');
            exit;
        }

    }

}

