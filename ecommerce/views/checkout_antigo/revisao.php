<?php
$carrinho = new Carrinho($id_cliente);
$itens = $carrinho->exibirItens();
$total = $carrinho->calcularTotal();
$ids_produtos = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TCC/ecommerce/assets/estilo/checkout-revisao.css">
    <title>Document</title>
</head>
<body>
    <main>
        <div class="head">
            <h2>Revisão do pedido</h2>
            <img src="/TCC/ecommerce/assets/checkout/checkout-revisão.png" alt="">
        </div>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($itens)) : ?>
                    <?php foreach ($itens as $item) : ?>
                        <tr>
                            <td class="item">
                                <img src="<?= htmlspecialchars($item['url']) ?>" alt="Imagem do produto">
                                <div class="desc-produto">
                                    <p><?= htmlspecialchars($item['nome']) ?></p>
                                    <p><?= htmlspecialchars($item['nome_categoria']) ?></p>
                                </div>
                            </td>
                            <td>
                                <?= number_format($item['subtotal'], 2, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2" class="table-content">Nenhum produto encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="total">
            <span>Total do Pedido:</span>
            <span><?= number_format($total, 2, ',', '.') ?></span>
        </div>
        <form action="/TCC/ecommerce/controllers/checkoutController_antigo.php" method="post">
            <input type="hidden" name="action" value="finalizar">
            <div class="button">
                <button type="submit">
                    Finalizar Compra
                </button>
            </div>
        </form>
    </main>
</body>
</html>