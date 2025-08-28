<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Cliente.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/functions/utils.php'); 

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

$id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
$email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);

validateRequiredFields([
    'email' => $email,
]);

$cliente = new Cliente($email, null);

if ($cliente->atualizarEmail($id_usuario,$email)) {
    header("Location: /TCC/ecommerce/admin/views/painelAdministrativo/clientes.php");
} else {
    echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao editar cliente");
            </script>';
}
?>