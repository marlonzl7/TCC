<?php
require_once '../includes/menu.php';
require_once '../models/Produto.php';
require_once '../models/Carrinho.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['id'])) {
    $id_produto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $produto = new Produto();
    $infoProduto = [];

    if (!empty($id_produto)) {
        $infoProduto = $produto->infoProduto($id_produto);

        // Solução horrível, mas é oq tem pra hj
        if ($infoProduto['qtd_em_estoque'] < 1) {
            $infoProduto = null;
        }
    }
}
?>
    <head>
        <link rel="stylesheet" href="../assets/estilo/infoProduto.css">
        <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
    </head>
    <section>
        <div class="produto">
            <div class="column1">
                <img src="<?php echo htmlspecialchars($infoProduto['url'] ?? 'Produto não encontrado'); ?>" alt="">
            </div>
            <div class="column2">
                <h2><?php echo htmlspecialchars($infoProduto['nome'] ?? 'Produto não encontrado'); ?></h2>
                <p class="entregue">Vendido e entregue por: <span>One Click e-commerce</span></p>
                <div class="pagamento">
                    <p class="preco">R$ <?php echo htmlspecialchars(number_format($infoProduto['preco'], 2, ',', '.') ?? '0.00'); ?></p> 
                    <p class="parcela">em até <span>6x</span> de <span>R$ <?php echo Number_format($infoProduto['preco']  / 6, 2, ",", ".");?></span></p>
                </div>
                <div class="button">
                    <form action="../controllers/carrinhoController.php" method="post">
                    <input type="hidden" name="id_produto" value="<?php echo htmlspecialchars($infoProduto['id_produto']); ?>">
                    <input type="hidden" name="acao" value="adicionar">
                        <button class="btn">ADICIONAR
                            <img src="../assets/images/icons/add_shopping_cart_24dp_E8EAED_FILL1_wght400_GRAD0_opsz24 1.svg" alt="">
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php require_once '../includes/rodape.php'; ?>
</body>
</html>