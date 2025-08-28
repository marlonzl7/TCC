<?php 

$cliente = new Cliente($email, null);
$enderecoPrincipal = $cliente->enderecoPrincipal($id_cliente);
$enderecoSecundario = $cliente->enderecoSecundario($id_cliente);

ini_set('display_errors', 0); // Desativa a exibição de erros
ini_set('log_errors', 1);     // Habilita o log de erros
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TCC/ecommerce/assets/estilo/checkout-dados.css">
    <title>Document</title>
    <script>
    function enviarFormProsseguir() {
        var form = document.getElementById('userForm');
        form.action = "/TCC/ecommerce/controllers/checkoutController_antigo.php";
        form.submit();
    }

    function alternarEdicao(campoId, botao) {
        event.preventDefault(); // Impede o redirecionamento automático
        var form = document.getElementById(campoId);
        var campos = document.querySelectorAll("#" + campoId + " input, #" + campoId + " select");
        var editando = botao.textContent.includes("Editar");

        campos.forEach(function(campo) {
            campo.disabled = !editando;
        });

        if (editando) {
            botao.innerHTML = 'Salvar';
            // Alterar a action para o controlador de atualização de dados
            form.action = "/TCC/ecommerce/controllers/atualizarEndereco.php";
        } else {
            botao.innerHTML = 'Editar';
            campos.forEach(function(campo) {
                campo.disabled = false;
            });
            form.submit();
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        console.log("DOM completamente carregado e analisado");

        window.alternarEndereco = function() {
            console.log("Função alternarEndereco chamada");
            var titulo = document.getElementById('id_titulo');
            var tituloSecundario = titulo.textContent.trim().includes("Endereço Principal");

            console.log("Título atual:", titulo.textContent);
            console.log("É endereço principal?", tituloSecundario);

            if (tituloSecundario) {
                console.log("Alterando para endereço secundário");
                document.getElementById('id_endereco').value = document.getElementById('id_secundario')
                    .value;
                document.getElementById('cep').value = document.getElementById('cepSecundario').value;
                document.getElementById('rua').value = document.getElementById('ruaSecundario').value;
                document.getElementById('numero').value = document.getElementById('numeroSecundario').value;
                document.getElementById('complemento').value = document.getElementById(
                    'complementoSecundario').value;
                document.getElementById('bairro').value = document.getElementById('bairroSecundario').value;
                document.getElementById('cidade').value = document.getElementById('cidadeSecundario').value;
                document.getElementById('estado').value = document.getElementById('ufSecundario').value;
                titulo.innerHTML =
                    '<img src="/ecommerce/assets/images/icons/search-icon.svg" alt="">Endereço Secundário';
            } else {
                console.log("Alterando para endereço principal");
                document.getElementById('id_endereco').value = document.getElementById('id_principal')
                    .value;
                document.getElementById('cep').value = document.getElementById('cepPrincipal').value;
                document.getElementById('rua').value = document.getElementById('ruaPrincipal').value;
                document.getElementById('numero').value = document.getElementById('numeroPrincipal').value;
                document.getElementById('complemento').value = document.getElementById(
                    'complementoPrincipal').value;
                document.getElementById('bairro').value = document.getElementById('bairroPrincipal').value;
                document.getElementById('cidade').value = document.getElementById('cidadePrincipal').value;
                document.getElementById('estado').value = document.getElementById('ufPrincipal').value;
                titulo.innerHTML =
                    '<img src="/ecommerce/assets/images/icons/search-icon.svg" alt="">Endereço Principal';
            }

            console.log("Valores depois da alteração:");
            console.log("CEP:", document.getElementById('cep').value);
            console.log("Rua:", document.getElementById('rua').value);
            console.log("Número:", document.getElementById('numero').value);
            console.log("Complemento:", document.getElementById('complemento').value);
            console.log("Bairro:", document.getElementById('bairro').value);
            console.log("Cidade:", document.getElementById('cidade').value);
            console.log("Estado:", document.getElementById('estado').value);

            console.log("Endereço alternado");
        };
    });
    </script>
</head>

