<?php 
require_once '../functions/auth.php'; 
verificarSessao('cliente');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/estilo/cadastroSucesso.css">
    <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
    <title>Document</title>
</head>
<body>
    <main>
        <img src="../assets/images/icons/check-icon.svg" alt="">
        <div class="text">
            <h1>Obrigado pela confiança!</h1>
            <p>Seu pedido foi realizado, acesse a página "Meus Pedidos" para mais informações</p>
        </div>
        <a href="../views/minhaConta.php" onclick="deletaCamposLocalStorage()">Minha Conta</a>
    </main>
</body>

<script src="/tcc/ecommerce/functions/localStorage.js"></script>

</html>