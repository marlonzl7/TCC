<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/config/DatabaseConnect.php');

class Telefone extends DatabaseConnect {
    private $id_telefone;
    private $id_cliente;
    private $numero;

    // construct
    public function __construct($id_cliente, $numero) {
        parent::__construct();
        $this->id_cliente = $id_cliente;
        $this->setNumero($numero);
    }

    // Método principal
    public function cadastrar() {
        try {
            // Insere na tabela Telefone
            $stmt = $this->conn->prepare('INSERT INTO Telefone (id_cliente, numero) VALUES (:id_cliente, :numero)');
            $stmt->execute([
                'id_cliente' => $this->id_cliente,
                'numero' => $this->numero
            ]);

            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function atualizarTelefone($id_cliente, $numero) {
        $this->conn->beginTransaction();
        try {
            // Atualiza o número de telefone
            $stmt = $this->conn->prepare('UPDATE Telefone SET numero = :numero WHERE id_cliente = :id_cliente');
            $stmt->execute([
                ':numero' => $numero,
                ':id_cliente' => $id_cliente
            ]);
            
            $this->conn->commit();

            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    // Painel Administrativo
    public static function deleteTelefone($id_cliente) {
        $conn = Database::getInstance()->getConnection();

        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare('DELETE FROM Telefone WHERE id_cliente = :id');
            $stmt->execute(['id' => $id_cliente]);

            $conn->commit();

            return true;
        } catch(PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    // get e set

    public function setNumero($numero) {
        // Remove caracteres não numéricos
        $numero = preg_replace('/\D/', '', $numero);

        // Verifica o comprimento e define o número de telefone
        if (strlen($numero) === 11) {
            $this->numero = $numero;
        } else if (strlen($numero) === 10) {
            $this->numero = $numero;
        } else {
            throw new Exception("Número de telefone inválido. Deve ter 10 ou 11 dígitos.");
        }
    }

    public function getNumero() {
        return $this->numero;
    }
}