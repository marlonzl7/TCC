<?php
require_once '../views/novoEndereco.php';
require_once '../models/Cliente.php';
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

$id_cliente = $_SESSION['id_cliente'];
$email = $_SESSION['email'];
$tipo = 'Secundário';

$clienteObj = new Cliente($email, null);

$rua = $_POST['rua'];
$cep = $_POST['cep'];
$complemento = $_POST['complemento'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$uf = $_POST['uf'];

// Verifica se os parâmetros obrigatórios estão preenchidos
if (empty($rua) || empty($numero) || empty($bairro) || empty($cidade) || empty($uf)) {
    // Redireciona para a página caso algum dos parâmetros obrigatórios esteja vazio
    echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Insira todos os dados corretamente!");
          </script>';
} else {
    // Se todos os parâmetros estiverem preenchidos, cria o objeto Endereco
    $endereco = new Endereco($id_cliente, $rua, $numero, $complemento, $bairro, $cidade, $uf, $cep);
    // Tenta cadastrar o endereço
    if ($endereco->cadastrar($tipo)) {
        header('Location: ../views/enderecoInseridoSucesso.html');
    } else {
        header('Location: ../views/erroInserirEndereco.html');
    }
}

?>