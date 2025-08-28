<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/config/DatabaseConnect.php';

class Pagamento extends DatabaseConnect {
    private $id_pagamento;
    private $id_pedido;
    private $valor;
    private $metodo;

    public function __construct($id_pedido, $valor, $metodo) {
        parent::__construct();

        $this->id_pedido = $id_pedido;
        $this->valor = $valor;
        $this->metodo = $metodo;
    }

    public function criarPagamento() {
        $this->conn->beginTransaction();

        try {
            $stmt = $this->conn->prepare('INSERT INTO Pagamento (id_pedido, valor, metodo) VALUES (:id_pedido, :valor, :metodo)');
            $stmt->execute(['id_pedido' => $this->id_pedido, 'valor' => $this->valor, 'metodo' => $this->metodo]);

            $this->conn->commit();

            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
    
    // Setters
    public function setIdPedido($id_pedido) {
        $this->id_pedido = $id_pedido;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function setMetodo($metodo) {
        $metodosAceitos = ['Cartão', 'Boleto', 'Pix'];

        if (!in_array($metodo, $metodosAceitos)) {
            throw new Exception("Método de pagamento inválido. Os métodos aceitos são (Cartão, Boleto ou Pix");
        }

        $this->metodo = $metodo;
    }
}