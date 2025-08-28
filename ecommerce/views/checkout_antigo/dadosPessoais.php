<?php
$cliente = $service->findClientById($id_usuario);
$telefone = $service->findNumberById($id_cliente);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TCC/ecommerce/assets/estilo/checkout-dados.css">
    <title>Document</title>
    <script>
        // Função para alternar a edição dos campos e definir a action do form
        function alternarEdicao(campoId, botao) {
            var form = document.getElementById(campoId);
            var campos = document.querySelectorAll("#" + campoId + " input, #" + campoId + " select");
            var editando = botao.textContent.includes("Editar");

            campos.forEach(function(campo) {
                campo.disabled = !editando;
            });

            if (editando) {
                botao.innerHTML = 'Salvar';
                // Alterar a action para o controlador de atualização de dados
                form.action = "/TCC/ecommerce/controllers/atualizarDados.php";
            } else {
                botao.innerHTML = 'Editar';
                campos.forEach(function(campo) {
                campo.disabled = false;
                });
                form.submit();
            }
        }

        // Função para alterar a action ao clicar no botão "Prosseguir"
        function enviarFormProsseguir() {
            var form = document.getElementById('userForm');
            form.action = "/TCC/ecommerce/controllers/checkoutController_antigo.php";
            form.submit();
        }

        function enviarFormVoltar() {
            var form = document.getElementById('userForm');
            form.action = "/TCC/ecommerce/controllers/checkoutController_antigo.php";
            form.submit();
        }
    </script>
</head>
<body>
    <main>
        <div class="head">
            <h2>Confirme seus dados</h2>
            <img src="/TCC/ecommerce/assets/checkout/checkout-dados.png" alt="">
        </div>
        <div class="form">
            <h3>Dados cadastrais</h3>
            <form id="userForm" method="post">
            <input type="hidden" name="origin" value="checkout">
                <input type="hidden" name="action" id="action" value="entrega">
                <input type="hidden" name="sexo" value="<?php echo htmlspecialchars($cliente->getSexo(), ENT_QUOTES, 'UTF-8'); ?>">
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="/TCC/ecommerce/assets/images/icons/mail2-icon.svg" alt="">
                        <label for="email">Email</label>
                    </div>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($cliente->getEmail(), ENT_QUOTES, 'UTF-8'); ?>" disabled>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="/TCC/ecommerce/assets/images/icons/user2-icon.svg" alt="">
                        <label for="nome">Nome Completo</label>
                    </div>
                    <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($cliente->getNome(), ENT_QUOTES, 'UTF-8'); ?>" disabled>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="/TCC/ecommerce/assets/images/icons/card-icon.svg" alt="">
                        <label for="cpf">CPF</label>
                    </div>
                    <input type="text" name="cpf" id="cpf" value="<?php echo htmlspecialchars($cliente->getCpf(), ENT_QUOTES, 'UTF-8'); ?>" disabled>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="/TCC/ecommerce/assets/images/icons/calendar-icon.svg" alt="">
                        <label for="data-nascimento">Data de nascimento</label>
                    </div>
                    <input type="date" name="data-nascimento" id="data-nascimento" value="<?php echo htmlspecialchars($cliente->getDataNasc(), ENT_QUOTES, 'UTF-8'); ?>" disabled>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="/TCC/ecommerce/assets/images/icons/icon-cel.svg" alt="">
                        <label for="numero_tel">Celular</label>
                    </div>
                    <input type="text" name="numero_tel" id="numero_tel" value="<?php echo htmlspecialchars($telefone->getNumero(), ENT_QUOTES, 'UTF-8'); ?>" disabled>
                </div>
                <div class="buttons">
                    <!--
                    <button type="button" id="voltarCarrinho" class="btn-secundario">
                        <a href="../views/carrinho.php">Voltar</a>
                    </button>
                    -->
                    <button type="button" class="btn-secundario" onclick="alternarEdicao('userForm', this)">Editar</button>
                    <button class="btn-prosseguir" type="button" onclick="enviarFormProsseguir()">Prosseguir</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
