<?php

require_once '../models/Carrinho.php';
require_once '../includes/menu.php';

// Verifica se o cliente está logado
if (isset($_SESSION['id_cliente'])) {
    $id_cliente = $_SESSION['id_cliente'];
    $carrinho = new Carrinho($id_cliente);

    //Obtem os itens do carrinho
    $itens = $carrinho->exibirItens();
    $total = $carrinho->calcularTotal();
} else {
    header("Location: ../views/carrinhoAcessoNegado.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/estilo/carrinho.css">
  <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
  <title>Carrinho de Compras</title>
</head>
<body>
  <h2>Carrinho de Compras</h2>
  <div class="container">
    <?php if (empty($itens)) : ?>
      <?php 
        header("Location: ../views/carrinhoVazio.php");
        exit;
      ?>
    <?php else : ?>
    <div class="cart-items">
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço unitário</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody id="itensCarrinho">
            <?php include '../views/carrinhoItens.php'; ?>
        </tbody>
    </table>
    </div>
    <?php endif; ?>

    <div class="cart-summary">
      <h3>Resumo do Carrinho</h3>
      <table class="summary-table">
        <tbody>
          <tr>
            <td>Total:</td>
            <td class="total">R$ <span id="total"><?= number_format($total, 2, ',', '.') ?></span></td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="buttons">
                <a href="../views/index.php" id="continuar" class="continuar">Continuar comprando</a>
                <form action="../controllers/checkoutController_antigo.php" method="post">
                  <button type="submit" name="action">Finalizar Compra</button>
                  <!--<button type="submit" name="iniciarCheckout">Finalizar Compra</button>-->
                </form>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <script src="../functions/carrinho.js"></script>
</body>
</html>