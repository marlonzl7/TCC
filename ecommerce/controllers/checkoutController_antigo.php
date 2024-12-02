<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/includes/menuCheckout.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/service/ClientService.php');

$service = new ClientService();

$id_usuario = $_SESSION['id_usuario'];
$id_cliente = $_SESSION['id_cliente'];
$email = $_SESSION['email'];

// Apenas atualiza a sessão se id_endereco estiver presente no POST
if (isset($_POST['id_endereco']) && $_POST['id_endereco'] !== '') {
    $_SESSION['id_endereco_entrega'] = $_POST['id_endereco'];
}

if (isset($_POST['pagamento']) && $_POST['pagamento'] !== '') {
    $_SESSION['pagamento'] = $_POST['pagamento'];
}

// Use a variável da sessão em vez de $_POST para garantir que você não receba uma string vazia
$id_endereco_entrega = $_SESSION['id_endereco_entrega'] ?? '';


$action = $_POST['action'] ?? '';

switch ($action) {
    case 'entrega':
        include $_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/views/checkout_antigo/entrega.php';
        break;
    case 'pagamento':
        include $_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/views/checkout_antigo/pagamento.php';
        break;
    case 'revisao':
        include $_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/views/checkout_antigo/revisao.php';
        break;
    case 'finalizar':
        require_once $_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/controllers/finalizarCompraControllerAntigo.php';
        break;
    default:
        include $_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/views/checkout_antigo/dadosPessoais.php';
        break;
}
