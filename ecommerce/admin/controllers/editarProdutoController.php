<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Produto.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/functions/utils.php'); 

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

$id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);
$nome = htmlspecialchars(filter_input(INPUT_POST, 'nome', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
$descricao = htmlspecialchars(filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
$preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$estoque = filter_input(INPUT_POST, 'estoque', FILTER_SANITIZE_NUMBER_INT);
$url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
$categoria = htmlspecialchars(filter_input(INPUT_POST, 'categoria', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
$colecao = filter_input(INPUT_POST, 'colecao', FILTER_SANITIZE_NUMBER_INT);

validateRequiredFields([
    'nome' => $nome,
    'descricao' => $descricao,
    'preco' => $preco,
    'estoque' => $estoque,
    'url' => $url,
    'categoria' => $categoria,
]);

$produto = new Produto($id_produto, $nome, $descricao, $colecao, $preco, $estoque, $categoria, $url);

if ($produto->editarProduto()) {
    header("Location: /TCC/ecommerce/admin/views/painelAdministrativo/produtos.php");
} else {
    echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao editar produto");
            </script>';
}
?>