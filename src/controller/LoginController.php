<?php

namespace App\controller;

use App\dao\ClienteDAO;
use Exception;

class LoginController
{
    public function index()
    {
        require __DIR__ . '/../view/site/login.php';
    }

    // Novo: autentica o cliente por email (login) e senha, salva session e redireciona
    public function autenticar()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

        try {
            $cliente = ClienteDAO::buscarPorLogin($email);

            if (!$cliente) {
                throw new Exception("E-mail não encontrado.");
            }

            // Comparação direta pois o cadastro atual grava senha em texto puro.
            // Recomendação futura: migrar para password_hash() no cadastro e
            // password_verify() aqui, sem alterar clientes já existentes.
            if ($cliente->getSenha() !== $senha) {
                throw new Exception("Senha incorreta.");
            }

            $_SESSION['cliente_id'] = $cliente->getID();
            header('Location: ' . BASE_URL . '/perfil');
            exit;

        } catch (Exception $ex) {
            $_SESSION['login_erro'] = $ex->getMessage();
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    // Novo: encerra a sessão e redireciona para a home
    public function sair()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/');
        exit;
    }
}
