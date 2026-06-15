<?php

namespace App\model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tb_cidade')]
class Cidade extends GenericModel
{
    #[ORM\Column(type: 'string', nullable: false)]
    private $nome;

    // UF com 2 caracteres (ex.: SP, RJ, DF)
    #[ORM\Column(type: 'string', length: 2, nullable: false)]
    private $estado;

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }
}
