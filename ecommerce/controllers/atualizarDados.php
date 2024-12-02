<?php
session_start();
require_once '../models/Cliente.php';
require_once '../models/Telefone.php';

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

$id_usuario = $_SESSION['id_usuario'];
$id_cliente = $_SESSION['id_cliente']; 
$email = $_SESSION['email'];

$clienteObj = new Cliente($email, null);

$dadosCliente = [
    'cpf' => isset($_POST['cpf']) ? filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT) : '',
    'nome' => isset($_POST['nome']) ? filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS) : '',
    'data_nasc' => isset($_POST['data-nascimento']) ? filter_input(INPUT_POST, 'data-nascimento', FILTER_DEFAULT) : '',
    'sexo' => isset($_POST['sexo']) ? filter_input(INPUT_POST, 'sexo', FILTER_DEFAULT) : '',
    'numero' => isset($_POST['numero_tel']) ? filter_input(INPUT_POST, 'numero_tel', FILTER_SANITIZE_NUMBER_INT) : ''
];

$email = isset($_POST['email']) ? filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) : '';

try {
    $clienteObj->atualizarDadosCliente($id_usuario, $id_cliente, $dadosCliente, ['email' => $email]);
    $telefoneObj = new Telefone($id_cliente, $dadosCliente['numero']);
    $telefoneObj->atualizarTelefone($id_cliente, $dadosCliente['numero']);
    // Verifica de onde a requisição veio
    $origin = isset($_POST['origin']) ? $_POST['origin'] : '';
    if ($origin === 'checkout') {
        header('Location: ../controllers/checkoutController_antigo.php'); // Redireciona para o checkout
    } else {
        header('Location: ../views/minhaConta.php'); // Redireciona para a minha conta
    }
    exit;
} catch (Exception $e) {
    echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral(' . json_encode($e->getMessage()) . ');
          </script>';
}
?>