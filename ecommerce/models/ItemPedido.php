<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Pedido.php');

class ItemPedido extends Pedido {
    private $id_item_pedido;
    private $id_pedido;
    private $id_produto;
    private $quantidade;
    private $subtotal;

    public function __construct($id_pedido) {
        parent::__construct();
        $this->id_pedido = $id_pedido;
    }

    public function adicionarItem($id_produto, $preco_unitario, $quantidade, $subtotal) {
        $this->conn->beginTransaction();
        
        try {
            $stmt = $this->conn->prepare("INSERT INTO ItemPedido (id_pedido, id_produto, preco_unitario, quantidade, subtotal) VALUES (:id_pedido, :id_produto, :preco_unitario, :quantidade, :subtotal)");
            $stmt->execute([
                'id_pedido' => $this->id_pedido, 
                'id_produto' => $id_produto, 
                'preco_unitario' => $preco_unitario,
                'quantidade' => $quantidade, 
                'subtotal' => $subtotal
            ]);
    
            $this->id_produto = $id_produto;
            $this->quantidade = $quantidade;
            $this->subtotal = $subtotal;
    
            $this->conn->commit();
    
            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }    
}