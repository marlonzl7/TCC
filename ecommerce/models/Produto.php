<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/config/DatabaseConnect.php');

class Produto extends DatabaseConnect {
    private $id_produto;
    private $nome;
    private $descricao;
    private $colecao;
    private $preco;
    private $quantidade;
    private $categoria;
    private $url;
    
    public function __construct($id_produto = null, $nome = null, $descricao = null, $colecao = null, $preco = null, $quantidade = null, $categoria = null, $url = null) {
        parent::__construct();

        if ($id_produto !== null) {
            $infoProduto = $this->infoProduto($id_produto);
            if ($infoProduto) {
                $this->id_produto = $id_produto;
                $this->setNome($infoProduto['nome']);
                $this->setPreco($infoProduto['preco']);
                $this->setQuantidade($infoProduto['qtd_em_estoque']);
                $this->setCategoria($infoProduto['nome_categoria']);
                $this->setUrl($infoProduto['url']);
                $this->setDescricao($infoProduto['descricao']);
                $this->setColecao($infoProduto['colecao']);
            } else {
                throw new Exception("Produto não encontrado.");
            }
        }

        // Usado no cadastro de produtos para inicializar os atributos
        if (($nome !== null) && ($descricao !== null) && ($preco !== null) && ($quantidade !== null) && ($categoria !== null) && ($url !== null)) {
            $this->setNome($nome);
            $this->setDescricao($descricao);
            $this->setColecao($colecao);
            $this->setPreco($preco);
            $this->setQuantidade($quantidade);
            $this->setCategoria($categoria);
            $this->setUrl($url);
        }
    }

    public static function listarProdutos() {
        try {
            $conn = Database::getInstance()->getConnection();

            $sql = "SELECT * FROM Produto WHERE qtd_em_estoque > 0";
            $produtos = [];
            
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar produtos: " . $e->getMessage();
        }
        return $produtos;
    }

