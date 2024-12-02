<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menuSimples.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Produto.php');

$categorias = Produto::listarCategorias();

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
                <h1>Cadastrar Produto</h1>
                <p>Preencha os campos abaixo para cadastrar um novo produto no sistema</p>
            </div>
            <form action="../../controllers/cadastrarProdutoController.php" method="post" class="input-container">
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" required>
                    </div>
                    <div class="input-box">
                        <label for="descricao">Descrição</label>
                        <input type="text" name="descricao" id="descricao" required>
                    </div>
                    <div class="input-box">
                        <label for="preco">Preço</label>
                        <input type="number" step="0.01" name="preco" id="preco" required>
                    </div>
                    <div class="input-box">
                        <label for="estoque">Estoque</label>
                        <input type="number" name="estoque" id="estoque" required>
                    </div>
                    <div class="input-box">
                        <label for="url">Link</label>
                        <input type="text" name="url" id="url" required>
                    </div>
                    <div class="input-categoria">
                        <label for="categoria">Categoria</label>
                        <select name="categoria" id="categoria" required>
                            <?php if (!empty($categorias)) : ?>
                                <?php foreach($categorias as $categoria) : ?>
                                    <option value="<?php echo htmlspecialchars($categoria['nome_categoria']); ?>"><?php echo htmlspecialchars($categoria['nome_categoria']); ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="0">Nehuma categoria disponível</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="input-colecao">
                        <label for="colecao">Se encaixa em algum tipo de coleção?</label>
                        <div class="input-colecao-item">
                            <input type="radio" name="colecao" id="moletons" value="1">
                            <label for="moletons">Moletons</label>
                        </div>
                        <div class="input-colecao-item">
                            <input type="radio" name="colecao" id="camisas" value="2">
                            <label for="camisas">Camisas</label>
                        </div>
                        <div class="input-colecao-item">
                            <input type="radio" name="colecao" id="calcas" value="3">
                            <label for="calcas">Calças</label>
                        </div>
                        <div class="input-colecao-item">
                            <input type="radio" name="colecao" id="nenhum" value="0">
                            <label for="nenhum">Nenhum</label>
                        </div>
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