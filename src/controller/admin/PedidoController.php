<?php
namespace App\controller\admin;

use App\dao\ItemPedidoDAO;
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
                throw new Exception("Pedido não encontrado.");
            }
            $itensPedido = ItemPedidoDAO::buscarPorPedido($pedido);
            ob_start();
            require __DIR__ . "/../../view/admin/visualizar-pedido.php";
            $conteudo = ob_get_clean();
        }catch(Exception $ex){
            echo "Erro ao buscar pedido: " . $ex->getMessage();
        }
        require __DIR__ . "/../../view/layouts/painel-admin-layout.php";
    }

    public function remover(array $params)
    {
        try {
            $id     = $params['id'];
            $pedido = PedidoDAO::buscarPorId($id);
            if (empty($pedido)) {
                throw new Exception("Pedido não encontrado.");
            }
            PedidoDAO::deletar($pedido);
            header('Location: ' . BASE_URL . '/painel-administrativo/pedidos');
        } catch (Exception $ex) {
            header('Location: ' . BASE_URL . '/painel-administrativo/pedidos');
        }
        exit;
    }

    public function atualizarStatus(array $params)
    {
        try {
            $id     = $params['id'];
            $pedido = PedidoDAO::buscarPorId($id);
            if (empty($pedido)) {
                throw new Exception("Pedido não encontrado.");
            }
            $pedido->setStatus(!$pedido->getStatus());
            PedidoDAO::salvar($pedido);
            header('Location: ' . BASE_URL . '/painel-administrativo/pedidos/' . $id);
        } catch (Exception $ex) {
            header('Location: ' . BASE_URL . '/painel-administrativo/pedidos');
        }
        exit;
    }

}

