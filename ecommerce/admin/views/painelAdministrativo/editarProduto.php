<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menuSimples.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Produto.php'); 

$id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);

$produto = new Produto($id_produto);
$infoProduto = $produto->infoProduto($id_produto);

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
            <?php if (empty($infoProduto)) : ?>
                <h3>Produto não encontrado</h3>
            <?php else : ?>
                <div class="head">                
                    <h1>Editar Produto</h1>
                    <p>Altere os campos que deseja editar</p>
                </div>
                <form action="../../controllers/editarProdutoController.php" method="post">
                    <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>">
                    <div class="input-group">
                        <div class="input-box">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($infoProduto['nome'] ?? 'Produto não encontrado'); ?>">
                        </div>
                        <div class="input-box">
                            <label for="descricao">Descrição</label>
                            <input type="text" name="descricao" id="descricao" value="<?php echo htmlspecialchars($infoProduto['descricao'] ?? 'Produto não encontrado'); ?>">
                        </div>
                        <div class="input-box">
                            <label for="preco">Preço</label>
                            <input type="text" name="preco" id="preco" value="<?php echo htmlspecialchars($infoProduto['preco'] ?? 'Produto não encontrado'); ?>">
                        </div>
                        <div class="input-box">
                            <label for="estoque">Estoque</label>
                            <input type="text" name="estoque" id="estoque" value="<?php echo htmlspecialchars($infoProduto['qtd_em_estoque'] ?? 'Produto não encontrado'); ?>">
                        </div>
                        <div class="input-box">
                            <label for="url">Link</label>
                            <input type="text" name="url" id="url" value="<?php echo htmlspecialchars($infoProduto['url'] ?? 'Produto não encontrado'); ?>">
                        </div>
                        <div class="input-categoria">
                            <label for="categoria">Categoria</label>
                            <select name="categoria" id="categoria" required>
                                <option value="Camisa" <?php echo ($infoProduto['nome_categoria'] == 'Camisa') ? 'selected' : ''; ?>>Camisa</option>
                                <option value="Calça" <?php echo ($infoProduto['nome_categoria'] == 'Calça') ? 'selected' : ''; ?>>Calça</option>
                                <option value="Moletom" <?php echo ($infoProduto['nome_categoria'] == 'Moletom') ? 'selected' : ''; ?>>Moletom</option>
                                <option value="Bicicleta" <?php echo ($infoProduto['nome_categoria'] == 'Bicicleta') ? 'selected' : ''; ?>>Bicicleta</option>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
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