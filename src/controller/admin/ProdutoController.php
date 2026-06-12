<?php

namespace App\controller\admin;

use App\dao\ProdutoDAO;
use Exception;
use App\model\Produto;

class ProdutoController{

    public function listar(){
        try{
            $produtos = ProdutoDAO::listar();
            ob_start();
            require __DIR__ . "/../../view/admin/lista-produtos.php";
            $conteudo = ob_get_clean();
        }catch(Exception $ex){
            echo "Falha ao listar produtos " . $ex->getMessage();
        }
            require __DIR__ . "/../../view/layouts/painel-admin-layout.php";
    }

    public function novo(){
        $produto = new Produto();
        require __DIR__ . "/../../view/cadastro-produtos.php";
    }

    public function cadastrar(){
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
        $precoUnitario = filter_input(INPUT_POST, 'precoUnitario', FILTER_SANITIZE_NUMBER_FLOAT);
        $quantidade = filter_input(INPUT_POST, 'quantidadeEmEstoque', FILTER_SANITIZE_NUMBER_INT);



        $produto = $id ? ProdutoDAO::buscarPorId($id) : new Produto();
        try{
            if(empty($produto))
                throw new Exception("Produto nao encontrado");
            $produto->setDescricao($descricao);
            $produto->setPrecoUnitario($precoUnitario);
            $produto->setQuantidade($quantidade);
            ProdutoDAO::salvar($produto);
            header('Location:' . BASE_URL . '/produtos/novo');
        }catch(Exception $ex){
            echo 'Falha ao cadastrar o produto.' . $ex->getMessage();
            header('Location:' . BASE_URL . '/produtos/novo');
        } finally {
            exit;
        }
    }

    public function buscar(array $params){
        try{
            $id = $params['id'];
            $produto = ProdutoDAO::buscarPorId($id);
            if(empty($produto)){
                echo "Produto nao foi encontrado!";
            }
        }catch (Exception $ex){
            echo "Falha ao buscar produto" . $ex->getMessage();
        } finally {
            require __DIR__ . "/../view/lista-produtos.php";
        }
    }

    public function remover(array $params){
        try{
            $id = $params['id'];
            $produto = ProdutoDAO::buscarPorId($id);
            if(empty($produto)){
                echo "Produto nao foi encontrado!";
            }
            ProdutoDAO::deletar($produto);
            header('Location: ' . BASE_URL . '/painel-administrativo/produtos');
        }catch (Exception $ex){
            echo "Falha ao remover produto" . $ex->getMessage();
        }
    }
}