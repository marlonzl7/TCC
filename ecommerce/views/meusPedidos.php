<?php
require_once '../includes/menu.php';
require_once '../models/Cliente.php';
require_once '../models/Pedido.php';


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
$PedidosTotais = new Pedido();
$PedidosTotais = $PedidosTotais->listarPedidosTotais($id_cliente);

$UltimoPedido = new Pedido();
$UltimoPedido = $UltimoPedido->listarUltimoPedido($id_cliente);
foreach ($UltimoPedido as $pedido) {
    $id_ultimoPedido = $pedido['id_pedido'];
}
$enderecoPedido = new Pedido();
$enderecoPedido = $enderecoPedido->enderecoPedido($id_cliente, $id_ultimoPedido);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/estilo/minhaConta.css">
    <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
    <title>Meus Pedidos</title>
</head>
    <?php
    
    ?>
<body>
    <section class="container">
        <div class="tabs">
            <div class="tab"><a href=minhaConta.php class="link" style="color: #000">Minha Conta</a></div>
            <div class="tab active"><a href=# class="link"></a>Meus Pedidos</div>
        </div>
        <div class="dados">
                <h2 style="padding-bottom: 20px">
                Último Pedido
                </h2>
            <div class="dados_pedido" style = "display: flex; gap: 200px;">
                <div class="pedido">
                    <h3 style = "display: flex; gap: 10px; margin-bottom: 10px">
                        <img src="../admin/assets/images/icons/cart-icon.svg">
                        Dados do pedido
                    </h3>
                    <div class="itens">
                        <?php
                        if (!empty($UltimoPedido)) {
                            foreach ($UltimoPedido as $UltimoPedido) {
                                echo "<p>Status: " . ($UltimoPedido['status']) . "</p>";
                                echo "<p>Data: " . htmlspecialchars($UltimoPedido['data_pedido'] ?? '') . "</p>";
                                echo "<p>Total: " . number_format($UltimoPedido['total'] ?? 0, 2, ',', '.') . "</p>";
                            }
                        } else {
                            echo "<p>Nenhum pedido encontrado.</p>";
                        }
                        ?>
                    </div>
                    <div style="padding-top: 20px">
                        <?php
                        if (!empty($UltimoPedido)) {
                            echo '<form action="Pedidovisualizar.php" method="post" target="_blank">
                            <button class="button-pedidos" type="submit">Visualizar Pedido Completo</button>
                            <input type="hidden" name="id_pedido" value="' . htmlspecialchars($UltimoPedido['id_pedido']) . '" />
                            </form>';
                        } else {
                            echo "<btton class='button-pedidos' disabled style='cursor: not-allowed; opacity: 0.6;'>Visualizar Pedido Completo</button>";
                        }
                        ?>
                    </div>
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
            <div class="historico" style="padding-top: 20px">
                <h2 style = "margin-bottom: 20px">
                    Histórico de pedidos
                </h2>
                <table>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Situação
                        </th>
                        <th>
                            Data
                        </th>
                        <th>
                            Valor
                        </th>
                        <th>
                            Visualizar
                        </th>
                    </tr>
                    <?php
                    // Loop para exibir todos os pedidos
                    if (!empty($PedidosTotais)) {
                        foreach ($PedidosTotais as $pedido) {
                            echo 
                            '<tr>
                                <td>' . htmlspecialchars($pedido['id_pedido']) . '</td>
                                <td>' . htmlspecialchars($pedido['status']) . '</td>
                                <td>' . htmlspecialchars($pedido['data_pedido']) . '</td>
                                <td>' . number_format($pedido['total'], 2, ',', '.') . '</td>
                                <td>
                                    <form action="Pedidovisualizar.php" method="post" target="_blank">
                                        <button class="btn-view" type="submit"><img src="../admin/assets/images/icons/view-icon-fill.svg"></button>
                                        <input type="hidden" name="id_pedido" value="' . htmlspecialchars($pedido['id_pedido']) . '" />
                                    </form>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">Sem historico de pedidos.</td></tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>



