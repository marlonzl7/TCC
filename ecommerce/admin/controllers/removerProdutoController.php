<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Produto.php'); 

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produto = filter_input(INPUT_POST,  'id_produto', FILTER_VALIDATE_INT);

    try {
        if (Produto::removerProduto($id_produto)) {
            header("Location: ../views/painelAdministrativo/produtos.php");
        } else {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao remover produto");
            </script>';
        }
    } catch(Exception $e) {
        // Emite um alerta com a mensagem do erro
        echo '<script type="module">
        import {errorGeral} from "../functions/templates.js";
        errorGeral(' . json_encode($e->getMessage()) . ');
        </script>';
    }
}