<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Produto.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/functions/utils.php'); 

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_categoria = htmlspecialchars(filter_input(INPUT_POST, 'nome_categoria', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');

    try {
        validateRequiredFields([
            'nome da categoria' => $nome_categoria,
        ]);
    
        if (Produto::cadastrarCategoria($nome_categoria)) {
            header("Location: /TCC/ecommerce/admin/views/painelAdministrativo/produtos.php");
        } else {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao cadastrar categoria");
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