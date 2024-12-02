<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/functions/auth.php'); 
verificarSessao('administrador');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/tcc/ecommerce/admin/assets/estilo/cadastroAdminSucesso.css">
    <link rel="shortcut icon" href="/TCC/ecommerce/assets/images/favicon/bag-icon-2.svg" type="image/svg+xml">
    <title>Document</title>
</head>
<body>
    <main>
        <img src="/tcc/ecommerce/assets/images/icons/check-icon.svg" alt="">
        <div class="text">
            <h1>Parabéns</h1>
            <p>Um novo administrador foi cadastrado</p>
        </div>
        <a href="/tcc/ecommerce/admin/views/painelAdministrativo/administradores.php">Fechar</a>
    </main>
</body>
</html>