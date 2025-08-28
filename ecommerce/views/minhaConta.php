<?php
require_once '../includes/menu.php';
require_once '../models/Cliente.php';

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'cliente') {
    header('Location: index.php');
    exit;
}

ini_set('display_errors', 0); // Desativa a exibição de erros
ini_set('log_errors', 1);     // Habilita o log de erros
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if (isset($_SESSION['id_usuario']) && isset($_SESSION['tipo']) && isset($_SESSION['tipo']) == 'cliente') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_cliente = $_SESSION['id_cliente'];
    $email = $_SESSION['email'];

    $cliente = new Cliente($email, null);
    $dados = $cliente->listarDados($id_usuario);
    $enderecoPrincipal = $cliente->enderecoPrincipal($id_cliente);
    $enderecoSecundario = $cliente->enderecoSecundario($id_cliente);
    $telefone = $cliente->telefone($id_cliente);
} else {
    echo "Cliente não encontrado.";
}

if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/estilo/minhaConta.css">
    <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
    <title>minha conta</title>
    <script type="module">
    <?php if (!empty($success_message)) : ?>
        Swal.fire({
            icon: 'success',
            title: <?= json_encode($success_message) ?>,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    <?php endif; ?>
    /*
    <?php //if (isset($_SESSION['success_message'])): ?>
    import {
        sucessLogin
    } from "../functions/templates.js";
    sucessLogin();
    <?php //unset($_SESSION['success_message']); ?>
    <?php //endif; ?>
    */
    //funções
    window.alertaDados = function() {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });
        Toast.fire({
            icon: "success",
            title: "Dados Alterados com sucesso!",
        });
    }
    window.alternarEdicao = function(campoId, botao) {
        var idEnderecoGlobal;
        var campos = document.querySelectorAll("#" + campoId + " input, #" + campoId + " select");
        var editando = botao.textContent.includes("Editar");

        campos.forEach(function(campo) {
            campo.disabled = !editando;
        });

        if (editando) {
            botao.innerHTML = '<i class="fas fa-save"></i> Salvar';
        } else {
            botao.innerHTML = '<i class="fas fa-edit"></i> Editar';
            // Habilitar todos os campos antes de enviar
            campos.forEach(function(campo) {
                campo.disabled = false;
            });
            // Enviar os dados do formulário para o servidor
            alertaDados();
            setTimeout(function() {
                document.getElementById(campoId).submit();
            }, 2000);
        }
    }

    window.alternarEndereco = function() {
        var botao = document.getElementById('botaoAlternar');
        var visualizandoSecundario = botao.textContent.includes("Visualizar endereço principal");
        var titulo = document.getElementById('id_titulo');
        var tituloSecundario = titulo.textContent.includes("Endereço Principal")

        if (visualizandoSecundario) {
            document.getElementById('id_endereco').value = document.getElementById('id_principal').value;
            document.getElementById('cep').value = document.getElementById('cepPrincipal').value;
            document.getElementById('rua').value = document.getElementById('ruaPrincipal').value;
            document.getElementById('numero').value = document.getElementById('numeroPrincipal').value;
            document.getElementById('complemento').value = document.getElementById('complementoPrincipal').value;
            document.getElementById('bairro').value = document.getElementById('bairroPrincipal').value;
            document.getElementById('cidade').value = document.getElementById('cidadePrincipal').value;
            document.getElementById('estado').value = document.getElementById('ufPrincipal').value;
            botao.innerHTML = 'Visualizar endereço secundário';
            titulo.innerHTML = '<img src="../assets/images/icons/search-icon.svg" alt="">Endereço Principal';
        } else {
            document.getElementById('id_endereco').value = document.getElementById('id_secundario').value;
            document.getElementById('cep').value = document.getElementById('cepSecundario').value;
            document.getElementById('rua').value = document.getElementById('ruaSecundario').value;
            document.getElementById('numero').value = document.getElementById('numeroSecundario').value;
            document.getElementById('complemento').value = document.getElementById('complementoSecundario').value;
            document.getElementById('bairro').value = document.getElementById('bairroSecundario').value;
            document.getElementById('cidade').value = document.getElementById('cidadeSecundario').value;
            document.getElementById('estado').value = document.getElementById('ufSecundario').value;
            botao.innerHTML = 'Visualizar endereço principal';
            titulo.innerHTML = '<img src="../assets/images/icons/search-icon.svg" alt="">Endereço Secundário';
        }
    }
    </script>


