<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/functions/auth.php';
verificarSessao('cliente');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/estilo/menuCheckout.css">
    <link rel="shortcut icon" href="/TCC/ecommerce/assets/images/favicon/bag-icon-2.svg" type="image/svg+xml">
    <title>Document</title>
</head>
<body>
    <div class="menu-checkout">
        <a href="../views/index.php">
            <img src="../assets/images/icons/Marca-home.svg" alt="">
        </a>
    </div>
</body>
</html>