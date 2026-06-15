<?php

namespace App\model;

class UserFactory
{
    public static function create(TipoUsuario $tipo, array $d): UserModel {
        $user = match($tipo) {
            TipoUsuario::CLIENTE => new Cliente($d['nome'], $d['cpf'], $d['idade'], $d['senha'], $tipo->value),
            TipoUsuario::ADMIN   => new Admin($d['nome'], $d['cpf'], $d['idade'], $d['senha'], $tipo->value),
        };

        if ($user instanceof Cliente) {
            // Correção: Carrinho::__construct só aceita ($status). O usuário não é passado
            // ao carrinho — é o Cliente que referencia o carrinho via setCarrinho().
            $carrinho = new Carrinho('ABERTO');
            $user->setCarrinho($carrinho);
        }

        return $user;
    }
}
