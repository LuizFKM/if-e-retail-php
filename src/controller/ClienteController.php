<?php

namespace controller;

use dao\ClienteDAO;
use Exception;
use model\Cliente;

class ClienteController{

    public function novo(){
        $cliente = new Cliente();
        require __DIR__ . "/../view/cadastro-clientes.php";
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
                throw new Exception("Cliente não encontrado");
            $cliente->setName($name);
            $cliente->setLogin($login);
            $cliente->setCpf($cpf);
            $cliente->setSenha($senha);
            $cliente->setTipo('cliente');
            $cliente->setDataNascimento(new \DateTime($dataNascimento));
            ClienteDAO::salvar($cliente);
            header('Location:' . BASE_URL . '/clientes/novo');
        } catch (Exception $ex) {
            echo 'Falha ao cadastrar o cliente.' . $ex->getMessage();
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