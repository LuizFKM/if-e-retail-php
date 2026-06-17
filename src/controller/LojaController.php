<?php

namespace App\controller;

use App\dao\ClienteDAO;
use App\dao\ProdutoDAO;
use Exception;

class LojaController
{
    /**
     * Renderiza a Página Inicial (Home) com destaques
     */
    public function index()
    {
        try {
            $produtos = ProdutoDAO::listar();
        } catch (Exception $ex) {
            $produtos = [];
        }

        // Busca os favoritos usando o método auxiliar privado abaixo
        $favoritoIds = $this->carregarFavoritosLogado();

        // Alimenta a view específica da Home
        require __DIR__ . '/../view/site/home.php';
    }

    /**
     * Renderiza a página de listagem completa de produtos
     */
    public function produtos()
    {
        try {
            // Busca todos os produtos para listar na vitrine completa
            $produtos = ProdutoDAO::listar();
        } catch (Exception $ex) {
            $produtos = [];
        }

        $favoritoIds = $this->carregarFavoritosLogado();

        // Alimenta a view específica de Produtos
        require __DIR__ . '/../view/site/produtos.php';
    }

    private function carregarFavoritosLogado()
    {
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
                // Erro silencioso para não quebrar a navegação se a sessão falhar
            }
        }
        return $favoritoIds;
    }
}