<?php

namespace App\dao;

use Exception;
use App\model\Pedido;
use App\utils\Conexao;

class PedidoDAO extends GenericDAO
{
    protected static $modelClass = Pedido::class;

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
