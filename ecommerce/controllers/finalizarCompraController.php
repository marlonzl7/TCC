<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/tcc/ecommerce/models/Carrinho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tcc/ecommerce/models/Pedido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tcc/ecommerce/models/ItemPedido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tcc/ecommerce/models/Pagamento.php';

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';
echo '<script src="../functions/localStorage.js"></script>';
echo '<script src="../functions/checkout.js"></script>';

$endereco = isset($_POST['endereco']) ? json_decode($_POST['endereco'], true) : null;
$pagamentoData = isset($_POST['pagamento']) ? json_decode($_POST['pagamento'], true) : null;
$metodo = $_POST['pagamentoNome'] ?? null;

/*
// Verificações de log para assegurar que os dados foram decodificados
if ($endereco === null) {
    echo '<script type="module">console.log("Endereço não recebido.");</script>';
} elseif (!is_array($endereco)) {
    echo '<script type="module">console.log("Falha ao decodificar o endereço: ' . htmlspecialchars(json_encode($endereco)) . '");</script>';
} else {
    echo '<script type="module">console.log("Endereço recebido como array:", ' . json_encode($endereco) . ');</script>';
}

if ($pagamentoData === null) {
    echo '<script type="module">console.log("Pagamento não recebido.");</script>';
} elseif (!is_array($pagamentoData)) {
    echo '<script type="module">console.log("Falha ao decodificar o pagamento: ' . htmlspecialchars(json_encode($pagamento)) . '");</script>';
} else {
    echo '<script type="module">console.log("Pagamento recebido como array:", ' . json_encode($pagamento) . ');</script>';
}

if ($metodo === null) {
    echo '<script type="module">console.log("Método de pagamento não recebido.");</script>';
} else {
    echo '<script type="module">console.log("Método de pagamento recebido:", ' . htmlspecialchars($metodo) . ');</script>';
}

var_dump($_POST);
*/

session_start();
$id_cliente = $_SESSION['id_cliente'];

if ($endereco && $pagamentoData && $metodo) {

    $carrinho = new Carrinho($id_cliente);
    $total = $carrinho->calcularTotal();
    $itensCarrinho = $carrinho->exibirItens();

    // Formata o endereço pra armazenar no banco
    $enderecoCompleto = sprintf(
        "%s, %s, %s, %s, %s",
        $endereco['rua'],
        $endereco['numero'],
        $endereco['bairro'],
        $endereco['cidade'],
        $endereco['cep']
    );

    // Criação do pedido
    $pedido = new Pedido(null, $id_cliente, $total, $enderecoCompleto);
    if ($pedido->criarPedido()) {
        $id_pedido = $pedido->getIdPedido();

        // Criação do pagamento
        $pagamento = new Pagamento($id_pedido, $total, $metodo);
        if (!$pagamento->criarPagamento()) {
            echo '<script type="module">
                import {errorGeral} from "../functions/templates.js";
                errorGeral("Falha ao processar o pagamento");
                </script>';
        }
        // Adicionar os itens do carrinho ao pedido
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
            echo "Ta funcionando";
        }

        /*
        // Limpar carrinho e redirecionar
        if ($carrinho->limpar($id_cliente)) {
            
        } else {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Falha ao limpar o carrinho");
            </script>';   
        }
        */
    } else {
        echo '<script type="module">
        import {errorGeral} from "../functions/templates.js";
        errorGeral("Falha ao criar o pedido");
        </script>';   
    }
} else {
    echo '<script type="module">
    import {errorGeral} from "../functions/templates.js";
    errorGeral("Erro ao receber dados do LocalStorage.");
    </script>';
}