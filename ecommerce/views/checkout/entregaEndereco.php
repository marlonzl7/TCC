<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../assets/estilo/checkout.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OneClick Store</title>
</head>

<body>

    <?php
        session_start();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/ecommerce/service/ClientService.php';

        $id_cliente = $_SESSION['id_cliente'];

        $service = new ClientService(); 
        $endereco = $service->findAdressById($id_cliente);

    ?>

    <main id="main">

        <header id="header">
            
            <img src="../../admin/assets/images/icons/Marca.svg" id="marca">

        </header>

        <div class="titulo">

            <p class="tituloTexto">Escolha o endereço de entrega</p>

        </div>

        <div class="barra">
            <img src="../../assets/images/checkout/checkout-entrega.png" class="barraIMG">
        </div>

        <form style="font-family: 'Montserrat', sans-serif" action="..\..\controllers\checkoutController.php" method="POST" autocomplete="on">

            <div class = "informacoesFundo">
                <div class="informacoes">
                    <p class="tituloTopicos">Endereço Principal</p>

                    <div  id="caixaTopicos">

                        <li class="topico">
                            <div class="nomeTopico">
                                <label for="cep" class="texto"> CEP </label>
                            </div>
                            <input type="text" name="cep" id="cep" value="<?php echo $endereco->getCep(); ?>" placeholder="00000-000" maxlength="9" required>
                        </li>

                        <li class="topico">
                            <div class="nomeTopico">
                                <label for="rua" class="texto"> Rua </label>
                            </div>
                            <input type="text" name="rua" id="rua" value="<?php echo $endereco->getRua(); ?>" placeholder="Nome da Rua" required>
                        </li>

                        <li class="topico">
                            <div class="nomeTopico">
                                <label for="Número" class="texto"> Número </label>
                            </div>
                            <input type="number" name="numero" id="numero" value="<?php echo $endereco->getNumero(); ?>" placeholder="000000" required>
                        </li>

                        <li class="topico">
                            <div class="nomeTopico">
                                <label for="bairro" class="texto"> Bairro </label>
                            </div>
                            <input type="text" name="bairro" id="bairro" value="<?php echo $endereco->getBairro(); ?>" placeholder="Nome do Bairro" required>
                        </li>

                        <li class="topico">
                            <div class="nomeTopico">
                                <label for="cidade" class="texto"> Cidade </label>
                            </div>
                            <input type="text" name="cidade" id="cidade" value="<?php echo $endereco->getCidade(); ?>" placeholder="Nome da Cidade" required>
                        </li>

                    </div> 
                </div>
            </div>

            <div id="caixaBotoes">

                <input type="submit" name="entregaEnderecoVoltar" value="Voltar" onclick="salvaEnderecoLocalStorage()" class="btnVoltar">
                <input type="submit" name="dadosCadastrais" value="Editar Dados Cadastrais" onclick="deletaCamposLocalStorage()" class="btnPadrao">
                <input type="submit" name="entregaEnderecoProsseguir" value="Prosseguir" onclick="salvaEnderecoLocalStorage()"  class="btnProsseguir">

            </div>
            
        </form>

    </main>

    <script src="../../functions/format.js"></script>
    <script src="../../functions/localStorage.js"></script>
    <script>

        preencheEnderecoLocalStorage();

    </script>

</body>