<?php

namespace dao;

use Exception;
use model\UserModel;
use utils\Conexao;

class UserDAO
{
    public static function buscarPorLogin(string $login): ?UserModel
    {
        try {
            $em = Conexao::getEntityManager();
            $query = $em->createQuery("SELECT u FROM model\UserModel u WHERE u.login = :login");
            $query->setParameter('login', $login);
            return $query->getOneOrNullResult();
        } catch (Exception $ex) {
            throw new Exception("Falha ao buscar usuário por login. " . $ex->getMessage());
        }
    }
}
