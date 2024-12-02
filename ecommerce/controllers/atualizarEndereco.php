<?php
session_start();
require_once '../models/Cliente.php';
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

$id_cliente = $_SESSION['id_cliente']; 
$email = $_SESSION['email'];

$clienteObj = new Cliente($email, null);

$dadosEndereco = [  
    'cep' => isset($_POST['cep']) ? filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_NUMBER_INT) : '',
    'rua' => isset($_POST['rua']) ? filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_SPECIAL_CHARS) : '',
    'numero' => isset($_POST['numero']) ? filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT) : '',
    'complemento' => isset($_POST['complemento']) ? filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_SPECIAL_CHARS) : '',
    'bairro' => isset($_POST['bairro']) ? filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_SPECIAL_CHARS) : '',
    'cidade' => isset($_POST['cidade']) ? filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS) : '',
    'estado' => isset($_POST['estado']) ? filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_SPECIAL_CHARS) : '',
    'id_endereco' => isset($_POST['id_endereco']) ? filter_input(INPUT_POST, 'id_endereco', FILTER_SANITIZE_NUMBER_INT) : ''
];

try {
    $clienteObj->atualizarEndereco($id_cliente, $dadosEndereco);
    // Verifica de onde a requisição veio
    $origin = isset($_POST['origin']) ? $_POST['origin'] : '';
    if ($origin === 'entrega') {
        echo '<form id="redirectForm" action="../controllers/checkoutController_antigo.php" method="POST">
                <input type="hidden" name="action" value="entrega">
              </form>
              <script type="text/javascript">
                document.getElementById("redirectForm").submit();
              </script>';
    } else {
        header('Location: ../views/minhaConta.php');
    }
    exit;
} catch (Exception $e) {
    echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral(' . json_encode($e->getMessage()) . ');
          </script>';
}

?>