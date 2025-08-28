<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menuSimples.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Pedido.php'); 

$id_pedido = filter_input(INPUT_POST, 'id_pedido', FILTER_SANITIZE_NUMBER_INT);
$situacao = Pedido::obterStatusPedido($id_pedido);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/estilo/cadastrarProduto.css">
    <link rel="stylesheet" href="../../assets/estilo/editarPedido.css">
    <title>Document</title>
</head>
<body>
    <main>
        <div class="container">
            <?php if (empty($id_pedido)) : ?>
                <h3>Pedido não encontrado</h3>
            <?php else : ?>
                <div class="head">                
                    <h1>Editar Pedido</h1>
                    <p>Preencha o campo necessário para editar a situação do pedido</p>
                </div>
                <form action="../../controllers/editarPedidoController.php" method="post">
                    <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($id_pedido); ?>">
                    <div class="input-situacao">
                        <label for="situacao">Situação</label>
                        <select name="situacao" id="situacao" required>
                            <option value="aguardando pagamento" <?php echo ($situacao['status'] === 'aguardando pagamento') ? 'selected' : ''; ?> >Aguardando pagamento</option>
                            <option value="processando" <?php echo ($situacao['status'] === 'processando') ? 'selected' : ''; ?> >Processando</option>
                            <option value="em separação" <?php echo ($situacao['status'] === 'em separação') ? 'selected' : ''; ?> >Em separação</option>
                            <option value="a caminho" <?php echo ($situacao['status'] === 'a caminho') ? 'selected' : ''; ?> >A caminho</option>
                            <option value="entregue" <?php echo ($situacao['status'] === 'entregue') ? 'selected' : ''; ?> >Entregue</option>
                            <option value="cancelado" <?php echo ($situacao['status'] === 'cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                        </select>
                    </div>
                    <div class="button">
                        <button type="submit">
                            Alterar
                        </button>
                    </div>
            <?php endif; ?>
            </form>
        </div>
    </main>
</body>
</html>