<?php

require_once '../includes/menu.php';
require_once '../models/Cliente.php';
require_once '../models/Pedido.php';

// Verifica se o cliente está logado
if (!isset($_SESSION['id_usuario']) && !isset($_SESSION['tipo']) && $_SESSION['tipo'] !== 'cliente') {
    header('Location: index.php');
    exit;
}

ini_set('display_errors', 1); 
ini_set('log_errors', 1);     
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if (isset($_SESSION['id_usuario']) && isset($_SESSION['tipo']) && isset($_SESSION['tipo']) == 'cliente') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_cliente = $_SESSION['id_cliente'];
    $email = $_SESSION['email'];
    $cliente = new Cliente($email, null);
    $dados = $cliente->listarDados($id_usuario);
    $enderecoPrincipal = $cliente->enderecoPrincipal($id_cliente);
    $enderecoSecundario = $cliente->enderecoSecundario($id_cliente);
    $telefone = $cliente->telefone($id_cliente);
} else {
    echo "Cliente não encontrado.";
}
$id_pedido = $_POST['id_pedido'];
$ItensPedido = new Pedido();
$ItensPedido = $ItensPedido->listarItensPedido($id_pedido);
$enderecoPedido = new Pedido();
$enderecoPedido = $enderecoPedido->enderecoPedido($id_cliente, $id_pedido);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/estilo/carrinho.css">
  <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
  <title>Visualizar Pedido</title>
</head>
<body>
  <h2>Visualizar Pedido</h2>
  <div class="container">
    <div class="cart-items">
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço unitário</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody id="itensCarrinho">
        <?php foreach ($ItensPedido as $ItensPedido) : ?>
            <tr data-produto-id="<?= htmlspecialchars($ItensPedido['id_produto']) ?>">
                <td class="product">
                    <img src="<?= htmlspecialchars($ItensPedido['url']) ?>" alt="Imagem do produto" class="product-image">
                    <div class="product-desc">
                        <p><?= htmlspecialchars($ItensPedido['nome']) ?></p>
                        <p class="categoria"><?= htmlspecialchars($ItensPedido['nome_categoria']) ?></p>
                    </div>
                </td>
                <td class="preco">R$ <?= number_format($ItensPedido['preco_unitario'], 2, ',', '.') ?></td>
                <td>
                    <div class="quantity-buttons">
                        <span class="quantity"><?= htmlspecialchars($ItensPedido['quantidade']) ?></span>
                    </div>
                </td>
                <td>
                    <div class="preco">R$ <?= number_format($ItensPedido['subtotal'], 2, ',', '.') ?></div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>         
    <div class="entrega">
        <h3 style = "display: flex; gap: 10px; margin-bottom: 10px">
            <img src="../admin/assets/images/icons/location-icon.svg">
            Dados da Entrega
        </h3>
        <div class="itens">
            <?php
                if (!empty($enderecoPedido)) {
                    echo '<p>' . 'Destinatário: ' . htmlspecialchars($dados['nome'], ENT_QUOTES, 'UTF-8') . '</p>';
                    echo '<p>' . 'Endereço: ' . $enderecoPedido['rua'] . ', N° ' . $enderecoPedido['numero'] . '</p>';
                    echo '<p>' . 'CEP: ' . $enderecoPedido['cep'] . '</p>';
                } else {
                    echo "Erro ao obter o endereço.";
                }
            ?>
        </div>
    </div>
  </div>
</body>
</html>