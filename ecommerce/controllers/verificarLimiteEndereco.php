<?php
require_once '../models/Cliente.php';
session_start();

$id_cliente = $_SESSION['id_cliente'];
$email = $_SESSION['email'];

$cliente = new Cliente($email, null);

$cliente = $cliente->limitarEndereco($id_cliente);

?>