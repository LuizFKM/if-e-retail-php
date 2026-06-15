<?php

namespace App\model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tb_cliente')]
class Cliente extends UserModel
{
    #[ORM\OneToOne(targetEntity: Carrinho::class, cascade: ['all'], orphanRemoval: true, fetch: 'LAZY')]
    #[ORM\JoinColumn(name: "carrinho_id")]
    private $carrinho;

    #[ORM\OneToMany(mappedBy: "cliente", targetEntity: Pedido::class, orphanRemoval: true,fetch: 'LAZY')]
    private $listaPedidos;

    #[ORM\ManyToMany(targetEntity: Produto::class)]
    #[ORM\JoinTable(name: 'tb_produtos_favoritos')]
    #[ORM\JoinColumn(name: "cliente_id", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "produto_id", referencedColumnName: "id")]
    private $listaFavoritos;

    public function __construct() {
        // Inicializa coleções para evitar erro de coleção nula em clientes recém-criados.
        // Doctrine sobrescreve com PersistentCollection ao carregar do banco.
        parent::__construct();
        $this->listaFavoritos = new ArrayCollection();
        $this->listaPedidos   = new ArrayCollection();
    }

    public function setCarrinho($carrinho){
        $this->carrinho = $carrinho;
    }

    public function getCarrinho(){
        return $this->carrinho;
    }

    public function setListaPedidos($listaPedidos){
        $this->listaPedidos = $listaPedidos;
    }

    public function getListaPedidos(){
        return $this->listaPedidos;
    }

    public function setListaFavoritos($listaFavoritos){
        $this->listaFavoritos = $listaFavoritos;
    }

    public function getListaFavoritos(){
        return $this->listaFavoritos;
    }

    // Novo: adiciona produto à lista de favoritos se ainda não estiver presente
    public function adicionarFavorito(Produto $p): void
    {
        if (!$this->temFavorito($p)) {
            $this->listaFavoritos->add($p);
        }
    }

    // Novo: remove produto da lista de favoritos
    public function removerFavorito(Produto $p): void
    {
        foreach ($this->listaFavoritos as $fav) {
            if ($fav->getID() === $p->getID()) {
                $this->listaFavoritos->removeElement($fav);
                break;
            }
        }
    }

    // Novo: verifica se um produto já está nos favoritos
    public function temFavorito(Produto $p): bool
    {
        if ($this->listaFavoritos === null) return false;
        foreach ($this->listaFavoritos as $fav) {
            if ($fav->getID() === $p->getID()) return true;
        }
        return false;
    }
}