    public function infoProduto($id) {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM Produto WHERE id_produto = :id');
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar informações: " . $e->getMessage();
        }
        return [];
    }

    private function executeQuery($sql, $params) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage();
        }
        return [];
    }

    public function buscarProduto($pesquisa, $preco = null) {
        try {
            $pesquisa = "%{$pesquisa}%";
            $sql = "SELECT * FROM Produto WHERE descricao LIKE :pesquisa and qtd_em_estoque > 0 OR nome LIKE :pesquisa and qtd_em_estoque > 0";
            $params = [':pesquisa' => $pesquisa];

            if (!empty($preco)) {
                $sql .= " ORDER BY preco " . ($preco === 'asc' ? 'ASC' : 'DESC');
            }

            return $this->executeQuery($sql, $params);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function buscarProdutoPorCategoria($filtro, $preco = null) {
        try {
            $filtro = "%{$filtro}%";
            $sql = "SELECT * FROM Produto WHERE nome_categoria LIKE :filtro AND qtd_em_estoque > 0";
            $params = [':filtro' => $filtro];

            if (!empty($preco)) {
                $sql .= " ORDER BY preco " . ($preco === 'asc' ? 'ASC' : 'DESC');
            }

            return $this->executeQuery($sql, $params);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function buscarProdutoPorColecao($colecao, $preco = null) {
        try {
            $colecao = "%{$colecao}%";
            $sql = "SELECT * FROM Produto WHERE colecao LIKE :colecao AND qtd_em_estoque > 0";
            $params = [':colecao' => $colecao];

            if (!empty($preco)) {
                $sql .= " ORDER BY preco " . ($preco === 'asc' ? 'ASC' : 'DESC');
            }

            return $this->executeQuery($sql, $params);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    // Funcionalidades do Painel Administrativo
    public static function listarTodosProdutos() {
        $conn = Database::getInstance()->getConnection();

        try {
            $sql = "SELECT * FROM Produto";
            $stmt = $conn->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public static function buscarTodosProdutos($pesquisa) {
        $conn = Database::getInstance()->getConnection();

        try {
            $sql = "SELECT * FROM Produto WHERE id_produto LIKE :pesquisa OR nome LIKE :pesquisa OR nome_categoria LIKE :pesquisa OR preco LIKE :pesquisa OR colecao LIKE :pesquisa OR qtd_em_estoque LIKE :pesquisa OR descricao LIKE :pesquisa";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':pesquisa' => $pesquisa]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function cadastrarProduto() {
        try {
            $this->conn->beginTransaction();

            $sql = "INSERT INTO Produto (nome_categoria, nome, descricao, preco, colecao, qtd_em_estoque, url) VALUES (:categoria, :nome, :descricao, :preco, :colecao, :estoque, :url)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'categoria' => $this->getCategoria(), 
                'nome' => $this->getNome(), 
                'descricao' => $this->getDescricao(), 
                'preco' => $this->getPreco(), 
                'colecao' => $this->getColecao(), 
                'estoque' => $this->getQuantidade(), 
                'url' => $this->getUrl()
            ]);

            $this->conn->commit();

            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function editarProduto() {
        try {
            $this->conn->beginTransaction();

            $sql = "UPDATE Produto 
                    SET nome = :nome, 
                        nome_categoria = :categoria, 
                        descricao = :descricao, 
                        preco = :preco, 
                        colecao = :colecao, 
                        qtd_em_estoque = 
                        :estoque, url = :url 
                    WHERE id_produto = :id_produto";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'id_produto' => $this->getIdProduto(),
                'categoria' => $this->getCategoria(), 
                'nome' => $this->getNome(), 
                'descricao' => $this->getDescricao(), 
                'preco' => $this->getPreco(), 
                'colecao' => $this->getColecao(), 
                'estoque' => $this->getQuantidade(), 
                'url' => $this->getUrl()
            ]);

            $this->conn->commit();

            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public static function removerProduto($id_produto) {
        $conn = Database::getInstance()->getConnection();
        
        try {
            $conn->beginTransaction();

            $sql = "DELETE FROM Produto WHERE id_produto = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id' => $id_produto]);

            $conn->commit();

            return true;
        } catch(PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public static function cadastrarCategoria($nome) {
        $conn = Database::getInstance()->getConnection();

        try {
            $conn->beginTransaction();

            $sql = "INSERT INTO Categoria (nome_categoria) VALUES (:nome)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['nome' => $nome]);

            $conn->commit();

            return true;
        } catch(PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public static function listarCategorias() {
        try {
            $conn = Database::getInstance()->getConnection();

            $stmt = $conn->prepare("SELECT * FROM Categoria");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    // setters
    public function setNome($nome) {
        if (empty($nome)) {
            throw new Exception("O nome não pode ser vazio.");
        }
        if (strlen($nome) > 100) {
            throw new Exception("O nome não pode exceder 100 caracteres.");
        }
        $this->nome = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
    }
    
    public function setDescricao($desc) {
        if (empty($desc)) {
            throw new Exception("A descrição não pode ser vazia.");
        }
        $this->descricao = htmlspecialchars($desc, ENT_QUOTES, 'UTF-8');
    }
    
    public function setColecao($colecao) {
        $colecoesValidas = [0, 1, 2, 3];
    
        if (!in_array($colecao, $colecoesValidas)) {
            throw new Exception("A coleção fornecida é inválida. As coleções válidas são: 1, 2 e 3.");
        }
    
        $this->colecao = $colecao;
    }

    public function setPreco($preco) {
        if (!is_numeric($preco) || $preco < 0) {
            throw new Exception("O preço deve ser um número válido e não pode ser negativo.");
        }
        $this->preco = filter_var($preco, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
    
    public function setQuantidade($quantidade) {
        if (!is_numeric($quantidade) || $quantidade < 0) {
            throw new Exception("A quantidade deve ser um número válido e não pode ser negativa.");
        }
        $this->quantidade = filter_var($quantidade, FILTER_SANITIZE_NUMBER_INT);
    }
    
    public function setCategoria($categoria) {
        $categoriasDisponiveis = ['Moletom', 'Camisa', 'Calça', 'Bicicleta'];
    
        if (!in_array($categoria, $categoriasDisponiveis)) {
            throw new Exception("A categoria fornecida é inválida. As categorias disponíveis são: Moletom, Camisa, Calça, Bicicleta.");
        }
    
        $this->categoria = $categoria;
    }
    
    public function setUrl($url) {
        // Verifica se a URL é absoluta ou se é uma URL relativa
        if (!filter_var($url, FILTER_VALIDATE_URL) && !preg_match('/^(\/|\.\.\/)/', $url)) {
            throw new Exception("A URL fornecida é inválida.");
        }
        $this->url = filter_var($url, FILTER_SANITIZE_URL);
    }

    // getters
    public function getIdProduto() {
        return $this->id_produto;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getColecao() {
        return $this->colecao;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getUrl() {
        return $this->url;
    }
}
