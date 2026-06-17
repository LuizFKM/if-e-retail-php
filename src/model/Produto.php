<?php

namespace App\model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "tb_produto")]
class Produto extends GenericModel
{
    #[ORM\Column(type: "string")]
    private $descricao;

    #[ORM\Column(type: "integer")]
    private $quantidade;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private $precoUnitario;

    #[ORM\Column(type: 'string', nullable: true)]
    private $urlFotoProduto;


    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setPrecoUnitario($precoUnitario)
    {
        $this->precoUnitario = $precoUnitario;
    }

    public function getPrecoUnitario()
    {
        return $this->precoUnitario;
    }

    public function setUrlFotoProduto($url)
    {
        $this->urlFotoProduto = $url;
    }

    public function getUrlFotoProduto()
    {
        return $this->urlFotoProduto;
    }
}