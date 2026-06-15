<?php

namespace App\controller;

use App\dao\ClienteDAO;
use App\dao\ProdutoDAO;
use App\utils\Sessao;
use Exception;

// Novo: gerencia favoritos do cliente (toggle via POST)
class FavoritoController
{
    // Toggle: adiciona se não existe, remove se já está nos favoritos
    public function toggle(array $params)
    {
        $cliente    = Sessao::clienteLogado();
        $produtoId  = (int) ($params['produtoId'] ?? 0);

        try {
            $produto = ProdutoDAO::buscarPorId($produtoId);

            if (!$produto) {
                header('Location: ' . BASE_URL . '/produtos');
                exit;
            }

            if ($cliente->temFavorito($produto)) {
                $cliente->removerFavorito($produto);
            } else {
                $cliente->adicionarFavorito($produto);
            }

            ClienteDAO::salvar($cliente);

        } catch (Exception $ex) {
            // Log silencioso — não interrompe o fluxo do usuário
        }

        // Redireciona para a aba Favoritos do perfil conforme checklist de aceite
        header('Location: ' . BASE_URL . '/perfil/favoritos');
        exit;
    }
}
