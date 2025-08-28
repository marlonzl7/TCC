<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/config/DatabaseConnect.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/models/Cliente.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/models/Endereco.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/models/Telefone.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/models/Carrinho.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/models/ItemCarrinho.php';

    class ClientService extends DatabaseConnect {

        public function findClientById($id_usuario) {

            $stmt = $this->conn->prepare('
            SELECT Cliente.*, Usuario.*
                FROM Cliente
                JOIN Usuario ON Cliente.id_usuario = Usuario.id_usuario
                WHERE 
                Cliente.id_usuario = :id_usuario;
            ');
            $stmt->execute(['id_usuario' => $id_usuario]);
            $client = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($client) {
                return new Cliente($client['email'], null, $client['cpf'], $client['nome'], $client['data_nasc'], $client['sexo']);
            } else {
                return null;
            }

        }

        public function findAdressById($id_cliente) {

            $stmt = $this->conn->prepare('SELECT * FROM Endereco WHERE id_cliente = :id_cliente');
            $stmt->execute(['id_cliente' => $id_cliente]);
            $enderecoCliente = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($enderecoCliente) {
                return new Endereco($enderecoCliente['id_cliente'], $enderecoCliente['rua'], $enderecoCliente['numero'], $enderecoCliente['complemento'], $enderecoCliente['bairro'], $enderecoCliente['cidade'], $enderecoCliente['estado'], $enderecoCliente['cep']);
            } else {
                return null;
            }

        }

        
        public function findNumberById($id_cliente) {

            $stmt = $this->conn->prepare('SELECT * FROM Telefone WHERE id_cliente = :id_cliente');
            $stmt->execute(['id_cliente' => $id_cliente]);
            $number = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($number) {
                return new Telefone($id_cliente, $number['numero']);
            } else {
                return null;
            }

        }
  
    }

?>