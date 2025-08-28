<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menuSimples.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Pedido.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/functions/utils.php'); 

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

$id_pedido = filter_input(INPUT_POST, 'id_pedido', FILTER_SANITIZE_NUMBER_INT);
$status = filter_input(INPUT_POST, 'situacao', FILTER_DEFAULT);

validateRequiredFields(['situação' => $status]);

$pedido = new Pedido($id_pedido);

if ($pedido->alterarStatusPedido($status)) {
    header("Location: /TCC/ecommerce/admin/views/painelAdministrativo/pedidos.php");
} else {
    echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao editar produto");
            </script>';
}
