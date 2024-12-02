<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/config/DatabaseConnect.php');

class Endereco extends DatabaseConnect {
    private $id_endereco;
    private $id_cliente;
    private $rua;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $uf;
    private $cep;
    private $tipo;

    // construct
    public function __construct($id_cliente, $rua, $numero, $complemento, $bairro, $cidade, $uf, $cep) {
        parent::__construct();
        $this->id_cliente = $id_cliente;
        $this->setRua($rua);
        $this->setNumero($numero);
        $this->setComplemento($complemento);
        $this->setBairro($bairro);
        $this->setCidade($cidade);
        $this->setUf($uf);
        $this->setCep($cep);
    }

    // Método principal
    public function cadastrar($tipo = null) {
        if ($tipo !== null) {
            $this->setTipo($tipo);
        } else {
            $this->setTipo("Principal");
        }
        
        try {
            // Insere um novo Endereco no banco
            $stmt = $this->conn->prepare('INSERT INTO Endereco (id_cliente, rua, numero, complemento, bairro, cidade, estado, cep, tipo) VALUES (:id_cliente, :rua, :numero, :complemento, :bairro, :cidade, :estado, :cep, :tipo)');
            $stmt->execute([
                'id_cliente' => $this->id_cliente,
                'rua' => $this->rua,
                'numero' => $this->numero,
                'complemento' => $this->complemento,
                'bairro' => $this->bairro,
                'cidade' => $this->cidade,
                'estado' => $this->uf,
                'cep' => $this->cep,
                'tipo' => $this->tipo
            ]);

            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    // Painel Administrativo
    public static function deleteEndereco($id_cliente) {
        $conn = Database::getInstance()->getConnection();

        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare('DELETE FROM Endereco WHERE id_cliente = :id');
            $stmt->execute(['id' => $id_cliente]);

            $conn->commit();

            return true;
        } catch(PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    // setters
    public function setRua($rua) {
        $this->rua = $rua;
    }

    public function setNumero($numero) {
        $numero = trim($numero);
        if (is_numeric($numero) && $numero > 0) {
            $this->numero = $numero;
        } else {
            throw new Exception("Número inválido");
        }
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setUf($uf) {
        $ufsValidas = [
            'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
        ];

        if (!in_array(strtoupper($uf), $ufsValidas)) {
            throw new Exception("UF inválida.");
        }

        $this->uf = $uf;
    }

    public function setCep($cep) {
        $cep = trim($cep);

        if (!preg_match("/^[0-9]{5}-[0-9]{3}$/", $cep)) {
            throw new Exception("CEP inválido. O formato correto é XXXXX-XXX.");
        }

        $this->cep = $cep;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
    // getters
    public function getRua() {
        return $this->rua;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getUf() {
        return $this->uf;
    }

    public function getCep() {
        return $this->cep;
    }
}