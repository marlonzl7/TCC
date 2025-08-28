<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/functions/auth.php'); 
verificarSessao('administrador');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TCC/ecommerce/admin/assets/estilo/cadastroAdmin.css">
    <link rel="shortcut icon" href="/TCC/ecommerce/assets/images/favicon/bag-icon-2.svg" type="image/svg+xml">
    <title>Document</title>
</head>
<body>
    <main class="container">
        <div class="titulo">
            <h1>Cadastro de Administrador</h1>
            <p>Preencha os campos abaixo para registrar um novo administrador no sistema.</p>
        </div>
            <form action="/TCC/ecommerce/admin/controllers/cadastroAdminController.php" method="post">
                <div class="input-group">
                    <div class="input-box">
                        <label for="">Nome</label>
                        <input type="text" name="nome">
                    </div>
                    <div class="input-box">
                        <label for="">Email</label>
                        <input type="email" name="email">
                    </div>
                    <div class="input-box">
                        <label for="">Senha</label>
                        <input type="password" name="senha">
                    </div>
                </div>
                <div class="btn">
                    <button type="submit">Cadastrar</button>
                </div>
        </form>
    </main>
</body>
</html>