<?php

namespace App\dao;

use Exception;
use App\model\GenericModel;
use App\model\Pedido;
use App\utils\Conexao;

class PedidoDAO extends GenericDAO
{
    protected static $modelClass = Pedido::class;

    public static function deletar(GenericModel $model)
    {
        $em = null;
        try {
            $em   = Conexao::getEntityManager();
            $em->beginTransaction();
            $conn = $em->getConnection();
            $id   = $model->getID();

            // Remove itens do carrinho/pedido vinculados a este pedido
            $conn->executeStatement('DELETE FROM tb_item_pedido WHERE pedido_id = ?', [$id]);

            // Remove a relação ManyToMany pedido↔produto
            $conn->executeStatement('DELETE FROM tb_produto_pedido WHERE pedido_id = ?', [$id]);

            $em->remove($model);
            $em->flush();
            $em->commit();
        } catch (Exception $ex) {
            if ($em !== null) {
                $em->rollback();
            }
            throw new Exception("Falha ao deletar os dados." . $ex->getMessage());
        }
    }

    public static function buscarPorStatus($status){
        try{
            $em = Conexao::getEntityManager();
            // Correção: a query filtrava em Produto ao invés de Pedido
            $query = $em->createQuery("SELECT p FROM model\Pedido p WHERE p.status = :status");
            $query->setParameter("status", $status);
            return $query->getResult();
        }catch(Exception $e){
            throw new Exception("Falha ao buscar pedido por status. " .  $e->getMessage());
        }
    }
}
