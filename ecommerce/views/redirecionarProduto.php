<?php
session_start();
if (isset($_GET['produto_id'])) {
    $_SESSION['produto_id'] = $_GET['produto_id'];
    header('Location: ../views/infoProduto.php');
    exit();
}