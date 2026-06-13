<?php

namespace App\controller;

use App\dao\ClienteDAO;
use App\dao\ProdutoDAO;
use Exception;

// Novo: controller da vitrine de produtos para o cliente
class LojaController
{
    public function produtos()
    {
        try {
            $produtos = ProdutoDAO::listar();
        } catch (Exception $ex) {
            $produtos = [];
        }

        // Monta conjunto de IDs de favoritos do cliente logado (se houver sessão ativa)
        $favoritoIds = [];
        if (!empty($_SESSION['cliente_id'])) {
            try {
                $cliente = ClienteDAO::buscarPorId((int) $_SESSION['cliente_id']);
                if ($cliente) {
                    foreach ($cliente->getListaFavoritos() as $p) {
                        $favoritoIds[] = $p->getID();
                    }
                }
            } catch (Exception $ex) {
                // Sessão pode estar desatualizada — não quebra a vitrine
            }
        }

        require __DIR__ . '/../view/site/produtos.php';
    }
}
