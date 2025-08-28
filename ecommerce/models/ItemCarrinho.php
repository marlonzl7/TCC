<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Produto.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/config/DatabaseConnect.php');

class ItemCarrinho extends DatabaseConnect {
    private $id_item;
    private $id_carrinho;
    private $produto;
    private $quantidade;
    private $subtotal;

    public function __construct($id_carrinho, $id_produto = null) {
        parent::__construct();
        $this->id_carrinho = $id_carrinho;

        if ($id_produto) {
            $this->carregarProdutoPorId($id_produto);
        }
    }

    public function carregarProdutoPorId($id_produto) {
        $stmt = $this->conn->prepare('SELECT * FROM ItemCarrinho WHERE id_carrinho = :id_carrinho AND id_produto = :id_produto');
        $stmt->execute(['id_carrinho' => $this->id_carrinho, 'id_produto' => $id_produto]);
        $item = $stmt->fetch();

        if ($item) {
            $this->id_item = $item['id_item'];
            $this->produto = new Produto($id_produto);
            $this->quantidade = $item['quantidade'];
            $this->subtotal = $item['subtotal'];
        }
    }

    public function adicionarOuAtualizar($id_produto, $quantidade) {
        if ($this->id_item) {
            $novaQuantidade = $this->quantidade + $quantidade;

            // Verifica se a nova quantidade é menor que 1
            if ($novaQuantidade <= 0) {
                // Se a quantidade for 0 ou menos, remova o item do carrinho
                $stmt = $this->conn->prepare('DELETE FROM ItemCarrinho WHERE id_item = :id_item');
                $stmt->execute(['id_item' => $this->id_item]);
                $this->id_item = null;
            } else {
                // Atualiza o item se a quantidade for válida
                $stmt = $this->conn->prepare('UPDATE ItemCarrinho SET quantidade = :quantidade, subtotal = :subtotal WHERE id_item = :id_item');
                $stmt->execute([
                    'quantidade' => $novaQuantidade,
                    'subtotal' => $novaQuantidade * $this->produto->getPreco(),
                    'id_item' => $this->id_item
                ]);
                $this->quantidade = $novaQuantidade;
                $this->subtotal = $novaQuantidade * $this->produto->getPreco();
            }
        } else {
            // Insere o item no carrinho
            $produto = new Produto($id_produto);
            $stmt = $this->conn->prepare('INSERT INTO ItemCarrinho (id_carrinho, id_produto, quantidade, subtotal) VALUES (:id_carrinho, :id_produto, :quantidade, :subtotal)');
            $stmt->execute([
                'id_carrinho' => $this->id_carrinho,
                'id_produto' => $id_produto,
                'quantidade' => $quantidade,
                'subtotal' => $produto->getPreco() * $quantidade
            ]);
            $this->id_item = $this->conn->lastInsertId();
            $this->produto = $produto;
            $this->quantidade = $quantidade;
            $this->subtotal = $produto->getPreco() * $quantidade;
        }
    }

    public function remover() {
        if ($this->id_item) {
            $stmt = $this->conn->prepare('DELETE FROM ItemCarrinho WHERE id_item = :id_item');
            $stmt->execute(['id_item' => $this->id_item]);
            $this->id_item = null;
        }
    }
    
    //getters
    public function getSubtotal() {
        return $this->subtotal;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function getProduto() {
        return $this->produto;
    }
}