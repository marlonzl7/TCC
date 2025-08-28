<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/ItemCarrinho.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/config/DatabaseConnect.php');

class Carrinho extends DatabaseConnect {
    private $id_carrinho;
    private $id_cliente;
    private $total;

    public function __construct($id_cliente) {
        parent::__construct();
        $this->id_cliente = $id_cliente;
        $this->id_carrinho = $this->inicializarCarrinho();
    }

    public function inicializarCarrinho() {
        $stmt = $this->conn->prepare('SELECT * FROM Carrinho WHERE id_cliente = :id_cliente');
        $stmt->execute(['id_cliente' => $this->id_cliente]);

        if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $resultado['id_carrinho'];
        } else {
            $this->conn->beginTransaction();

            try {
                $stmt = $this->conn->prepare('INSERT INTO Carrinho (id_cliente) VALUES (:id_cliente)');
                $stmt->execute(['id_cliente' => $this->id_cliente]);
                $id_carrinho = $this->conn->lastInsertId();
                
                $this->conn->commit();
                return $id_carrinho;
            } catch(PDOException $e) {
                $this->conn->rollBack();
                throw $e;
            }
        }
    }

    public function adicionarItem($id_produto, $quantidade) {
        $itemCarrinho = new ItemCarrinho($this->id_carrinho, $id_produto);
        $itemCarrinho->adicionarOuAtualizar($id_produto, $quantidade);
    }

    public function removerItem($id_produto) {
        $stmt = $this->conn->prepare('SELECT id_item FROM ItemCarrinho WHERE id_carrinho = :id_carrinho AND id_produto = :id_produto');
        $stmt->execute(['id_carrinho' => $this->id_carrinho, 'id_produto' => $id_produto]);
        $item = $stmt->fetch();
    
        if ($item) {
            $stmtDelete = $this->conn->prepare('DELETE FROM ItemCarrinho WHERE id_item = :id_item');
            $stmtDelete->execute(['id_item' => $item['id_item']]);
            return true;
        } else {
            return false;
        }
    }
    

    public function calcularTotal() {
        $stmt = $this->conn->prepare('SELECT SUM(subtotal) as total FROM ItemCarrinho WHERE id_carrinho = :id_carrinho');
        $stmt->execute(['id_carrinho' => $this->id_carrinho]);
        $result = $stmt->fetch();
        $total = $result['total'] ?? 0;

        $stmtUpdate = $this->conn->prepare('UPDATE Carrinho SET total = :total WHERE id_carrinho = :id_carrinho');
        $stmtUpdate->execute(['total' => $total, 'id_carrinho' => $this->id_carrinho]);

        return $total;
    }

    public function exibirItens() {
        $stmt = $this->conn->prepare('SELECT p.id_produto, p.nome_categoria, p.nome, p.preco, p.url, p.qtd_em_estoque, i.quantidade, i.subtotal FROM ItemCarrinho i JOIN Produto p ON i.id_produto = p.id_produto WHERE i.id_carrinho = :id_carrinho');
        $stmt->execute(['id_carrinho' => $this->id_carrinho]);
        $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $itens;
    }

    // Implementar depois
    public function limpar() {
        $this->conn->beginTransaction();

        try {
            $stmt = $this->conn->prepare("DELETE FROM Carrinho WHERE id_cliente = :id_cliente");
            $stmt->execute(['id_cliente' => $this->id_cliente]);

            $this->conn->commit();

            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    //set
    public function setTotal($total) {
        $this->total = $total;
    }

    //get
    public function getIdCarrinho() {
        return $this->id_carrinho;
    }

    public function getTotal() {
        return $this->total;
    }
}