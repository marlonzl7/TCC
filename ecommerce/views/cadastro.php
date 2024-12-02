<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/estilo/cadastro.css">
    <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"></script>
    <script>
        function voltarPagina() {
            window.location.href = "index.php";
        }
        $(document).ready(function() {
            function limpa_formulário_cep() {
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
            }
            $("#cep").blur(function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep != "") {
                    var validacep = /^[0-9]{8}$/;
                    if(validacep.test(cep)) {
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                            if (!("erro" in dados)) {
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                            } 
                            else {
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } 
                    else {
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                }
                else {
                    limpa_formulário_cep();
                }
            });
        });

    </script>
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>Cadastro</h1>
        </div>
        <form action="../controllers/cadastroController.php" method="post">
            <div class="input-box">
                <div class="caption">
                    <h2>DADOS DE ACESSO</h2>
                </div>
            </div>
            <div class="input-group">
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="../assets/images/icons/mail-icon.svg" alt="">
                        <label for="email">Email</label>
                    </div>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="../assets/images/icons/mail-icon.svg" alt="">
                        <label for="confirmarEmail">Confirmar Email</label>
                    </div>
                    <input type="email" name="confirmarEmail" id="confirmarEmail" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="../assets/images/icons/password-icon.svg" alt="">
                        <label for="senha">Senha</label>
                    </div>
                    <input type="password" name="senha" id="senha" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <img src="../assets/images/icons/password-icon.svg" alt="">
                        <label for="confirmarSenha">Confirmar Senha</label>
                    </div>
                    <input type="password" name="confirmarSenha" id="confirmarSenha" required>
                </div>
                <div class="input-box">
                    <div class="caption">
                        <h2>DADOS PESSOAIS</h2>
                    </div>
                </div>
                <div class="input-box">
                    <div class="caption">
                        <h2>ENDEREÇO</h2>
                    </div>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="nome">Nome Completo</label>
                    </div>
                    <input type="text" name="nome" id="nome" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="cep">CEP</label>
                    </div>
                    <input type="text" name="cep" id="cep" maxlength="9" pattern="\d{5}-\d{3}" placeholder="" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="cpf">CPF</label>
                    </div>
                    <input type="text" name="cpf" id="cpf" maxlength="14" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="rua">Rua</label>
                    </div>
                    <input type="text" name="rua" id="rua" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="celular">Celular</label>
                    </div>
                    <input type="text" name="celular" id="celular" placeholder="(XX) XXXXX-XXXX" maxlength="15" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="numero">Número</label>
                    </div>
                    <input type="number" name="numero" id="numero" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="telefoneFixo">Telefone Fixo</label>
                    </div>
                    <input type="text" name="telefoneFixo" id="telefoneFixo" placeholder="(Opcional)" maxlength="14">
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="complemento">Complemento</label>
                    </div>
                    <input type="text" name="complemento" id="complemento" placeholder="(Opcional)">
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="dataNasc">Data de Nascimento</label>
                    </div>
                    <input type="date" name="dataNasc" id="dataNasc" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="bairro">Bairro</label>
                    </div>
                    <input type="text" name="bairro" id="bairro" required>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="sexo">Sexo</label>
                    </div>
                    <select name="sexo" id="sexo" required>
                        <option value="masculino">Masculino</option>
                        <option value="feminino">Feminino</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="cidade">Cidade</label>
                    </div>
                    <input type="text" name="cidade" id="cidade" required>
                </div>
                <div class="input-box">
                </div>
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="uf">UF</label>
                    </div>
                    <select name="uf" id="uf" required>
                        <?php
                            $ufs = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
                            foreach ($ufs as $uf) {
                                $selected = $uf == 'SP' ? 'selected' : '';
                                echo "<option value='$uf' $selected>$uf</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div>
                <ul class="buttons">
                    <li><button type="reset" id="cancelar" onclick="voltarPagina()">Cancelar</button></li>
                    <li><button type="submit">Cadastrar</button></li>
                </ul>
            </div>
        </form>
    </div>
    <script src="../functions/format.js"></script>
</body>
</html>