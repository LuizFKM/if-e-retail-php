<?php

namespace App\dao;

use Exception;
use App\model\ItemPedido;
use App\model\Pedido;
use App\utils\Conexao;

class ItemPedidoDAO extends GenericDAO
{
    protected static $modelClass = ItemPedido::class;

    // Novo: retorna todos os itens de um pedido — usado na aba Compras do perfil
    public static function buscarPorPedido(Pedido $pedido): array
    {
        try {
            $em         = Conexao::getEntityManager();
            $repository = $em->getRepository(ItemPedido::class);
            return $repository->findBy(['pedido' => $pedido]);
        } catch (Exception $ex) {
            throw new Exception("Falha ao buscar itens do pedido. " . $ex->getMessage());
        }
    }
}
