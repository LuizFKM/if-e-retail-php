<?php

namespace App\controller;

use App\dao\ClienteDAO;
use App\dao\ItemPedidoDAO;
use App\dao\PedidoDAO;
use App\dao\ProdutoDAO;
use App\model\Carrinho;
use App\model\ItemPedido;
use App\model\Pedido;
use App\utils\Sessao;
use Exception;

// Novo: gerencia o carrinho do cliente
class CarrinhoController
{
    public function index()
    {
        $cliente  = Sessao::clienteLogado();
        $carrinho = $this->garantirCarrinho($cliente);
        require __DIR__ . '/../view/site/carrinho.php';
    }

    // Adiciona produto ao carrinho; incrementa quantidade se já existir
    public function adicionar(array $params)
    {
        $cliente   = Sessao::clienteLogado();
        $produtoId = (int) ($params['produtoId'] ?? 0);

        try {
            $produto  = ProdutoDAO::buscarPorId($produtoId);
            $carrinho = $this->garantirCarrinho($cliente);

            if (!$produto) {
                header('Location: ' . BASE_URL . '/produtos');
                exit;
            }

            // Verifica se produto já está no carrinho
            $itemExistente = null;
            foreach ($carrinho->getItens() as $item) {
                if ($item->getProduto()->getID() === $produto->getID()) {
                    $itemExistente = $item;
                    break;
                }
            }

            if ($itemExistente) {
                $itemExistente->setQuantidade($itemExistente->getQuantidade() + 1);
            } else {
                $novoItem = new ItemPedido();
                $novoItem->setProduto($produto);
                $novoItem->setQuantidade(1);
                $novoItem->setPreco($produto->getPrecoUnitario());
                $novoItem->setCarrinho($carrinho);
                $carrinho->getItens()->add($novoItem);
            }

            $this->recalcularTotal($carrinho);
            ClienteDAO::salvar($cliente);

        } catch (Exception $ex) {
            // Log silencioso — não bloqueia o fluxo
        }

        header('Location: ' . BASE_URL . '/carrinho');
        exit;
    }

    // Atualiza quantidade de um item; remove se quantidade <= 0
    public function atualizarQuantidade(array $params)
    {
        $cliente   = Sessao::clienteLogado();
        $itemId    = (int) ($params['itemId'] ?? 0);
        $quantidade = (int) filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);

        try {
            $carrinho = $this->garantirCarrinho($cliente);

            foreach ($carrinho->getItens() as $item) {
                if ($item->getID() === $itemId) {
                    if ($quantidade <= 0) {
                        $carrinho->getItens()->removeElement($item);
                    } else {
                        $item->setQuantidade($quantidade);
                    }
                    break;
                }
            }

            $this->recalcularTotal($carrinho);
            ClienteDAO::salvar($cliente);

        } catch (Exception $ex) {
            // Log silencioso
        }

        header('Location: ' . BASE_URL . '/carrinho');
        exit;
    }

    // Remove um item do carrinho pelo ID
    public function removerItem(array $params)
    {
        $cliente = Sessao::clienteLogado();
        $itemId  = (int) ($params['itemId'] ?? 0);

        try {
            $carrinho = $this->garantirCarrinho($cliente);

            foreach ($carrinho->getItens() as $item) {
                if ($item->getID() === $itemId) {
                    $carrinho->getItens()->removeElement($item);
                    break;
                }
            }

            $this->recalcularTotal($carrinho);
            ClienteDAO::salvar($cliente);

        } catch (Exception $ex) {
            // Log silencioso
        }

        header('Location: ' . BASE_URL . '/carrinho');
        exit;
    }

    // Finaliza o carrinho: cria Pedido + ItemPedidos ligados ao pedido e esvazia o carrinho.
    // Decisão de modelagem: criamos novos ItemPedido com pedido_id setado, porque o carrinho
    // usa ItemPedido com carrinho_id (são instâncias separadas). O ManyToMany legado em
    // Pedido::$itens (tb_produto_pedido) NÃO é alterado para não impactar o painel admin.
    public function finalizar()
    {
        $cliente  = Sessao::clienteLogado();
        $carrinho = $this->garantirCarrinho($cliente);

        if ($carrinho->getItens()->isEmpty()) {
            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        try {
            $agora   = new \DateTime();
            $entrega = (clone $agora)->modify('+7 days');

            // false = status Pendente (conforme exibição existente em lista-pedidos.php)
            $pedido = new Pedido($agora, $entrega, false);
            $pedido->setCliente($cliente);
            PedidoDAO::salvar($pedido);

            // Cria um ItemPedido ligado ao Pedido para cada item do carrinho
            foreach ($carrinho->getItens() as $item) {
                $ip = new ItemPedido();
                $ip->setProduto($item->getProduto());
                $ip->setQuantidade($item->getQuantidade());
                $ip->setPreco($item->getPreco());
                $ip->setPedido($pedido);
                ItemPedidoDAO::salvar($ip);
            }

            // Esvazia o carrinho (orphanRemoval remove os itens antigos do banco)
            $carrinho->getItens()->clear();
            $carrinho->setValorTotal(0);
            ClienteDAO::salvar($cliente);

        } catch (Exception $ex) {
            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        header('Location: ' . BASE_URL . '/perfil/compras');
        exit;
    }

    // Garante que o cliente tenha um carrinho; cria e persiste se não existir
    private function garantirCarrinho($cliente): Carrinho
    {
        if ($cliente->getCarrinho() === null) {
            $carrinho = new Carrinho('ABERTO');
            $cliente->setCarrinho($carrinho);
            ClienteDAO::salvar($cliente);
        }
        return $cliente->getCarrinho();
    }

    // Recalcula o valorTotal do carrinho somando preço × quantidade de cada item
    private function recalcularTotal(Carrinho $carrinho): void
    {
        $total = 0;
        foreach ($carrinho->getItens() as $item) {
            $total += $item->getPreco() * $item->getQuantidade();
        }
        $carrinho->setValorTotal($total);
    }
}
