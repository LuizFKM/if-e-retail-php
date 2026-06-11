<?php

namespace App\model;

use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
#[ORM\Table(name:'tb_admin')]
class Admin extends UserModel
{

    #[ORM\Column(type:'string')]
    private $matricula;
    #[ORM\Column(type:'string')]
    private $setor;
    #[ORM\Column(type:'string')]
    private $cargo;
    // Correção: tipo alterado de 'string' para 'datetime' para refletir a natureza do dado
    #[ORM\Column(type:'datetime')]
    private $dataAdmissao;
    #[ORM\Column(type:'string')]
    private $status;




    public function setMatricula($matricula){
        $this->matricula = $matricula;
    }


    public function getMatricula(){
        return $this->matricula;
    }

    public function setSetor($setor){
        $this->setor = $setor;
    }

    public function getSetor(){
        return $this->setor;
    }

    public function setCargo($cargo){
        $this->cargo = $cargo;
    }
    public function getCargo(){
        return $this->cargo;
    }

    public function setDataAdmissao($dataAdmissao){
        $this->dataAdmissao = $dataAdmissao;
    }

    public function getDataAdmissao(){
        return $this->dataAdmissao;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function getStatus(){
        return $this->status;
    }


}