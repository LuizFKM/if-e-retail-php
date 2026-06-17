<?php

namespace App\dao;

use Exception;
use App\model\GenericModel;
use App\model\Produto;
use App\utils\Conexao;

class ProdutoDAO extends GenericDAO
{
    protected static $modelClass = Produto::class;

    public static function deletar(GenericModel $model)
    {
        $em = null;
        try {
            $em   = Conexao::getEntityManager();
            $em->beginTransaction();
            $conn = $em->getConnection();
            $id   = $model->getID();

            // Remove o produto dos favoritos de todos os clientes
            $conn->executeStatement('DELETE FROM tb_produtos_favoritos WHERE produto_id = ?', [$id]);

            // Anula a referência nos itens de pedido/carrinho (preserva histórico)
            $conn->executeStatement('UPDATE tb_item_pedido SET produto_id = NULL WHERE produto_id = ?', [$id]);

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

    public static function buscarPorDescricao($descricao)
    {
        try {
            $em = Conexao::getEntityManager();
            $repository = $em->getRepository(Produto::class);
            $queryBuilder = $repository->createQueryBuilder('p');
            $queryBuilder
                ->where('p.descricao LIKE :descricao')
                ->setParameter('descricao', '%' . $descricao . '%');
            return $queryBuilder->getQuery()->getResult();
        } catch (Exception $ex) {
            throw new Exception("Falha ao buscar produto por descrição. " . $ex->getMessage());
        }
    }

    public static function buscarSemEstoque()
    {
        try {
            $em = Conexao::getEntityManager();
            $repository = $em->getRepository(Produto::class);
            $queryBuilder = $repository->createQueryBuilder('p');
            $queryBuilder->where('p.quantidade = 0');
            return $queryBuilder->getQuery()->getResult();
        } catch (Exception $ex) {
            throw new Exception("Falha ao buscar produtos sem estoque. " . $ex->getMessage());
        }
    }

    public static function buscarPorStatus($status)
    {
        try {
            $em = Conexao::getEntityManager();
            $repository = $em->getRepository(Produto::class);
            return $repository->findBy(['status' => $status]);
        } catch (Exception $ex) {
            throw new Exception("Falha ao buscar produto por status. " . $ex->getMessage());
        }
    }
}
