<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../assets/estilo/checkout.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OneClick Store</title>
    
</head>


<body>

    <?php
        session_start();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/ecommerce/models/Carrinho.php';

        $id_cliente = $_SESSION['id_cliente'];

        $carrinho = new Carrinho($id_cliente);
        $itens = $carrinho->exibirItens();
        $total = $carrinho->calcularTotal();
        $ids_produtos = [];

    ?>

    <main id="main">

        <header id="header">
            
            <img src="../../admin/assets/images/icons/Marca.svg" id="marca">

        </header>

        <div class="titulo">

            <p class="tituloTexto">Revise os itens da compra</p>

        </div>

        <div class="barra">
            <img src="../../assets/images/checkout/checkout-revisão.png" class="barraIMG">
        </div>

        <form style="font-family: 'Montserrat', sans-serif" action="..\..\controllers\checkoutController.php" method="POST" autocomplete="on">

            <div class = "informacoesFundo">
                <div class="informacoes">

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

                </div>
            </div>

            <div id="caixaBotoes">

                <input type="submit" name="carrinhoRevisaoVoltar" value="Voltar" onclick="salvaPagamentoLocalStorage()" class="btnVoltar">
                <input type="submit" name="carrinho" value="Editar Carrinho" onclick="deletaCamposLocalStorage()"   class="btnPadrao">
                <input type="submit" name= "finalizarCompra" value="Finalizar Compra" onclick="salvaPagamentoLocalStorage()" class="btnProsseguir">   

            </div>

        </form>

    </main>

</body>

</html>