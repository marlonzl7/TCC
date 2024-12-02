<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menuSimples.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Pedido.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Produto.php'); 

$id_pedido = filter_input(INPUT_POST, 'id_pedido', FILTER_SANITIZE_NUMBER_INT);
$pedidoCompleto = Pedido::visualizarPedidoCompleto($id_pedido);
$endereco = Pedido::enderecoPedidoAdm($id_pedido);

//var_dump($pedidoCompleto);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/estilo/visualizarPedido.css">
    <title>Document</title>
</head>
    <main>
        <div class="container">
            <h1 id="id-pedido">ID do pedido: <?php echo htmlspecialchars($pedidoCompleto[0]['id_pedido']); ?></h1>
            <div class="dados">
                <div class="dados-pedido">
                    <div class="dados-pedido-head">
                        <img src="../../assets/images/icons/cart-icon.svg" alt="">
                        <h2>Dados do pedido</h2>
                    </div>
                    <div class="itens">
                        <p><span>Data:</span> <?php echo htmlspecialchars($pedidoCompleto[0]['data_pedido']); ?></p>
                        <p><span>Situação:</span> <?php echo htmlspecialchars($pedidoCompleto[0]['status']); ?></p>
                    </div>
                </div>
                <div class="dados-entrega">
                    <div class="dados-pedido-head">
                        <img src="../../assets/images/icons/location-icon.svg" alt="">
                        <h2>Endereço de entrega</h2>
                    </div>
                    <div class="itens">
                        <p><span>Destinatário:</span> <?php echo htmlspecialchars($pedidoCompleto[0]['nome']); ?></p>
                        <p><span>Endereço: </span><?php echo htmlspecialchars($endereco['rua']) . " Nº "; echo htmlspecialchars($endereco['numero']);?></p>
                        <p><span>CEP: </span><?php echo htmlspecialchars($endereco['cep']); ?></p>
                    </div>
                </div>
            </div>
            <div class="itens-pedido">
                <h2>Itens do Pedido</h2>
                <table class="tabela-itens-pedido">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço unitário</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidoCompleto as $pedido) : ?>
                            <?php $produto = new Produto($pedido['id_produto']); ?>
                            <?php $nomeProduto = $produto->getNome(); ?>
                            <tr>
                                <td><?php echo htmlspecialchars($nomeProduto) ?></td>
                                <td>R$ <?php echo number_format($pedido['preco_unitario'], 2, ',', '.') ?></td>
                                <td><?php echo htmlspecialchars($pedido['quantidade']) ?></td>
                                <td>R$ <?php echo number_format($pedido['subtotal'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="total-pedido">
                    <p>Total do pedido: <?php echo number_format($pedidoCompleto[0]['total'], 2, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>