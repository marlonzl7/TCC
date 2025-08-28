<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Administrador.php');

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idAdminEditar = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nome = htmlspecialchars(filter_input(INPUT_POST, 'nome', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');

    if (Administrador::editarAdministrador($idAdminEditar, $nome)) {
        header("Location: ../views/painelAdministrativo/administradores.php");
    } else {
        echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao editar adminsitrador");
            </script>';
    }
}
