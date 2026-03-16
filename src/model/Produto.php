<?php

namespace model;

class Produto extends GenericModel
{
    private $descricao;
    private $quantidade;
    private $precoUnitario;
    private $status;

    public function __construct($descricao, $quantidade, $precoUnitario, $status)
    {
        $this->descricao = $descricao;
        $this->quantidade = $quantidade;
        $this->precoUnitario = $precoUnitario;
        $this->status = $status;
    }

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

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }
}