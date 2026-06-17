<?php

namespace App\controller\admin;

use App\dao\ProdutoDAO;
use App\model\Produto;
use App\utils\FileUpload;
use Exception;

class ProdutoController
{
    public function listar()
    {
        try {
            $produtos = ProdutoDAO::listar();
            ob_start();
            require __DIR__ . "/../../view/admin/lista-produtos.php";
            $conteudo = ob_get_clean();
        } catch (Exception $ex) {
            $conteudo = "<p>Falha ao listar produtos: " . htmlspecialchars($ex->getMessage()) . "</p>";
        }
        require __DIR__ . "/../../view/layouts/painel-admin-layout.php";
    }

    public function novo()
    {
        $produto = new Produto();
        ob_start();
        require __DIR__ . "/../../view/admin/cadastro-produtos.php";
        $conteudo = ob_get_clean();
        require __DIR__ . "/../../view/layouts/painel-admin-layout.php";
    }

    public function editar(array $params)
    {
        try {
            $produto = ProdutoDAO::buscarPorId((int) $params['id']);
            if (empty($produto)) {
                throw new Exception("Produto não encontrado.");
            }
        } catch (Exception $ex) {
            header('Location: ' . BASE_URL . '/painel-administrativo/produtos?erro=' . urlencode($ex->getMessage()));
            exit;
        }
        ob_start();
        require __DIR__ . "/../../view/admin/cadastro-produtos.php";
        $conteudo = ob_get_clean();
        require __DIR__ . "/../../view/layouts/painel-admin-layout.php";
    }

    public function cadastrar()
    {
        $id            = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $descricao     = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
        $precoRaw      = filter_input(INPUT_POST, 'precoUnitario', FILTER_DEFAULT);
        $precoUnitario = (float) str_replace(['.', ','], ['', '.'], $precoRaw);
        $quantidade    = filter_input(INPUT_POST, 'quantidadeEmEstoque', FILTER_SANITIZE_NUMBER_INT);

        try {
            $produto = $id ? ProdutoDAO::buscarPorId((int) $id) : new Produto();

            if (empty($produto)) {
                throw new Exception("Produto não encontrado.");
            }

            $produto->setDescricao($descricao);
            $produto->setPrecoUnitario($precoUnitario);
            $produto->setQuantidade($quantidade);

            if (!empty($_FILES['imagem_produto']['tmp_name']) && $_FILES['imagem_produto']['error'] === UPLOAD_ERR_OK) {
                $urlAntiga    = $produto->getUrlFotoProduto();
                $uploadResult = FileUpload::uploadImagem(
                    'produtos',
                    $_FILES['imagem_produto']['tmp_name'],
                    uniqid('produto_')
                );
                $produto->setUrlFotoProduto($uploadResult['secure_url']);

                if ($urlAntiga) {
                    FileUpload::deletarImagem('produtos', $urlAntiga);
                }
            }

            ProdutoDAO::salvar($produto);
            header('Location: ' . BASE_URL . '/painel-administrativo/produtos');
        } catch (Exception $ex) {
            // Redireciona com mensagem de erro na query string
            header('Location: ' . BASE_URL . '/painel-administrativo/produtos/novo?erro=' . urlencode($ex->getMessage()));
        }
        exit;
    }

    public function remover(array $params)
    {
        try {
            $id      = (int) $params['id'];
            $produto = ProdutoDAO::buscarPorId($id);

            if (empty($produto)) {
                throw new Exception("Produto não encontrado.");
            }

            $urlFoto = $produto->getUrlFotoProduto();
            ProdutoDAO::deletar($produto);

            if ($urlFoto) {
                FileUpload::deletarImagem('produtos', $urlFoto);
            }

            header('Location: ' . BASE_URL . '/painel-administrativo/produtos');
        } catch (Exception $ex) {
            header('Location: ' . BASE_URL . '/painel-administrativo/produtos?erro=' . urlencode($ex->getMessage()));
        }
        exit;
    }
}