</head>

<body>
    <section class="container">
        <div class="tabs">
            <div class="tab active"><i class="fas fa-user"></i> Minha Conta</div>
            <div class="tab"><a href="./meusPedidos.php" class="link">Meus Pedidos</a></div>
        </div>
        <div class="form-section">
            <div class="form-group">
                <form id="userForm" action="../controllers/atualizarDados.php" method="POST">
                    <input type="hidden" name="origin" value="minhaConta">
                    <h3><img src="../assets/images/icons/user-icon-1.svg" alt="">Dados Cadastrais</h3>
                    <div class="form-box">
                        <div class="form-item">
                            <label for="email">Email:</label>
                            <input type="email" name='email' id="email" placeholder="exemplo@gmail.com"
                                value='<?php echo htmlspecialchars($dados['email'], ENT_QUOTES, 'UTF-8') ?>' disabled>
                        </div>
                        <div class="form-item">
                            <label for="nome">Nome Completo:</label>
                            <input type="text" name='nome' id="nome" placeholder="Nome Completo"
                                value="<?php echo htmlspecialchars($dados['nome'], ENT_QUOTES, 'UTF-8') ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label for="cpf">CPF:</label>
                            <input type="text" name='cpf' id="cpf" maxlength="14" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                                placeholder="000.000.000-00" value="<?php echo htmlspecialchars($dados['cpf'], ENT_QUOTES, 'UTF-8') ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label for="data-nascimento">Data de Nascimento:</label>
                            <input type="date" name='data-nascimento' id="data-nascimento" placeholder="00/00/0000"
                                value="<?php echo htmlspecialchars($dados['data_nasc'], ENT_QUOTES, 'UTF-8') ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label for="celular">Celular:</label>
                            <input type="number" name='numero_tel' id="numero_tel" placeholder="(11) 9 9999-9999"
                                value="<?php echo htmlspecialchars($telefone['numero'], ENT_QUOTES, 'UTF-8') ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label for="sexo">Sexo:</label>
                            <select name='sexo' id="sexo" disabled>
                                <option value="masculino" <?php echo $dados['sexo'] == 'masculino' ? 'selected' : '' ?>>
                                    Masculino</option>
                                <option value="feminino" <?php echo $dados['sexo'] == 'feminino' ? 'selected' : '' ?>>
                                    Feminino</option>
                                <option value="outro" <?php echo $dados['sexo'] == 'outro' ? 'selected' : '' ?>>Outro
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="button" onclick="alternarEdicao('userForm', this)"><i class="fas fa-edit"></i>
                            Editar</button>
                        <button type="button"><a href="../views/atualizarSenha.php">
                                Alterar senha</a></button>
                        <button type="button"><a class="sair" href="../functions/logout.php">Sair</a></button>
                    </div>
                </form>
            </div>
            <div class="form-group">
                <form id="enderecoForm" action="../controllers/atualizarEndereco.php" method="POST">
                    <!-- dados do endereço principal -->
                    <input type="hidden" id="id_principal" name="id_principal"
                        value="<?php echo $enderecoPrincipal['id_endereco'] ?>">
                    <input type="hidden" id="cepPrincipal" value="<?php echo htmlspecialchars($enderecoPrincipal['cep'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="ruaPrincipal" value="<?php echo htmlspecialchars($enderecoPrincipal['rua'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="numeroPrincipal" value="<?php echo htmlspecialchars($enderecoPrincipal['numero'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="complementoPrincipal"
                        value="<?php echo htmlspecialchars($enderecoPrincipal['complemento'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="bairroPrincipal" value="<?php echo htmlspecialchars($enderecoPrincipal['bairro'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="cidadePrincipal" value="<?php echo htmlspecialchars($enderecoPrincipal['cidade'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="ufPrincipal" value="<?php echo htmlspecialchars($enderecoPrincipal['estado'], ENT_QUOTES, 'UTF-8'); ?>">

                    <!-- dados do endereço secundario -->
                    <input type="hidden" id="id_secundario" name="id_secundario"
                        value="<?php echo $enderecoSecundario['id_endereco'] ?>">
                    <input type="hidden" id="cepSecundario" value="<?php echo htmlspecialchars($enderecoSecundario['cep'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="ruaSecundario" value="<?php echo htmlspecialchars($enderecoSecundario['rua'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="numeroSecundario" value="<?php echo htmlspecialchars($enderecoSecundario['numero'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="complementoSecundario"
                        value="<?php echo htmlspecialchars($enderecoSecundario['complemento'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="bairroSecundario" value="<?php echo htmlspecialchars($enderecoSecundario['bairro'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="cidadeSecundario" value="<?php echo htmlspecialchars($enderecoSecundario['cidade'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="ufSecundario" value="<?php echo htmlspecialchars($enderecoSecundario['estado'], ENT_QUOTES, 'UTF-8'); ?>">

                    <!-- Formulário normal -->
                    <h3 id='id_titulo'><img src="../assets/images/icons/search-icon.svg" alt="">Endereço Principal</h3>
                    <div class="form-box">
                        <input type="hidden" id="id_endereco" name="id_endereco"
                            value="<?php echo htmlspecialchars($enderecoPrincipal['id_endereco'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="form-item">
                            <label for="cep">CEP:</label>
                            <input type="text" name='cep' id="cep" maxlength="9" pattern="\d{5}-\d{3}"
                                placeholder="00000-000" value="<?php echo htmlspecialchars($enderecoPrincipal['cep'], ENT_QUOTES, 'UTF-8'); ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label for="rua">Rua:</label>
                            <input type="text" name='rua' id="rua" placeholder="Nome da Rua"
                                value="<?php echo htmlspecialchars($enderecoPrincipal['rua'], ENT_QUOTES, 'UTF-8'); ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label for="numero">Número:</label>
                            <input type="text" name='numero' id="numero" placeholder="000000"
                                value="<?php echo htmlspecialchars($enderecoPrincipal['numero'], ENT_QUOTES, 'UTF-8'); ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label for="complemento">Complemento:</label>
                            <input type="text" name='complemento' id="complemento" placeholder="Complemento"
                                value="<?php echo htmlspecialchars($enderecoPrincipal['complemento'], ENT_QUOTES, 'UTF-8'); ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label for="bairro">Bairro:</label>
                            <input type="text" name='bairro' id="bairro" placeholder="Nome do Bairro"
                                value="<?php echo htmlspecialchars($enderecoPrincipal['bairro'], ENT_QUOTES, 'UTF-8'); ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label for="cidade">Cidade:</label>
                            <input type="text" name='cidade' id="cidade" placeholder="Nome da Cidade"
                                value="<?php echo htmlspecialchars($enderecoPrincipal['cidade'], ENT_QUOTES, 'UTF-8'); ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label for="estado">Estado:</label>
                            <select name="estado" id="estado" disabled>
                                <?php
                                
                                $estados = ['AC', 'AL', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
                                foreach ($estados as $estado) {
                                    $selected = $enderecoPrincipal['estado'] == $estado ? 'selected' : '';
                                    echo "<option value='$estado' $selected>$estado</option>";
                                }
                                
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="button" onclick="alternarEdicao('enderecoForm', this)"><i class="fas fa-edit"></i>
                            Editar endereço</button>
                        <button type="button" onclick="alternarEndereco()" id='botaoAlternar' name='botaoAlternar'>
                            Visualizar endereço secundário</button>
                        <a href="../controllers/verificarLimiteEndereco.php"><button type="button">
                                Novo</button></a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <a href="../functions/logout.php">Sair</a>
</body>

</html>