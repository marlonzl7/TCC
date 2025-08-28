<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menuSimples.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Cliente.php'); 

$id_cliente = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$cliente = new Cliente($email, null);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/estilo/cadastrarProduto.css">
    <title>Document</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="head">
                <h1>Editar Cliente</h1>
                <p>Altere o email</p>
            </div>
            <form action="../../controllers/editarClienteController.php" method="post">
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Email</label>
                        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
                        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_cliente) ?>">
                    </div>
                </div>
                <div class="button">
                    <button class="btn" type="submit">
                        Editar
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>