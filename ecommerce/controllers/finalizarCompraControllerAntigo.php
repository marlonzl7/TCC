<?php
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/models/Pedido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/models/ItemPedido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/TCC/ecommerce/models/Pagamento.php';

$carrinho = new Carrinho($id_cliente);
$itensCarrinho = $carrinho->exibirItens();
$totalCarrinho = $carrinho->calcularTotal();

$metodoPagamento = $_SESSION['pagamento'];
$id_endereco_entrega = $_SESSION['id_endereco_entrega'];

var_dump($id_endereco_entrega);

$pedido = new Pedido(null, $id_cliente, $totalCarrinho, $id_endereco_entrega);

if ($pedido->criarPedido()) {
    $id_pedido = $pedido->getIdPedido();

    $pagamento = new Pagamento($id_pedido, $totalCarrinho, $metodo);
    if (!$pagamento->criarPagamento()) {
        echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao remover item do carrinho");
            </script>';
    }

    foreach ($itensCarrinho as $item) {
        $itemPedido = new ItemPedido($id_pedido);

        $id_produto = $item['id_produto'];
        $produto = new Produto($id_produto);
        $preco_unitario = $produto->getPreco();
        $quantidade = $item['quantidade'];
        $subtotal = $item['subtotal'];

        if ($itemPedido->adicionarItem($id_produto, $preco_unitario, $quantidade, $subtotal)) {
            if (!$carrinho->removerItem($id_produto)) {
                echo '<script type="module">
                import {errorGeral} from "../functions/templates.js";
                errorGeral("Erro ao remover item do carrinho");
                </script>';
            }
        } else {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Falha ao adicionar itens");
            </script>';
        }
    }

    if (!$carrinho->limpar($id_cliente)) {
        echo '<script type="module">
        import {errorGeral} from "../functions/templates.js";
        errorGeral("Falha ao limpar o carrinho");
        </script>';   
    } else {
        header("Location: ../views/compra-realizada.php");
        exit;
    }

} else {
    echo '<script type="module">
    import {errorGeral} from "../functions/templates.js";
    errorGeral("Falha ao criar o pedido");
    </script>';   
}
