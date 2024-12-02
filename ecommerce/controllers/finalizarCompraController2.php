<?php
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

$carrinho = new Carrinho($id_cliente);
$total = $carrinho->calcularTotal();

$itensCarrinho = $carrinho->exibirItens();

$pedido = new Pedido(null, $id_cliente, $total, $id_endereco_entrega);

if ($pedido->criarPedido()) {
    $id_pedido = $pedido->getIdPedido();
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

    if (!$carrinho->limpar()) {
        echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Falha ao limpar o carrinho");
            </script>';
    } else {
        header("Location: /tcc/ecommerce/views/compra-realizada.php");
        exit;
    }
} else {
    echo '<script type="module">
    import {errorGeral} from "../functions/templates.js";
    errorGeral("Falha ao criar o pedido");
    </script>';   
}