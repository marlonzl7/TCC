<?php
require_once '../models/Produto.php';

$produtos = Produto::listarProdutos();

?>
<?php require_once '../includes/menu.php'; ?>
    <head>
        <link rel="stylesheet" href="../assets/estilo/menu.css">
        <link rel="stylesheet" href="../assets/estilo/index.css">
    </head>
    <section>
        <?php if (empty($produtos)) : ?>
            <h2 class="produtos-indisponiveis">Nenhum produto disponível</h2>
        <?php else : ?>
        <div class="produtos">
            <?php foreach ($produtos as $produto): ?>
                <a class="produto" href="../views/infoProduto.php?id=<?php echo htmlspecialchars($produto['id_produto']); ?>">
                    <img src="<?php echo htmlspecialchars($produto['url']); ?>" alt="">
                    <p class="titulo-produto"><?php echo htmlspecialchars($produto['nome']); ?></p>
                    <p class="preco-produto">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                    <p class="parcela">em até <span>6x</span> de <span>R$ <?php echo Number_format($produto['preco']  / 6, 2, ",", ".");?></span></p>
                </a>            
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
    </section>
<?php require_once '../includes/rodape.php'; ?>
</body>
</html>