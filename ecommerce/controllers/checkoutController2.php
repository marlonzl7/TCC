<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/ecommerce/service/ClientService.php';

if(isset($_POST['prosseguirDadosPessoais'])){

    header("Location: ../views/checkout2/entregaEndereco.php");

}

if(isset($_POST['entregaEnderecoProsseguir'])){

    header("Location: ../views/checkout2/entregaPagamento.php");
}

if(isset($_POST['entregaPagamentoProsseguir'])){

    header("Location: ../views/checkout2/carrinhoRevisao.php");
}

if(isset($_POST['entregaEnderecoVoltar'])){

    header("Location: ../views/checkout2/dadosPessoais.php");
    
}

if(isset($_POST['entregaPagamentoVoltar'])){

    header("Location: ../views/checkout2/entregaEndereco.php");
    
}

if(isset($_POST['carrinhoRevisaoVoltar'])){

    header("Location: ../views/checkout2/entregaPagamento.php");
    
}

?>
