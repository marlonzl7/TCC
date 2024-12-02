<?php require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menuSimples.php'); ?>
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
                <h1>Cadastrar Categoria</h1>
                <p>Preencha os campos abaixo para cadastrar uma nova categoria no sistema</p>
            </div>
            <form action="../../controllers/cadastrarCategoriaController.php" method="post" class="input-container">
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome_categoria">Nome da categoria</label>
                        <input type="text" name="nome_categoria" id="nome_categoria">
                    </div>
                </div>
                <div class="button">
                    <button type="submit" class="btn">Cadastrar</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>