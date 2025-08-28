<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Usuario.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Endereco.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Telefone.php');

class Cliente extends Usuario {
    private $id_cliente;
    private $cpf;
    private $nome;
    private $dataNasc;
    private $sexo;
    private $enderecos;
    private $telefones;

    // construct
    public function __construct($email, $senha, $cpf = null, $nome = null, $dataNasc = null, $sexo = null) {
        parent::__construct($email, $senha, 'cliente');

        // Atributos opcionais
        if (($cpf !== null) && ($nome !== null) && ($dataNasc !== null) && ($sexo !== null)) {
            $this->setCpf($cpf);
            $this->setNome($nome);
            $this->setDataNasc($dataNasc);
            $this->setSexo($sexo);
        }
    }

    // Métodos principais
    public function adicionarEndereco($rua, $numero, $complemento, $bairro, $cidade, $uf, $cep) {
        $this->enderecos[] = compact('rua', 'numero', 'complemento', 'bairro', 'cidade', 'uf', 'cep');
    }

    public function adicionarTelefone($numero) {
        $this->telefones[] = compact('numero');
    }

    #[\Override]
    public function cadastrar() {
        // Inicia transação
        $this->conn->beginTransaction();

        try {
            // Insere na tabela Usuario
            parent::cadastrar();

            // Insere na tabela Cliente
            $stmt = $this->conn->prepare('INSERT INTO Cliente (id_usuario, cpf, nome, data_nasc, sexo) VALUES (:id_usuario, :cpf, :nome, :data_nasc, :sexo)');
            $stmt->execute(['id_usuario' => $this->getIdUsuario(), 'cpf' => $this->cpf, 'nome' => $this->nome, 'data_nasc' => $this->dataNasc, 'sexo' => $this->sexo]);

            // Obtem o id do cliente (id_cliente)
            $this->id_cliente = $this->conn->lastInsertId();

            // Cria um Objeto Endereço para cada endereço do array
            foreach ($this->enderecos as $endereco) {
                $enderecoObj = new Endereco(
                    $this->id_cliente, 
                    $endereco['rua'], 
                    $endereco['numero'], 
                    $endereco['complemento'],
                    $endereco['bairro'], 
                    $endereco['cidade'], 
                    $endereco['uf'], 
                    $endereco['cep']
                );
                // Cadastra Endereço
                $enderecoObj->cadastrar();
            }

            // Cria um Objeto Telefone para cada telefone do array
            foreach ($this->telefones as $telefone) {
                $telefoneObj = new Telefone(
                    $this->id_cliente, 
                    $telefone['numero']
                );
                // Cadastra Telefone
                $telefoneObj->cadastrar();
            }

            // Confirmar transação
            $this->conn->commit();

            return true;
        } catch(PDOException $e) {
            // Reverter transação em caso de erro
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function logar($email, $senha) {
        try {
            if (parent::logar($email, $senha)) {
                $stmt = $this->conn->prepare('SELECT id_cliente FROM Cliente WHERE id_usuario = :id_usuario');
                $stmt->execute(['id_usuario' => $this->id_usuario]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $this->id_cliente = $user['id_cliente'];
                    return true;
                }
            } else {
                return false;
            }
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function atualizarDadosCliente($id_usuario, $id_cliente, $dadosCliente, $dadosUsuario) {
        try {
            // Inicia transação
            $this->conn->beginTransaction();
    
            // Atualiza os dados do cliente
            $stmtCliente = $this->conn->prepare('
                UPDATE Cliente 
                SET cpf = :cpf, nome = :nome, data_nasc = :data_nasc, sexo = :sexo
                WHERE id_cliente = :id_cliente
            ');
            $stmtCliente->execute([
                ':cpf' => $dadosCliente['cpf'],
                ':nome' => $dadosCliente['nome'],
                'data_nasc' => $dadosCliente['data_nasc'],
                ':sexo' => $dadosCliente['sexo'],
                ':id_cliente' => $id_cliente
            ]);
    
            // Atualiza os email do usuário
            $stmtUsuario = $this->conn->prepare('
                UPDATE Usuario 
                SET email = :email, tipo = :tipo
                WHERE id_usuario = :id_usuario
            ');
            $stmtUsuario->execute([
                ':email' => $dadosUsuario['email'],
                ':id_usuario' => $id_usuario, 
                ':tipo' => "cliente"
            ]);
    
            // Confirma a transação
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            // Reverte a transação em caso de erro
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function atualizarEmail($id_usuario, $email) {
        try {
            // Inicia transação
            $this->conn->beginTransaction();
            
            // Atualiza os email do usuário
            $stmtUsuario = $this->conn->prepare('
                UPDATE Usuario 
                SET email = :email, tipo = :tipo
                WHERE id_usuario = :id_usuario
            ');
            $stmtUsuario->execute([
                ':email' => $email,
                ':id_usuario' => $id_usuario, 
                ':tipo' => "cliente"
            ]);
    
            // Confirma a transação
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            // Reverte a transação em caso de erro
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function atualizarEndereco($id_cliente, $dadosEndereco) {
        try {
            // Inicia transação
            $this->conn->beginTransaction();
    
            // Atualiza os dados do endereço
            $stmtEndereco = $this->conn->prepare('
                UPDATE Endereco 
                SET cep = :cep, rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, estado = :estado
                WHERE id_endereco = :id_endereco
            ');
            $stmtEndereco->execute([
                ':cep' => $dadosEndereco['cep'],
                ':rua' => $dadosEndereco['rua'],
                ':numero' => $dadosEndereco['numero'],
                ':complemento' => $dadosEndereco['complemento'],
                ':bairro' => $dadosEndereco['bairro'],
                ':cidade' => $dadosEndereco['cidade'],
                ':estado' => $dadosEndereco['estado'],
                ':id_endereco' => $dadosEndereco['id_endereco']
            ]);
    
            // Confirma a transação
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            // Reverte a transação em caso de erro
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function listarDados($id_usuario) {
        $stmt = $this->conn->prepare('
            SELECT Cliente.*, Usuario.*
            FROM Cliente
            JOIN Usuario ON Cliente.id_usuario = Usuario.id_usuario
            WHERE 
            Cliente.id_usuario = :id_usuario
        ');
        $stmt->execute(['id_usuario' => $id_usuario]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $dados ? $dados : null;
    }

    public function telefone($id_cliente){
        $stmt = $this->conn->prepare('
            SELECT * FROM Telefone WHERE Telefone.id_cliente = :id_cliente
        ');
        $stmt->execute(['id_cliente' => $id_cliente]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $dados ? $dados : null;
    }
    
    public function enderecoPrincipal($id_cliente){
        $stmt = $this->conn->prepare('
            SELECT * FROM Endereco WHERE Endereco.id_cliente = :id_cliente AND Endereco.tipo = :tipo
        ');
        $stmt->execute(['id_cliente' => $id_cliente, 'tipo' => 'Principal']);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($dados) {
            $dados['complemento'] = isset($dados['complemento']) ? $dados['complemento'] : 'N/A';
        }
    
        return $dados ? $dados : null;
    }

    public function enderecoSecundario($id_cliente){
        $stmt = $this->conn->prepare("
            SELECT * FROM Endereco WHERE Endereco.id_cliente = :id_cliente AND Endereco.tipo = :tipo
        ");
        $stmt->execute(['id_cliente' => $id_cliente, 'tipo' => 'Secundário']);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($dados) {
            $dados['complemento'] = isset($dados['complemento']) ? $dados['complemento'] : 'N/A';
        }
    
        return $dados ? $dados : null;
    }

    public function limitarEndereco($id_cliente){
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM Endereco WHERE id_cliente = :id_cliente");
        $stmt->execute(['id_cliente' => $id_cliente]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $row = $result;

        if ($row['total'] < 2) {
            header('Location: ../views/novoEndereco.php');
        } else {
            header('Location: ../views/enderecoInseridoFalha.html');
        }

    }

    // Painel Administrativo
    public static function listarCliente() {
        try {
            $conn = Database::getInstance()->getConnection();

            $sql = "SELECT a.id_cliente, a.nome, u.email, u.id_usuario FROM Cliente a INNER JOIN Usuario u ON u.id_usuario = a.id_usuario";
            $stmt = $conn->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
        
    }

    public static function buscarCliente($pesquisa) {
        try {
            $conn = Database::getInstance()->getConnection();

            $pesquisa = "%{$pesquisa}%";
            $sql = "SELECT a.id_cliente, a.nome, u.email, u.id_usuario FROM Cliente a INNER JOIN Usuario u ON u.id_usuario = a.id_usuario WHERE a.id_cliente LIKE :pesquisa OR a.nome LIKE :pesquisa OR u.email LIKE :pesquisa";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':pesquisa' => $pesquisa]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public static function editarCliente($id_cliente, $nome) {
        $conn = Database::getInstance()->getConnection();

        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare('UPDATE cliente SET nome = :nome WHERE id_cliente = :id');
            $stmt->execute(['id' => $id_cliente, 'nome' => $nome]);

            $conn->commit();

            return true;
        } catch(PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public static function remover($id_cliente, $id_usuario) {
        Endereco::deleteEndereco($id_cliente);
        Telefone::deleteTelefone($id_cliente);
        $conn = Database::getInstance()->getConnection();

        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare('DELETE FROM Cliente WHERE id_cliente = :id');
            $stmt->execute(['id' => $id_cliente]);
            
            parent::remover($id_usuario, null);

            $conn->commit();

            return true;
        } catch(PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    // Setters
    public function setCpf($cpf) {  
        // Remove caracteres não numéricos do CPF
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            throw new Exception("CPF inválido: Deve conter 11 dígitos.");
        }

        /*
        // Valida o CPF usando o algoritmo de verificação
        if (!$this->validarCpf($cpf)) {
            throw new Exception("CPF inválido.");
        }
        */

        $this->cpf = $cpf;
    }

    public function setNome($nome) {
        if (preg_match("/^[a-zA-ZÀ-ÿ' -]+$/u", $nome)) {
            $this->nome = $nome;
        } else {
            throw new Exception("Nome inválido");
        }
    }

    public function setDataNasc($dataNasc) {
        $dataNasc = trim($dataNasc);
        $data = DateTime::createFromFormat('Y-m-d', $dataNasc);
        if ($data && $data->format('Y-m-d') === $dataNasc) {
            $this->dataNasc = $dataNasc;
        } else {
            throw new Exception("Data de nascimento inválida");
        }
    }

    public function setSexo($sexo) {
        // Lista de valores válidos para sexo
        $sexosValidos = ['masculino', 'feminino', 'outro'];

        // Verifica se o sexo está na lista de valores válidos
        if (!in_array(strtolower($sexo), $sexosValidos)) {
            throw new Exception("Sexo inválido. Os valores permitidos são 'masculino', 'feminino', 'outro'.");
        }

        $this->sexo = strtolower($sexo);
    }

/*
    private function validarCpf($cpf) {
        // Verifica se todos os dígitos são iguais (CPFs inválidos)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;

    }
*/

    // Getters
    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDataNasc() {
        return $this->dataNasc;
    }

    public function getSexo() {
        return $this->sexo;
    }
}