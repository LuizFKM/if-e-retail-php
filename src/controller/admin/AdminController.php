<?php

namespace controllerdmin;

use Exception;
use dao\AdminDAO;
use model\Admin;

class AdminController{

    public function novo(){
        $admin = new Admin();
        require __DIR__ . "/../../view/admin/cadastro-funcionarios.php";
    }

    public function cadastrar(){
        $id             = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $name           = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $login          = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
        $cpf            = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
        $senha          = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento', FILTER_SANITIZE_SPECIAL_CHARS);
        $matricula      = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_SPECIAL_CHARS);
        $setor          = filter_input(INPUT_POST, 'setor', FILTER_SANITIZE_SPECIAL_CHARS);
        $cargo          = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_SPECIAL_CHARS);
        $dataAdmissao   = filter_input(INPUT_POST, 'dataAdmissao', FILTER_SANITIZE_SPECIAL_CHARS);
        $status         = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

        $admin = $id ? AdminDAO::buscarPorId($id) : new Admin();
        try {
            if (empty($admin))
                throw new Exception("Funcionário não encontrado");
            $admin->setName($name);
            $admin->setLogin($login);
            $admin->setCpf($cpf);
            $admin->setSenha($senha);
            $admin->setTipo('admin');
            $admin->setDataNascimento(new \DateTime($dataNascimento));
            $admin->setMatricula($matricula);
            $admin->setSetor($setor);
            $admin->setCargo($cargo);
            $admin->setDataAdmissao(new \DateTime($dataAdmissao));
            $admin->setStatus($status);
            AdminDAO::salvar($admin);
            header('Location:' . BASE_URL . '/admin/novo');
        } catch (Exception $ex) {
            echo 'Falha ao cadastrar o funcionário.' . $ex->getMessage();
            header('Location:' . BASE_URL . '/admin/novo');
        } finally {
            exit;
        }
    }


    public function listar(){
        try{
            $admins = AdminDAO::listar();
        }catch(Exception $ex){
            echo "Falha ao listar funcionarios" . $ex->getMessage();
        }finally{
            require __DIR__ . "/../../view/admin/lista-funcionarios.php";
        }
    }

    public function buscar(array $params){
        try{
            $id = $params['id'];
            $admin = AdminDAO::buscarPorId($id);
            if(empty($admin)){
                echo "funcionario nao encontrado!";
            }
        }catch(Exception $ex){
            echo "Falha ao buscar funcionario " . $ex->getMessage();
        }finally{
            require __DIR__ . "/../../view/admin/lista-funcionarios.php";
        }
    }

    public function remover(array $params){
        try{
            $id = $params['id'];
            $admin = AdminDAO::buscarPorId($id);
            if(empty($admin)){
                echo "funcionario nao encontrado!";
            }
            AdminDAO::deletar($admin);
        }catch(Exception $ex){
            echo "Falha ao remover " . $ex->getMessage();
        }finally{
            header('Location: ' . BASE_URL . "/admin");
            exit;
        }
    }

}