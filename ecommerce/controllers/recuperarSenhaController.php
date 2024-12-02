<?php

require_once '../models/UsuarioFactory.php';
require_once '../functions/enviarEmailRecuperacao.php';

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$usuario = UsuarioFactory::criarUsuario($email);
$linkRecuperacao = "localhost/tcc/ecommerce/views/redefinir_senha.php?email=$email";

if ($usuario->verificar($email)) {
    $id = $usuario->getIdUsuario();
    if (enviarEmailRecuperacao($email, $linkRecuperacao)) {
        header('Location: ../views/recuperacaoSolicitada.html');
    }
} else {
    echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Não foi possivel enviar o e-mail de recuperação";
            </script>';
}
?>