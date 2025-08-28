<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/config/DatabaseConnect.php';

class Pedido extends DatabaseConnect {
    private $id_pedido;
    private $id_cliente;
    private $status;
    private $total;
    private $id_endereco_entrega;

    public function __construct($id_pedido = null, $id_cliente = null, $total = null, $id_endereco_entrega = null) {
        parent::__construct();
        $this->id_cliente = $id_cliente;
        $this->total = $total;
        $this->id_endereco_entrega = $id_endereco_entrega;

        if ($id_pedido !== null) {
            $this->id_pedido = $id_pedido;
        }
    }

    public function criarPedido() {
        $this->conn->beginTransaction();

        try {
            $stmt = $this->conn->prepare("INSERT INTO Pedido (id_cliente, total, id_endereco) VALUES (:id_cliente, :total, :id_endereco)");
            $stmt->execute(['id_cliente' => $this->id_cliente, 'total' => $this->total, 'id_endereco' => $this->id_endereco_entrega]);
    
            $this->id_pedido = $this->conn->lastInsertId();

            $this->conn->commit();

            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
    
    // Funcionalidades Página Meus Pedidos
    public function enderecoPedido($id_cliente, $id_pedido) {
        // Inicia a sessão caso ainda não tenha sido iniciada
        if (!isset($_SESSION)) {
            session_start();
        }
    
        // Verifica se o id_cliente está presente na sessão
        if (!isset($_SESSION['id_cliente'])) {
            echo "ID do cliente não definido na sessão.";
            return [];
        }
    
        // SQL para buscar o endereço do pedido usando a relação entre as tabelas Pedido e Endereco
        $sql = "SELECT e.rua, e.numero, e.complemento, e.bairro, e.cidade, e.estado, e.cep 
                FROM Pedido p 
                JOIN Endereco e ON p.id_endereco = e.id_endereco 
                WHERE p.id_pedido = :id_pedido AND p.id_cliente = :id_cliente;";
    
        try {
            // Preparando a consulta
            $stmt = $this->conn->prepare($sql);
            
            // Bind dos parâmetros corretamente para PDO
            $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            
            // Executa a consulta
            $stmt->execute();
    
            // Obtém o resultado da consulta
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verifica se o resultado foi encontrado
            if ($result) {
                // Retorna um array com os dados do endereço
                return [
                    'rua' => $result['rua'],
                    'numero' => $result['numero'],
                    'complemento' => $result['complemento'] ?? '',
                    'bairro' => $result['bairro'],
                    'cidade' => $result['cidade'],
                    'estado' => $result['estado'],
                    'cep' => $result['cep']
                ];
            } else {
                echo "Endereço não encontrado para o pedido informado.";
                return [];
            }
        } catch (PDOException $e) {
            // Captura qualquer erro no processo
            echo "Erro ao buscar endereço do pedido: " . $e->getMessage();
            return [];
        }
    }

    public function listarPedidosTotais($id_cliente) {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['id_cliente'])) {
            echo "ID do cliente não definido na sessão.";
            return [];
        }
        $sql = "SELECT * FROM Pedido WHERE id_cliente = :id_cliente ORDER BY id_pedido DESC LIMIT 18446744073709551615 OFFSET 1;";
        $PedidosTotal = [];
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            $PedidosTotal = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar pedidos: " . $e->getMessage();
        }
        return $PedidosTotal;
    }
    public function listarUltimoPedido($id_cliente) {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['id_cliente'])) {
            echo "ID do cliente não definido na sessão.";
            return [];
        }
        $sql = "SELECT * FROM Pedido WHERE id_cliente = :id_cliente ORDER BY id_pedido DESC limit 1;";
        $UltimoPedido = [];
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            $UltimoPedido = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar pedidos: " . $e->getMessage();
        }
        return $UltimoPedido;

    }
    public function listarItensPedido($id_pedido) {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['id_cliente'])) {
            echo "ID do cliente não definido na sessão.";
            return [];
        }
        $sql = "SELECT 
        ip.id_produto, 
        ip.quantidade, 
        ip.subtotal, 
        p.nome_categoria, 
        p.url, 
        p.nome, 
        ip.preco_unitario
    FROM 
        ItemPedido ip
    JOIN 
        Produto p ON ip.id_produto = p.id_produto
    WHERE 
        ip.id_pedido = :id_pedido;";
    
        $ItensPedido = [];
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
            $stmt->execute();
            $ItensPedido = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar pedidos: " . $e->getMessage();
        }
        return $ItensPedido;
    }


    // Funcionalidades do Painel Administrativo
    public static function listarPedidos() {
        $conn = Database::getInstance()->getConnection();

        try {
            $sql = "
                SELECT p.*, c.nome AS nome_cliente 
                FROM Pedido p 
                INNER JOIN Cliente c 
                ON p.id_cliente = c.id_cliente
            ";
            $stmt = $conn->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public static function buscarPedido($pesquisa) {
        $conn = Database::getInstance()->getConnection();
    
        try {
            $sql = "SELECT Pedido.*, Cliente.nome AS nome_cliente
                    FROM Pedido 
                    JOIN Cliente ON Pedido.id_cliente = Cliente.id_cliente 
                    WHERE Pedido.id_pedido LIKE :pesquisa 
                    OR Pedido.id_cliente LIKE :pesquisa 
                    OR Pedido.data_pedido LIKE :pesquisa 
                    OR Pedido.status LIKE :pesquisa 
                    OR Pedido.total LIKE :pesquisa
                    OR Cliente.nome LIKE :pesquisa";
                    
            $stmt = $conn->prepare($sql);
            $stmt->execute([':pesquisa' => $pesquisa]);
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }
    

    public function alterarStatusPedido($status) {
        $this->setStatus($status);

        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("UPDATE Pedido SET status = :status WHERE id_pedido = :id_pedido");
            $stmt->execute(['status' => $this->status, 'id_pedido' => $this->id_pedido]);

            $this->conn->commit();

            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public static function visualizarPedidoCompleto($id_pedido) {
        $conn = Database::getInstance()->getConnection();

        try {
            $sql = "
                SELECT 
                    Pedido.*,
                    ItemPedido.*,
                    Cliente.nome
                FROM Pedido
                JOIN ItemPedido ON Pedido.id_pedido = ItemPedido.id_pedido
                JOIN Cliente ON Pedido.id_cliente = Cliente.id_cliente
                WHERE Pedido.id_pedido = :id_pedido
            ";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id_pedido' => $id_pedido]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public static function enderecoPedidoAdm($id_pedido) {
        $conn = Database::getInstance()->getConnection();
        // SQL para buscar o endereço do pedido usando a relação entre as tabelas Pedido e Endereco
        $sql = "SELECT e.rua, e.numero, e.complemento, e.bairro, e.cidade, e.estado, e.cep 
                FROM Pedido p 
                JOIN Endereco e ON p.id_endereco = e.id_endereco 
                WHERE p.id_pedido = :id_pedido";
    
        try {
            // Preparando a consulta
            $stmt = $conn->prepare($sql);
            
            // Bind dos parâmetros corretamente para PDO
            $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
            
            // Executa a consulta
            $stmt->execute();
    
            // Obtém o resultado da consulta
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verifica se o resultado foi encontrado
            if ($result) {
                // Retorna um array com os dados do endereço
                return [
                    'rua' => $result['rua'],
                    'numero' => $result['numero'],
                    'complemento' => $result['complemento'] ?? '',
                    'bairro' => $result['bairro'],
                    'cidade' => $result['cidade'],
                    'estado' => $result['estado'],
                    'cep' => $result['cep']
                ];
            } else {
                echo "Endereço não encontrado para o pedido informado.";
                return [];
            }
        } catch (PDOException $e) {
            // Captura qualquer erro no processo
            echo "Erro ao buscar endereço do pedido: " . $e->getMessage();
            return [];
        }
    }

    public static function obterStatusPedido($id_pedido) {
        $conn = Database::getInstance()->getConnection();

        try {
            $stmt = $conn->prepare('SELECT status FROM Pedido WHERE id_pedido = :id_pedido');
            $stmt->execute(['id_pedido' => $id_pedido]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }
    
    // setters
    public function setStatus($status) {
        $status_possiveis = [
            'aguardando pagamento', 
            'processando', 
            'em separação', 
            'a caminho', 
            'entregue', 
            'cancelado'
        ];

        if (!in_array($status, $status_possiveis)) {
            throw new Exception("Status inválido");
        }

        $this->status = $status;
    }

    // getters
    public function getIdPedido() {
        return $this->id_pedido;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getTotal() {
        return $this->total;
    }
}

/*

Finalizando compra

$pedido = new Pedido($id_cliente);
$pedido->criarPedido();
$id_pedido = getIdPedido();

$carrinho = new Carrinho($id_cliente);
$itensCarrinho = $carrinho->exibirItens();

foreach ($itensCarrinho as $item) {
    $itemPedido = new ItemPedido($id_pedido);
    
    $id_produto = $item['id_produto'];
    $quantidade = $item['quantidade'];
    $subtotal = $item['subtotal'];

    if (!$itemPedido->adicionarItem($produto, $quantidade, $subtotal)) {
        throw New Exception("Falha ao adicionar Item a tabela Pedido");
    }
}

*/