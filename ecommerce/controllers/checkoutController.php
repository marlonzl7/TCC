<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/ecommerce/service/ClientService.php';

if(isset($_POST['iniciarCheckout'])) {
    header("Location: ../views/checkout/dadosPessoais.php");
}

if(isset($_POST['dadosCadastrais'])){

    header("Location: ../views/minhaConta.php");

}

if(isset($_POST['prosseguirDadosPessoais'])){

    header("Location: ../views/checkout/entregaEndereco.php");
    
}

if(isset($_POST['entregaEnderecoProsseguir'])){

    header("Location: ../views/checkout/entregaPagamento.php");
}

if(isset($_POST['dadosPessoaisVoltar'])){

    header("Location: ../views/carrinho.php");
}

if(isset($_POST['entregaPagamentoProsseguir'])){

    header("Location: ../views/checkout/carrinhoRevisao.php");
}

if(isset($_POST['entregaEnderecoVoltar'])){

    header("Location: ../views/checkout/dadosPessoais.php");
    
}

if(isset($_POST['entregaPagamentoVoltar'])){

    header("Location: ../views/checkout/entregaEndereco.php");
    
}

if(isset($_POST['carrinhoRevisaoVoltar'])){

    header("Location: ../views/checkout/entregaPagamento.php");
    
}

if(isset($_POST['carrinho'])){

    header("Location: ../views/carrinho.php");
    
    
}

if(isset($_POST['finalizarCompra'])) {
    header("Location: finalizarCompraController.php");
    
}

if (isset($_POST['finalizado'])) {
    header("Location: ../views/compra-realizada.php");
}
?>