<body>
    <main>
        <div class="head">
            <h2>Escolha o endereço de entrega</h2>
            <img src="/TCC/ecommerce/assets/checkout/checkout-entrega.png" alt="">
        </div>
        <div class="form">
            <!-- dados do endereço principal -->
            <input type="hidden" id="id_principal" name="id_principal"
                value="<?php echo htmlspecialchars($enderecoPrincipal['id_endereco'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="cepPrincipal"
                value="<?php echo htmlspecialchars($enderecoPrincipal['cep'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="ruaPrincipal"
                value="<?php echo htmlspecialchars($enderecoPrincipal['rua'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="numeroPrincipal"
                value="<?php echo htmlspecialchars($enderecoPrincipal['numero'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="complementoPrincipal"
                value="<?php echo htmlspecialchars($enderecoPrincipal['complemento'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="bairroPrincipal"
                value="<?php echo htmlspecialchars($enderecoPrincipal['bairro'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="cidadePrincipal"
                value="<?php echo htmlspecialchars($enderecoPrincipal['cidade'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="ufPrincipal"
                value="<?php echo htmlspecialchars($enderecoPrincipal['estado'], ENT_QUOTES, 'UTF-8'); ?>">

            <!-- dados do endereço secundario -->
            <input type="hidden" id="id_secundario" name="id_secundario"
                value="<?php echo htmlspecialchars($enderecoSecundario['id_endereco'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="cepSecundario"
                value="<?php echo htmlspecialchars($enderecoSecundario['cep'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="ruaSecundario"
                value="<?php echo htmlspecialchars($enderecoSecundario['rua'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="numeroSecundario"
                value="<?php echo htmlspecialchars($enderecoSecundario['numero'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="complementoSecundario"
                value="<?php echo htmlspecialchars($enderecoSecundario['complemento'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="bairroSecundario"
                value="<?php echo htmlspecialchars($enderecoSecundario['bairro'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="cidadeSecundario"
                value="<?php echo htmlspecialchars($enderecoSecundario['cidade'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" id="ufSecundario"
                value="<?php echo htmlspecialchars($enderecoSecundario['estado'], ENT_QUOTES, 'UTF-8'); ?>">

            <h3 id="id_titulo">Endereço Principal</h3>
            <form action="/TCC/ecommerce/controllers/checkoutController_antigo.php" method="POST" id="form" name="form">
                <input type="hidden" name="origin" value="entrega">
                <input type="hidden" name="action" value="pagamento">
                <input type="hidden" name="id_endereco" id="id_endereco"
                    value="<?php echo htmlspecialchars($enderecoPrincipal['id_endereco'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="cep">CEP</label>
                    </div>
                    <input type="text" name="cep" id="cep"
                        value="<?php echo htmlspecialchars($enderecoPrincipal['cep'], ENT_QUOTES, 'UTF-8'); ?>"
                        disabled>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="rua">Rua</label>
                    </div>
                    <input type="text" name="rua" id="rua"
                        value="<?php echo htmlspecialchars($enderecoPrincipal['rua'], ENT_QUOTES, 'UTF-8'); ?>"
                        disabled>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="Número">Número</label>
                    </div>
                    <input type="text" name="numero" id="numero"
                        value="<?php echo htmlspecialchars($enderecoPrincipal['numero'], ENT_QUOTES, 'UTF-8'); ?>"
                        disabled>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="complemento">Complemento</label>
                    </div>
                    <input type="text" name="complemento" id="complemento"
                        value="<?php echo htmlspecialchars($enderecoPrincipal['complemento'], ENT_QUOTES, 'UTF-8'); ?>"
                        disabled>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="bairro">Bairro</label>
                    </div>
                    <input type="text" name="bairro" id="bairro"
                        value="<?php echo htmlspecialchars($enderecoPrincipal['bairro'], ENT_QUOTES, 'UTF-8'); ?>"
                        disabled>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="cidade">Cidade</label>
                    </div>
                    <input type="text" name="cidade" id="cidade"
                        value="<?php echo htmlspecialchars($enderecoPrincipal['cidade'], ENT_QUOTES, 'UTF-8'); ?>"
                        disabled>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="estado">Estado</label>
                    </div>
                    <input type="text" name="estado" id="estado"
                        value="<?php echo htmlspecialchars($enderecoPrincipal['estado'], ENT_QUOTES, 'UTF-8'); ?>"
                        disabled>
                </div>
                <div class="buttons">
                    <button class="btn-secundario" onclick="alternarEdicao('form', this)">Editar</button>
                    <button type="button" class="btn-secundario" onclick="alternarEndereco()">Mudar</button>
                    <button class="btn-prosseguir" type="submit" onclick="enviarFormProsseguir()">Prosseguir</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>