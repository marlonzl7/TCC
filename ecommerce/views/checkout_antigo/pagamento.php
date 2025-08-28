<?php
$carrinho = new Carrinho($id_cliente);
$itens = $carrinho->exibirItens();
$total = $carrinho->calcularTotal();
$ids_produtos = [];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="/TCC/ecommerce/assets/estilo/checkout.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OneClick Store</title>
    
    <script>
        function enviarFormProsseguir() {
            var form = document.getElementById('Form');
            form.action = "/TCC/ecommerce/controllers/checkoutController_antigo.php";
            form.submit();
        }
    </script>
</head>


<body>

    <main id="main">

        <div class="titulo">

            <p class="tituloTexto">Escolha o tipo de pagamento</p>

        </div>

        <div class="barra">
            <img src="/TCC/ecommerce/assets/images/checkout/checkout-pagamento.png" class="barraIMG">
        </div>

        <form id="Form" style="font-family: 'Montserrat', sans-serif" action="..\..\controllers\checkoutController_antigo.php" method="POST" autocomplete="on">

            <div class = "informacoesFundo">
                <div class="informacoes">

                    <div class= "nomeTitulo">
                        <p class="textTopico"> Tipos de Pagamentos </p>
                    </div>

                    <div id="caixaSelecionaTipo">

                        <div class="caixaTipo">

                            <input type="radio" id="cartao" name="pagamento" class="checkmark" value="Cartão">
                            <label class="texto"> Cartão </label>

                        </div>

                        <div class="caixaTipo">

                            <input type="radio" id="boleto" name="pagamento" class="checkmark" value="Boleto">
                            <label class="texto"> Boleto </label>

                        </div>

                        <div class="caixaTipo">

                            <input type="radio" id="paypal" name="pagamento" class="checkmark" value="PayPal">
                            <label class="texto"> Paypal </label>

                        </div>

                        <div class="caixaTipo">

                            <input type="radio" id="pix" name="pagamento" class="checkmark" value="P">
                            <span class="checkmark"></span>
                            <label class="texto"> Pix </label>

                        </div>

                    </div>

                    <div id="caixaSelecionaCartao">

                        <p class="textTopico">Cartão de Crédito</p>

                        <select id="formaCartao" name="forma-pagamento">

                            <option value="1" >Visa</option>
                            <option value="2 ">Mastercard</option>
                            <option value="3" >ELO</option>
                            <option value="4" >Hipercard</option>
                            <option value="5" >American Express</option>

                        </select>

                        <li class="topico">

                            <div class="nomeTopico">
                                <label for="numeroCartao" class="texto"> Número do Cartão </label>
                            </div>

                            <input type="text" id="numeroCartao" value="" placeholder="0000 0000 0000 0000" maxlength="19">
                        </li>

                        <div class="caixaSeparacao">

                            <li class="topico">
                                <div class="nomeTopico">
                                    <label for="validadeCartao" class="texto"> Validade </label>
                                </div>
                                <input type="text" id="validadeCartao" value="" placeholder="MM/AA" maxlength="5">
                            </li>

                            <li class="topico">
                                <div class="nomeTopico">
                                    <label for="codigoSegurancaCartao" class="texto"> Código de segurança </label>
                                </div>
                                <input type="text" id="codigoSeguranca" value="" placeholder="CVC" maxlength="3">
                            </li>

                        </div>

                        <li class="topico">
                            <div class="nomeTopico">
                                <label for="nomeCartao" class="texto"> Nome Completo </label>
                            </div>
                            <input type="text" id="nomeCartao" id="nome"  value="" placeholder="Nome Completo">
                        </li>

                        <li class="topico">
                            <div class="nomeTopico">
                                <label for="cpf" class="texto"> CPF </label>
                            </div>

                            <input type="text" id="cpfCartao" id="cpf" placeholder="000.000.000-00" maxlength="14">
                        </li>

                        <div class="caixaSeparacao">

                            <li class="topico">
                                <div class="nomeTopico">
                                    <label for="telefoneCartao" class="texto"> Telefone </label>
                                </div>
                                <input type="text" id="telefoneCartao" id="celular" value="" placeholder="(00) 00000-000" maxlength="15">
                            </li>

                            <li class="topico">
                                <div class="nomeTopico">
                                    <label for="dataNascCartao" class="texto"> Data de nascimento </label>
                                </div>
                                <input type="date" id="dataNascCartao" id="dataNasc" value="" placeholder="DD/MM/AAAA">
                            </li>

                        </div>

                        <li class="topico">

                            <div class="nomeTopico">
                                <label for="parcelas" class="texto"> Parcelas </label>
                            </div>

                            <select id="parcelas" name="parcelas">

                                <option value="1"><?php $total1X = ($total/1); echo "1X sem juros: R$" . number_format($total1X, 2, ',', '.') ?></option>
                                <option value="2"><?php $total2X = ($total/2); echo "2X sem juros: R$" . number_format($total2X, 2, ',', '.') ?></option>
                                <option value="3"><?php $total3X = ($total/3); echo "3X sem juros: R$" . number_format($total3X, 2, ',', '.') ?></option>
                                <option value="4"><?php $total4X = ($total/4); echo "4X sem juros: R$" . number_format($total4X, 2, ',', '.') ?></option>
                                <option value="5"><?php $total5X = ($total/5); echo "5X sem juros: R$" . number_format($total5X, 2, ',', '.') ?></option>
                                <option value="6"><?php $total6X = ($total/6); echo "6X sem juros: R$" . number_format($total6X, 2, ',', '.') ?></option>
                            </select>
                                
                        </li>

                    </div>

                    <div id="caixaSelecionaBoleto">

                        <li class="topico">
                            <div class="nomeTopico">
                                <label for="nomeBoleto" class="texto"> Nome Completo </label>
                            </div>
                            <input type="text" id="nomeBoleto" id="nome" value="" placeholder="Nome Completo">
                        </li>

                        <li class="topico">
                            <div class="nomeTopico">
                                <label for="cpfBoleto" class="texto"> CPF </label>
                            </div>

                            <input type="text" id="cpfBoleto" id="cpf" placeholder="000.000.000-00" maxlength="14">
                        </li>
                        
                    </div>

                    <div id="caixaSelecionaPaypal">

                        <p class = "texto" style="margin-top:10%;">Transações do PayPal são autorizadas pelo site do PayPal. Clique no botão abaixo para abrir uma nova janela do navegador e iniciar a transação.</p>
                        

                        <a href="https://www.paypal.com/br/signin" target="_blank"> 
                            <div class="btnPaypal">
                                <img src="/TCC/ecommerce/assets/images/checkout/paypal.png" class="barraIMG">
                            </div>    

                        </a>

                    </div>

                    <div id="caixaSelecionaPix">

                        <li class="topico">
                            <div class="nomeTopico">
                                <label for="cpfPix" class="texto"> CPF </label>
                            </div>

                            <input type="text" id="cpfPix" placeholder="000.000.000-00" maxlength="14">
                        </li>
                        
                    </div>
                </div>
            </div>

            <div id="caixaBotoes">
                
            <input type="hidden" name="action" value="revisao">
            
            <button class="btnProsseguir" type="button" onclick="enviarFormProsseguir()">Prosseguir</button>
                <!--<input type="submit" name="entregaPagamentoProsseguir" value="Prosseguir" onclick="salvaPagamentoLocalStorage()" class="btnProsseguir">-->

            </div>

        </form>

    </main>

    <script src="/TCC/ecommerce/functions/format_checkout.js"></script>
    <script src="/TCC/ecommerce/functions/script_pagamento.js"></script>
    <script src="/TCC/ecommerce/functions/localStorage.js"></script>
    <script>

        preenchePagamentoLocalStorage();

    </script>

</body>

</html>