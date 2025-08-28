<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Produto.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/functions/utils.php'); 
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars(filter_input(INPUT_POST, 'nome', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
    $descricao = htmlspecialchars(filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
    $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT);
    $estoque = filter_input(INPUT_POST, 'estoque', FILTER_SANITIZE_NUMBER_INT);
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
    $categoria = htmlspecialchars(filter_input(INPUT_POST, 'categoria', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
    $colecao = filter_input(INPUT_POST, 'colecao', FILTER_SANITIZE_NUMBER_INT);
    
    try {
        validateRequiredFields([
            'nome' => $nome,
            'descricao' => $descricao,
            'preco' => $preco,
            'estoque' => $estoque,
            'url' => $url,
            'categoria' => $categoria,
        ]);
    
        $produto = new Produto(null, $nome, $descricao, $colecao, $preco, $estoque, $categoria, $url);
    
        if ($produto->cadastrarProduto()) {
            header("Location: /TCC/ecommerce/admin/views/painelAdministrativo/produtos.php");
        } else {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao cadastrar produto");
            </script>';
        }
    } catch(Exception $e) {
        // Emite um alerta com a mensagem do erro
        echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral(' . json_encode($e->getMessage()) . ');
            </script>';
        // O `window.history.back()` faz com que o usuário volte à página anterior
    }
}