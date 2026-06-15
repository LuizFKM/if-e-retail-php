<?php

namespace App\utils;

use App\dao\ClienteDAO;
use App\model\Cliente;

// Guard de sessão reutilizável: retorna o Cliente logado ou redireciona para /login
class Sessao
{
    public static function clienteLogado(): Cliente
    {
        if (empty($_SESSION['cliente_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $cliente = ClienteDAO::buscarPorId((int) $_SESSION['cliente_id']);

        if (!$cliente) {
            // Sessão aponta para um cliente que não existe mais (ex.: conta excluída)
            session_destroy();
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        return $cliente;
    }
}
