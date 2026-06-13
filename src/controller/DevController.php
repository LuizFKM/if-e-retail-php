<?php

namespace App\controller;

use App\dao\ClienteDAO;
use Exception;

// Dev: controller de atalhos para desenvolvimento — REMOVER antes de ir para produção
class DevController
{
    // Acesse /dev/auto-login para entrar automaticamente como o primeiro cliente do banco
    public function autoLogin()
    {
        try {
            $clientes = ClienteDAO::listar();

            if (empty($clientes)) {
                echo "Nenhum cliente cadastrado. <a href='" . BASE_URL . "/clientes/novo'>Cadastrar cliente</a>";
                return;
            }

            $cliente = $clientes[0];
            $_SESSION['cliente_id'] = $cliente->getID();

            header('Location: ' . BASE_URL . '/perfil');
            exit;

        } catch (Exception $ex) {
            echo "Erro ao fazer auto-login: " . htmlspecialchars($ex->getMessage());
        }
    }
}
