<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/functions/auth.php');
verificarSessao('administrador');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/TCC/ecommerce/admin/assets/estilo/menu.css">
    <link rel="shortcut icon" href="/TCC/ecommerce/assets/images/favicon/bag-icon-2.svg" type="image/svg+xml">
    <title>OneClick - Painel</title>
</head>
<body>
    <header class="menus">
        <nav class="menu">
            <a class="menu-item novo-admin" href="/TCC/ecommerce/admin/views/painelAdministrativo/cadastroAdmin.php">
                <img src="/TCC/ecommerce/admin/assets/images/icons/add-user-icon.svg" alt="">
                <p class="add">Cadastrar novo <br> Administrador</p>
            </a>
            <a class="menu-item" href="/TCC/ecommerce/admin/views/painelAdministrativo/administradores.php">
                <img class="marca-img" src="/TCC/ecommerce/admin/assets/images/icons/Marca.svg" alt="">
            </a>
            <a class="menu-item" href="/TCC/ecommerce/functions/logout.php">
                <img class="sair-img" src="/TCC/ecommerce/admin/assets/images/icons/logout-icon.svg" alt="">
                <p>Sair</p>
            </a>
        </nav>
    </header>
