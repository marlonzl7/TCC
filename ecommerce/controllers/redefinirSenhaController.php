<?php

require_once '../models/UsuarioFactory.php';

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$nova_senha = filter_input(INPUT_POST, 'new_password', FILTER_DEFAULT);

$usuario = UsuarioFactory::criarUsuario($email);

if ($usuario->redefinir_senha($nova_senha)) {
    header("Location: ../views/login.html");
    exit();
}else{  

    echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro na passagem de dados!");
            </script>';

}

?>