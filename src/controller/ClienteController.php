<?php

namespace App\controller;

use App\dao\ClienteDAO;
use Exception;
use App\model\Cliente;

class ClienteController{

    public function novo(){
        $cliente = new Cliente();
        $erro = $_SESSION['cadastro_erro'] ?? null;
        unset($_SESSION['cadastro_erro']);
        require __DIR__ . "/../view/site/cadastro-clientes.php";
    }

    public function cadastrar(){
        $id             = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $name           = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $login          = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
        $cpf            = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
        $senha          = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento', FILTER_SANITIZE_SPECIAL_CHARS);

        $cliente = $id ? ClienteDAO::buscarPorId($id) : new Cliente();
        try {
            if (empty($cliente))
                throw new Exception("Cliente não encontrado.");
            if (mb_strlen(trim($name)) < 3)
                throw new Exception("Nome deve ter pelo menos 3 caracteres.");
            if (!filter_var($login, FILTER_VALIDATE_EMAIL))
                throw new Exception("E-mail inválido.");
            if (!$id && ClienteDAO::buscarPorLogin($login))
                throw new Exception("Este e-mail já está cadastrado.");
            $cpfDigitos = preg_replace('/\D/', '', $cpf);
            if (strlen($cpfDigitos) !== 11)
                throw new Exception("CPF incompleto. Preencha os 11 dígitos.");
            if (mb_strlen($senha) < 6)
                throw new Exception("A senha deve ter pelo menos 6 caracteres.");
            if (empty($dataNascimento))
                throw new Exception("Data de nascimento obrigatória.");
            $data = \DateTime::createFromFormat('Y-m-d', $dataNascimento);
            $hoje = new \DateTime('today');
            if (!$data || $data->format('Y-m-d') !== $dataNascimento)
                throw new Exception("Data de nascimento inválida.");
            if ($data >= $hoje)
                throw new Exception("A data de nascimento deve ser anterior a hoje.");
            if ((int)$data->format('Y') < 1900)
                throw new Exception("Data de nascimento inválida.");

            $cliente->setName(trim($name));
            $cliente->setLogin($login);
            $cliente->setCpf($cpf);
            $cliente->setSenha($senha);
            $cliente->setTipo('cliente');
            $cliente->setDataNascimento(new \DateTime($dataNascimento));
            ClienteDAO::salvar($cliente);
            header('Location:' . BASE_URL . '/login');
        } catch (Exception $ex) {
            $_SESSION['cadastro_erro'] = $ex->getMessage();
            header('Location:' . BASE_URL . '/clientes/novo');
        } finally {
            exit;
        }
    }


    public function listar(){
        try{
            $clientes = ClienteDAO::listar();
        }catch(Exception $ex){
            echo "Falha ao listar os clientes" . $ex->getMessage();
        } finally {
            require __DIR__ . "/../view/lista-clientes.php";
        }
    }

    public function buscar(array $params){
        try{
            $id = $params['id'];
            $cliente = ClienteDAO::buscarPorId($id);
            if(empty($cliente)){
                throw new Exception("Cliente nao encontrado");
            }
        }catch(Exception $ex){
            echo "Falha ao buscar cliente" . $ex->getMessage();
        }finally{
            require __DIR__ . "/../view/visualizar-cliente.php";
        }
    }

    public function remover(array $params){
        try{
            $id = $params['id'];
            $cliente = ClienteDAO::buscarPorId($id);
            if(empty($cliente)){
                throw new Exception("Cliente nao encontrado");
            }
            ClienteDAO::deletar($cliente);
        }catch (Exception $ex){
            echo "Falha ao remover cliente" . $ex->getMessage();
        }finally{
            header('Location: ' . BASE_URL . '/clientes');
            exit;
        }
    }
}