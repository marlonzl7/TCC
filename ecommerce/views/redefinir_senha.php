<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/estilo/redefinir_senha.css" />
    <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
    <title>Redefinição de senha</title>
</head>

<body>
    <main class="container">
            <div class="title">
                <h2>Atualizar Senha</h2>
                <h3>Preencha os campos abaixo para atualizar sua senha</h3>
            </div>
            <!-- update_password.html -->
            <form action="../controllers/redefinirSenhaController.php" method="post">
                <?php
                    if (isset($_GET['email'])) {
                        $email = htmlspecialchars($_GET['email']);
                        echo "<input type='hidden' name='email' value='$email'>"; 
                    } else {
                        throw New Exception("Email não encontrado");
                    } 
                ?>
                <div class="input-group">
                    <div class="input-box">
                        <div class="input-box-label">
                            <img src="../assets/images/icons/password-icon.svg" alt="" />
                            <label for="nova_senha">Nova Senha</label>
                        </div>
                        <input type="password" name="new_password" required />
                    </div>
                    <div class="input-box">
                        <div class="input-box-label">
                            <img src="../assets/images/icons/password-icon.svg" alt="" />
                            <label for="nova_senha">Confirmar Senha</label>
                        </div>
                        <input type="password" name="confirm_password" required />
                    </div>
                </div>
                <div class="senha_button">
                    <button class="btn_senha">Atualizar Senha</button>
                </div>
            </form>
    </main>
</body>

</html>