<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Usuario.php');

class Administrador extends Usuario {
    private $id_admin;
    private $nome;

    // construct
    public function __construct($email, $senha, $nome = null) {
        parent::__construct($email, $senha, 'administrador');

        if ($nome !== null) {
            $this->setNome($nome);
        }
    }

    // Método principal
    public function cadastrar() {
        // Inicia transação
        $this->conn->beginTransaction();

        try {
            // Insere um novo Usuario no banco
            parent::cadastrar();

            // Insere novo Administrador no banco
            $stmt = $this->conn->prepare('INSERT INTO Administrador (id_usuario, nome) VALUES (:id_usuario, :nome)');
            $stmt->execute(['id_usuario' => $this->getIdUsuario(), 'nome' => $this->nome]);
            
            // Confirma transação
            $this->conn->commit();

            return true;
        } catch (PDOException $e) {
            // Reverte a transação em caso de erro
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function logar($email, $senha) {
        try {
            // Verifica se a autenticação foi bem-sucedida
            if (parent::logar($email, $senha)) {
                // Se autenticação bem-sucedida pega o id_admin e o nome do usuário relacionado ao id_usuario armazenado quando a autenticação foi feita
                $stmt = $this->conn->prepare('SELECT id_admin, nome FROM Administrador WHERE id_usuario = :id_usuario');
                $stmt->execute(['id_usuario' => $this->id_usuario]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $this->id_admin = $user['id_admin'];
                    $this->nome = $user['nome'];
                    return true;
                }
            } else {
                return false;
            }
        } catch(PDOException $e) {
            throw $e;
        }
    }

    // Funcionalidades do Painel Administrativo
    public static function listarAdministradores() {
        try {
            $conn = Database::getInstance()->getConnection();

            $sql = "SELECT a.id_admin, a.nome, u.email, u.id_usuario FROM Administrador a INNER JOIN Usuario u ON u.id_usuario = a.id_usuario";
            $stmt = $conn->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
        
    }

    public static function buscarAdministrador($pesquisa) {
        try {
            $conn = Database::getInstance()->getConnection();

            $pesquisa = "%{$pesquisa}%";
            $sql = "SELECT a.id_admin, a.nome, u.email, u.id_usuario FROM Administrador a INNER JOIN Usuario u ON u.id_usuario = a.id_usuario WHERE a.id_admin LIKE :pesquisa OR a.nome LIKE :pesquisa OR u.email LIKE :pesquisa";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':pesquisa' => $pesquisa]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public static function editarAdministrador($id_admin, $nome) {
        $conn = Database::getInstance()->getConnection();

        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare('UPDATE Administrador SET nome = :nome WHERE id_admin = :id');
            $stmt->execute(['id' => $id_admin, 'nome' => $nome]);

            $conn->commit();

            return true;
        } catch(PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public static function remover($id_admin, $id_usuario) {
        $conn = Database::getInstance()->getConnection();

        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare('DELETE FROM Administrador WHERE id_admin = :id');
            $stmt->execute(['id' => $id_admin]);
            
            parent::remover($id_usuario, null);

            $conn->commit();

            return true;
        } catch(PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public static function infoAdministrador($id_admin) {
        try {
            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare('SELECT a.id_admin, a.nome, u.email, u.id_usuario FROM Administrador a INNER JOIN Usuario u ON u.id_usuario = a.id_usuario WHERE a.id_admin = :id');
            $stmt->execute(['id' => $id_admin]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    // setters
    public function setIdAdmin($id) {
        $this->id_admin = $id;
    }

    public function setNome($nome) {
        $nome = trim($nome);

        if (empty($nome) || strlen($nome) < 2) {
            throw new Exception("Nome inválido: Deve conter pelo menos 2 caracteres");
        }

        $this->nome = $nome;
    }
    
    // getters
    public function getIdAdmin() {
        return $this->id_admin;
    }
    
    public function getNome() {
        return $this->nome;
    }
}