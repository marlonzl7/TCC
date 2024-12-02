<?php 
require_once '../functions/auth.php'; 
verificarSessao('cliente');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/estilo/alterarSenha.css">
    <link rel="shortcut icon" href="/TCC/ecommerce/assets/images/favicon/bag-icon-2.svg" type="image/svg+xml">
    <title>Atualizar Senha</title>
</head>
<body>
    <main class="container">
        <header class="title">
            <h2>Atualizar Senha</h2>
            <h3>Preencha os campos abaixo para atualizar sua senha</h3>
        </header>
        <form action="../controllers/atualizarSenhaController.php" method="post">
            <div class="input-group">
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="../assets/images/icons/password-icon.svg" alt="">
                        <label for="senha_atual">Senha Atual</label>
                    </div>
                    <input type="password" name="senha_atual" id="senha_atual">
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="../assets/images/icons/password-icon.svg" alt="">
                        <label for="nova_senha">Nova Senha</label>
                    </div>
                    <input type="password" name="nova_senha" id="nova_senha">
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="../assets/images/icons/password-icon.svg" alt="">
                        <label for="confirmar_nova_senha">Confirmar Senha</label>
                    </div>
                    <input type="password" name="confirmar_nova_senha" id="confirmar_nova_senha">
                </div>
            </div>
            <div class="button">
                <button type="submit">Atualizar Senha</button>
            </div>
        </form>
    </main>
</body>
</html>