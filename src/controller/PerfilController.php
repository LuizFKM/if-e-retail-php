<?php

namespace App\controller;

use App\dao\CidadeDAO;
use App\dao\ClienteDAO;
use App\dao\ItemPedidoDAO;
use App\model\Contato;
use App\model\Endereco;
use App\utils\FileUpload;
use App\utils\Sessao;
use Exception;

// Novo: controller das telas de perfil do cliente (abas + ações de configuração)
class PerfilController
{
    // Redireciona para a aba padrão (favoritos)
    public function index()
    {
        header('Location: ' . BASE_URL . '/perfil/favoritos');
        exit;
    }

    public function favoritos()
    {
        $cliente  = Sessao::clienteLogado();
        $favoritos = $cliente->getListaFavoritos();

        ob_start();
        require __DIR__ . '/../view/cliente/perfil-favoritos.php';
        $conteudo = ob_get_clean();

        require __DIR__ . '/../view/layouts/perfil-cliente-layout.php';
    }

    public function compras()
    {
        $cliente = Sessao::clienteLogado();
        $pedidos = $cliente->getListaPedidos();

        ob_start();
        require __DIR__ . '/../view/cliente/perfil-compras.php';
        $conteudo = ob_get_clean();

        require __DIR__ . '/../view/layouts/perfil-cliente-layout.php';
    }

    public function configuracoes()
    {
        $cliente  = Sessao::clienteLogado();
        $ok       = filter_input(INPUT_GET, 'ok');
        $cidades  = CidadeDAO::listar();

        ob_start();
        require __DIR__ . '/../view/cliente/perfil-configuracoes.php';
        $conteudo = ob_get_clean();

        require __DIR__ . '/../view/layouts/perfil-cliente-layout.php';
    }

    // Salva nome, email (contato), telefone (contato) e senha do cliente
    // Nota: UserModel::$login armazena o e-mail de acesso; Contato::$email é o contato.
    // Não unificamos os dois campos agora para não quebrar o cadastro existente.
    public function salvarDados()
    {
        $cliente  = Sessao::clienteLogado();
        $name     = filter_input(INPUT_POST, 'name',     FILTER_SANITIZE_SPECIAL_CHARS);
        $email    = filter_input(INPUT_POST, 'email',    FILTER_SANITIZE_SPECIAL_CHARS);
        $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
        $senha    = filter_input(INPUT_POST, 'senha',    FILTER_SANITIZE_SPECIAL_CHARS);

        try {
            $cliente->setName($name);

            // Senha só é atualizada se preenchida (campo opcional no formulário)
            // Recomendação futura: usar password_hash() aqui e password_verify() no login
            if (!empty($senha)) {
                $cliente->setSenha($senha);
            }

            // Atualiza ou cria contato com email e telefone
            $contatos = $cliente->getContatos();
            if ($contatos->isEmpty()) {
                $contato = new Contato($telefone, $email);
                $contato->setUsuario($cliente);
                $contatos->add($contato);
            } else {
                $contato = $contatos->first();
                $contato->setEmail($email);
                $contato->setTelefone($telefone);
            }

            ClienteDAO::salvar($cliente);
            header('Location: ' . BASE_URL . '/perfil/configuracoes?ok=1');
        } catch (Exception $ex) {
            header('Location: ' . BASE_URL . '/perfil/configuracoes?erro=' . urlencode($ex->getMessage()));
        }
        exit;
    }

    // Cria ou atualiza o endereço do cliente
    public function salvarEndereco()
    {
        $cliente = Sessao::clienteLogado();

        $rua        = filter_input(INPUT_POST, 'rua',        FILTER_SANITIZE_SPECIAL_CHARS);
        $numero     = filter_input(INPUT_POST, 'numero',     FILTER_SANITIZE_SPECIAL_CHARS);
        $complemento= filter_input(INPUT_POST, 'complemento',FILTER_SANITIZE_SPECIAL_CHARS);
        $bairro     = filter_input(INPUT_POST, 'bairro',     FILTER_SANITIZE_SPECIAL_CHARS);
        $cidade     = filter_input(INPUT_POST, 'cidade',     FILTER_SANITIZE_SPECIAL_CHARS);
        $estado     = filter_input(INPUT_POST, 'estado',     FILTER_SANITIZE_SPECIAL_CHARS);
        $cep        = filter_input(INPUT_POST, 'cep',        FILTER_SANITIZE_SPECIAL_CHARS);
        $pais       = filter_input(INPUT_POST, 'pais',       FILTER_SANITIZE_SPECIAL_CHARS);

        try {
            $endereco = $cliente->getEndereco();

            if (!$endereco) {
                $endereco = new Endereco($rua, $numero, $complemento, $bairro, $cidade, $estado, $cep, $pais);
                $cliente->setEndereco($endereco);
            } else {
                $endereco->setRua($rua);
                $endereco->setNumero($numero);
                $endereco->setComplemento($complemento);
                $endereco->setBairro($bairro);
                $endereco->setCidade($cidade);
                $endereco->setEstado($estado);
                $endereco->setCep($cep);
                $endereco->setPais($pais);
            }

            ClienteDAO::salvar($cliente);
            header('Location: ' . BASE_URL . '/perfil/configuracoes?ok=1');
        } catch (Exception $ex) {
            header('Location: ' . BASE_URL . '/perfil/configuracoes?erro=' . urlencode($ex->getMessage()));
        }
        exit;
    }

    // Upload de foto via Cloudinary; apaga a imagem antiga após salvar a nova (rollback em erro)
    public function salvarFoto()
    {
        $cliente = Sessao::clienteLogado();

        if (!empty($_FILES['imagem_cliente']['tmp_name'])) {
            $urlAntiga  = $cliente->getUrlFotoPerfil();
            $uploadResult = null;

            try {
                $uploadResult = FileUpload::uploadImagem(
                    'clientes',
                    $_FILES['imagem_cliente']['tmp_name'],
                    uniqid('imagem_do_cliente_')
                );

                $cliente->setUrlFotoPerfil($uploadResult['secure_url']);
                ClienteDAO::salvar($cliente);

                // Apaga foto antiga só após persistir a nova com sucesso
                if ($urlAntiga) {
                    FileUpload::deletarImagem('clientes', $urlAntiga);
                }

            } catch (Exception $ex) {
                // Se o upload chegou a subir mas o salvar falhou, apaga a nova imagem
                if (!empty($uploadResult['secure_url'])) {
                    FileUpload::deletarImagem('clientes', $uploadResult['secure_url']);
                }
                header('Location: ' . BASE_URL . '/perfil/configuracoes?erro=' . urlencode($ex->getMessage()));
                exit;
            }
        }

        header('Location: ' . BASE_URL . '/perfil/configuracoes?ok=1');
        exit;
    }

    // Exclui a conta do cliente, apaga foto no Cloudinary e encerra a sessão
    public function excluirConta()
    {
        $cliente  = Sessao::clienteLogado();
        $urlFoto  = $cliente->getUrlFotoPerfil();

        try {
            ClienteDAO::deletar($cliente);

            if ($urlFoto) {
                FileUpload::deletarImagem('clientes', $urlFoto);
            }
        } catch (Exception $ex) {
            // Log silencioso — sessão é destruída de qualquer forma
        }

        session_destroy();
        header('Location: ' . BASE_URL . '/');
        exit;
    }
}
