<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Cliente.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Endereco.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Telefone.php');

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idClienteRemover = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
    $idUsuarioRemover = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);

    try {
        if (Cliente::remover($idClienteRemover, $idUsuarioRemover)) {
            header("Location: ../views/painelAdministrativo/clientes.php");
            exit();
        } else {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao remover cliente");
            </script>';
        }
    } catch (Exception $e) {
        // Emite um alerta com a mensagem do erro
        echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral(' . json_encode($e->getMessage()) . ');
            </script>';
    }
}