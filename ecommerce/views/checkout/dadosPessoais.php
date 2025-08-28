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

        require_once '../../service/ClientService.php';

        $id_usuario = $_SESSION['id_usuario'];
        $id_cliente = $_SESSION['id_cliente'];

        $service = new ClientService(); 
        $client = $service->findClientById($id_usuario);
        $number = $service->findNumberById($id_cliente);

        $dataNasc = date_create($client->getDataNasc());

    ?>

    <main id="main">

        <header id="header">
            
            <img src="../../admin/assets/images/icons/Marca.svg" id="marca">

        </header>

        <div class="titulo">

            <p class="tituloTexto">Confirme seus dados</p>

        </div>

        <div class="barra">
            <img src="../../assets/images/checkout/checkout-dados.png" class="barraIMG">
        </div>

        <form style="font-family: 'Montserrat', sans-serif" action="..\..\controllers\checkoutController.php" method="POST" autocomplete="on">

            <div class = "informacoesFundo">
                <div class="informacoes">
                    <p class="tituloTopicos">Dados Cadastrais</p>

                    <div  id="caixaTopicos">

                        <li class="topico">
                            <div class="nomeTopico">
                                <img src="../../assets/images/checkout/mail-icon.svg">
                                <label for="email" class="texto"> Email </label>
                            </div>

                            <div class="caixaTopico">
                                <p class="textoTopico"><?php echo $client->getEmail(); ?></p>
                            </div> 
                        </li>

                        <li class="topico">
                            <div class="nomeTopico">
                                <img src="../../assets/images/checkout/user-icon.svg">
                                <label for="nome" class="texto"> Nome Completo </label>
                            </div>

                            <div class="caixaTopico">
                                <p class="textoTopico"><?php echo $client->getNome(); ?></p>
                            </div> 
                        </li>

                        <li class="topico">
                            <div class="nomeTopico">
                                <img src="../../assets/images/checkout/id-card.svg">
                                <label for="cpf" class="texto"> CPF </label>
                            </div>

                            <div class="caixaTopico">
                                <p id="cpf" class="textoTopico"><?php echo $client->getCpf(); ?></p>
                            </div> 
                        </li>

                        <li class="topico">
                            <div class="nomeTopico">
                                <img src="../../assets/images/checkout/icon-data.svg">
                                <label for="data" class="texto"> Data de Nascimento </label>
                            </div>

                            <div class="caixaTopico">
                                <p class="textoTopico"><?php echo date_format($dataNasc, "d/m/Y"); ?></p>
                            </div>
                        </li>

                        <li class="topico">
                            <div class="nomeTopico">
                                <img src="../../assets/images/checkout/icon-cel.svg">
                                <label for="celular" class="texto"> Celular </label>
                            </div>

                            <div class="caixaTopico">
                                <p id="celular" class="textoTopico"><?php echo $number->getNumero(); ?></p>
                            </div> 
                        </li>

                    </div> 
                </div>
            </div>

            <div id="caixaBotoes">

                <input type="submit" name="dadosPessoaisVoltar" value="Voltar" class="btnVoltar">
                <input type="submit" name="dadosCadastrais" value="Editar Dados Cadastrais"  class="btnPadrao">
                <input type="submit" name="prosseguirDadosPessoais" value="Prosseguir" onclick="deletaCamposLocalStorage()" class="btnProsseguir">

            </div>
            
        </form>

    </main>

    <script src="../../functions/localStorage.js"></script>
</body>