<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Carrinho.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id_usuario']) && $_SESSION['tipo'] == 'cliente') {
    $url = '../views/minhaConta.php';
    $text = 'Minha <br> Conta';

    $id_cliente = $_SESSION['id_cliente'];
    $carrinho = new Carrinho($id_cliente);
    $total = $carrinho->calcularTotal();
} else {
    $url = '../views/login.html';
    $text = 'Entre ou <br> Cadastre-se';
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/estilo/pesquisa.css">
    <link rel="shortcut icon" href="/TCC/ecommerce/assets/images/favicon/bag-icon-2.svg" type="image/svg+xml">
    <script src="../functions/script_pesquisa.js"></script>
    <title>OneClick Store</title>
</head>
<body>
    <header class="menus">
        <nav class="menu">
            <a href="index.php">
                <img src="../assets/images/icons/Marca-home.svg" alt="">
            </a>
            <form class="busca" action="pesquisa.php" method="get">
                <input type="search" name="busca" id="busca" placeholder="O que deseja encontrar?" value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
            </form>
            <div class="nav">
                <a class="nav-itens" href="<?php echo $url ?>">
                    <img src="../assets/images/icons/user-icon.svg" alt="">
                    <p><?php echo $text ?></p>
                </a>
                <a class="nav-itens" href="../views/carrinho.php">
                    <img src="../assets/images/icons/cart-icon.svg" alt="">
                    <p>Meu Carrinho <br>R$ <span id="menu-total"><?php if(!empty($total)){ echo number_format($total, 2, ',', '.'); } else { echo "0,00"; } ?></span></p>
                </a>
            </div>
        </nav>
        <nav class= "dp-menu">
            <ul>
                <li><a href="#">Coleções</a>
                    <ul>
                        <li><a href="pesquisa.php?filtro=&busca=&colecao=1">Moletons</a></li>
                        <li><a href="pesquisa.php?filtro=&busca=&colecao=2">Camisas</a></li>
                        <li><a href="pesquisa.php?filtro=&busca=&colecao=3">Calças</a></li>
                    </ul>
                </li>
                <li><a class="a2" href="pesquisa.php?filtro=Moletom&busca=">Moletons</a></li>
                <li><a class="a2" href="pesquisa.php?filtro=Camisa&busca=">Camisas</a></li>
                <li><a class="a2" href="pesquisa.php?filtro=Calça&busca=">Calças</a></li>
                <li><a class="a2" href="pesquisa.php?filtro=Bicicleta&busca=">Bicicletas</a></li>
            </ul>
        </nav>
    </header>