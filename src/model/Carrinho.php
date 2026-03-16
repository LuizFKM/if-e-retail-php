<?php

namespace model;

class Carrinho extends GenericModel
{
    private $listaProdutos; // Lista de objetos Produto
    private $status;
    private $valorTotal;

    public function __construct($listaProdutos, $status, $valorTotal)
    {
        $this->listaProdutos = isset($listaProdutos) ? $listaProdutos : []; //> Aqui se o `$listaProdutos` foi informado, usa ele; caso contrário, inicia como array vazio.
        $this->status = $status;
        $this->valorTotal = $valorTotal;
    }

    public function setListaProdutos($listaProdutos)
    {
        $this->listaProdutos = $listaProdutos;
    }

    public function getListaProdutos()
    {
        return $this->listaProdutos;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;
    }

    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    public function addProduto(Produto $produto)
    {
        $this->listaProdutos[] = $produto;
        $this->valorTotal += $produto->getPrecoUnitario() * $produto->getQuantidade();
    }

    public function deleteProduto(Produto $produto)
    {
        foreach ($this->listaProdutos as $key => $item) {
            if ($item->getID() === $produto->getID()) {
                $this->valorTotal -= $item->getPrecoUnitario() * $item->getQuantidade();
                unset($this->listaProdutos[$key]);
                $this->listaProdutos = array_values($this->listaProdutos);
                break;
            }
        }
    }

    public function esvaziarCarrinho()
    {
        $this->listaProdutos = [];
        $this->valorTotal = 0;
    }
}