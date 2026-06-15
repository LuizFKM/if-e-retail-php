<?php

namespace App\dao;

use Exception;
// Correção: namespaces estavam sem o prefixo App\ — necessário para o autoload PSR-4
use App\model\Cliente;
use App\utils\Conexao;

class ClienteDAO extends GenericDAO
{
    protected static $modelClass = Cliente::class;

    // Forma 1: findBy — busca exata por campo
    public static function buscarPorCpf($cpf)
    {
        try {
            $em = Conexao::getEntityManager();
            $repository = $em->getRepository(Cliente::class);
            return $repository->findBy(['cpf' => $cpf]);
        } catch (Exception $ex) {
            throw new Exception("Falha ao buscar cliente por CPF. " . $ex->getMessage());
        }
    }

    // Novo: busca por login (email) — usado no fluxo de autenticação da sessão
    public static function buscarPorLogin($login)
    {
        try {
            $em = Conexao::getEntityManager();
            $repository = $em->getRepository(Cliente::class);
            $resultado = $repository->findBy(['login' => $login]);
            return $resultado ? $resultado[0] : null;
        } catch (Exception $ex) {
            throw new Exception("Falha ao buscar cliente por login. " . $ex->getMessage());
        }
    }

    // Forma 2: QueryBuilder — busca parcial com LIKE
    public static function buscarPorNome($name)
    {
        try {
            $em = Conexao::getEntityManager();
            $repository = $em->getRepository(Cliente::class);
            $queryBuilder = $repository->createQueryBuilder('c');
            $queryBuilder
                ->where('c.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
            return $queryBuilder->getQuery()->getResult();
        } catch (Exception $ex) {
            throw new Exception("Falha ao buscar cliente por nome. " . $ex->getMessage());
        }
    }

    // Forma 3: DQL — query em linguagem Doctrine
    public static function buscarPorNomeDQL($name)
    {
        try {
            $em = Conexao::getEntityManager();
            // Correção: DQL usa nome completo da classe (FQN) no Doctrine 3.x
            $query = $em->createQuery("SELECT c FROM App\\model\\Cliente c WHERE c.name LIKE :name");
            $query->setParameter('name', '%' . $name . '%');
            return $query->getResult();
        } catch (Exception $ex) {
            throw new Exception("Falha ao buscar cliente por nome (DQL). " . $ex->getMessage());
        }
    }
}
