<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/config/DatabaseConnect.php';

abstract class Usuario extends DatabaseConnect {
    protected $id_usuario;
    protected $email;
    private $senha;
    protected $tipo;

    // construct
    public function __construct($email, $senha, $tipo) {
        // Conecta com o banco
        parent::__construct();
        
        $this->setEmail($email);
        $this->setTipo($tipo);

        if ($senha !== null) {
            $this->setSenha($senha);
        }
    }

    // Métodos Principais
    public function cadastrar() {
        // Verifica se o usuário já exise
        if ($this->verificarCadastro($this->getEmail())) {
            throw New Exception("Usuário já cadastrado");
        } else {
            try {
                // Insere na tabela Usuario
                $stmt = $this->conn->prepare('INSERT INTO Usuario (email, senha, tipo) VALUES (:email, :senha, :tipo)');
                $stmt->execute(['email' => $this->email, 'senha' => $this->senha, 'tipo' => $this->tipo]);

                // Obtem o id do usuario (id_usuario)
                $this->id_usuario = $this->conn->lastInsertId();

                return true;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }

    public function logar($email, $senha) {
        try {
            // Verifica se o Usuário existe
            $stmt = $this->conn->prepare('SELECT * FROM Usuario WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($senha, $user['senha'])) {
                // Autenticação bem-sucedida
                $this->id_usuario = $user['id_usuario'];
                $this->email = $user['email'];
                $this->tipo = $user['tipo']; 

                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            throw $e;
        }
    }

    // Verifica se o cliente já está cadastrado
    public function verificarCadastro($email) {
        $stmt = $this->conn->prepare('SELECT email FROM Usuario WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $cadastro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cadastro) {
            return true;
        } else {
            return false;
        }
    }

    // Painel Administrativo - Adm
    public static function remover($id_usuario, $id_admin) {
        try {
            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare('DELETE FROM Usuario WHERE id_usuario = :id');
            $stmt->execute(['id' => $id_usuario]);

            return true;
        } catch(PDOException $e) {
            echo "Erro ao remover usuário: " . $e->getMessage();
        }
    }

    // Recuperar Senha - métodos
    public function verificar($email) {
        try {
            // Pesquisa na tabela Usuario
            $stmt = $this->conn->prepare('SELECT * FROM Usuario WHERE email = :email');
            $stmt->execute(['email' => $email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_usuario = $user['id_usuario'];
            
            return true;
        } catch (PDOException $e) {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral(' . json_encode($e->getMessage()) . ');
            </script>';
        }
    }

    // Redefine a senha - Parte da funcinalidade "Esqueci Senha"
    public function redefinir_senha($nova_senha){
        $this->setSenha($nova_senha);
        try{
            $stmt = $this->conn->prepare('UPDATE Usuario SET senha = :senha WHERE email = :email');
            $stmt->execute(['senha' => $this->senha, 'email' => $this->email]);
            
            return true;
        }catch (PDOException $e){
            echo "Erro ao checar e-mail: " . $e->getMessage();
        }
    }

    // Atualiza a senha - Parte da página Minha Conta
    public function atualizar_senha($senha_atual, $nova_senha) {
        // Busca o usuário pelo email
        $stmt = $this->conn->prepare('SELECT * FROM Usuario WHERE email = :email');
        $stmt->execute(['email' => $this->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se a senha atual fornecida é correta
        if ($user && password_verify($senha_atual, $user['senha'])) {

            // Se a senha atual estiver correta, define a nova senha (transforma em hash)
            $this->setSenha($nova_senha);

            try {
                $this->conn->beginTransaction();

                $stmt = $this->conn->prepare('UPDATE Usuario SET senha = :senha WHERE email = :email');
                $stmt->execute(['email' => $this->email, 'senha' => $this->senha]);

                $this->conn->commit();

                return true;
            } catch(PDOException $e) {
                $this->conn->rollBack();
                throw $e;
            }
        } else {
            throw New Exception("Senha atual incorreta");
        }
    }


    // Setters
    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new Exception("Email Inválido");
        }
    }

    public function setSenha($senha) {
        $senha = trim($senha);
        if (strlen($senha) >= 8) {
            $this->senha = password_hash($senha, PASSWORD_BCRYPT);
        } else {
            throw new InvalidArgumentException("A senha deve ter pelo menos 8 caracteres");
        }
    }

    public function setTipo($tipo) {
        $tipo = strtolower(trim($tipo));
        if (($tipo == 'administrador') || ($tipo == 'cliente')) {
            $this->tipo = $tipo;
        } else {
            throw new Exception("Usuário Inválido");
        }
    }
    // Getters
    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTipo() {
        return $this->tipo;
    }
}