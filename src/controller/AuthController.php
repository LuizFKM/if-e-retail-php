<?php

namespace controller;

use dao\UserDAO;
use Exception;

class AuthController
{
    public function form()
    {
        require __DIR__ . "/../view/auth/login.php";
    }

    public function entrar()
    {
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

        try {
            $usuario = UserDAO::buscarPorLogin($login);

            if (empty($usuario) || $usuario->getSenha() !== $senha)
                throw new Exception("Login ou senha inválidos.");

            $_SESSION['usuario_id']   = $usuario->getID();
            $_SESSION['usuario_nome'] = $usuario->getName();
            $_SESSION['usuario_tipo'] = $usuario->getTipo();

            if ($usuario->getTipo() === 'admin') {
                header('Location: ' . BASE_URL . '/admin');
            } else {
                header('Location: ' . BASE_URL . '/loja');
            }
        } catch (Exception $ex) {
            $_SESSION['flash'] = ['tipo' => 'danger', 'msg' => $ex->getMessage()];
            header('Location: ' . BASE_URL . '/login');
        } finally {
            exit;
        }
    }

    public function sair()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
