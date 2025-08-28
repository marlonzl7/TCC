<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Produto.php');
        $produtos = Produto::listarProdutos();
        foreach ($produtos as $produto) {
            echo $produto->getUrl();
            echo "";
        }
    ?>
</body>
</html>