<?php
require_once '../models/Endereco.php';
require_once '../models/Cliente.php';

session_start();

$id_cliente = $_SESSION['id_cliente'];
$email = $_SESSION['email'];

$cliente = new Cliente($email, null);

$endereco = $cliente->enderecoSecundario($id_cliente);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Atualizar Endereço</title>
    <link rel="stylesheet" href="../assets/estilo/novoEndereco.css" />
    <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
</head>

<body>
    <div class="container">
        <div class="title">
            <h1>Atualizar endereço</h1>
            <p>Preencha todos os campos para atualizar seu endereço secundário</p>
        </div>
        <div class="form-container">
            <form action="../controllers/atualizarEndereco.php" method="post">
                <input type="hidden" id="id_endereco" name="id_endereco" value="<?php echo $endereco['id_endereco'] ?>">
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" maxlength="9" pattern="\d{5}-\d{3}" />
                </div>
                <div class="form-group">
                    <label for="rua">RUA</label>
                    <input type="text" id="rua" name="rua" />
                </div>
                <div class="form-group">
                    <label for="numero">NÚMERO</label>
                    <input type="number" id="numero" name="numero" />
                </div>
                <div class="form-group">
                    <label for="bairro">BAIRRO</label>
                    <input type="text" id="bairro" name="bairro" />
                </div>
                <div class="form-group">
                    <label for="cidade">CIDADE</label>
                    <input type="text" id="cidade" name="cidade" />
                </div>
                <div class="form-group">
                    <label for="uf">UF</label>
                    <select name="uf" id="uf">
                        <option value="AC">AC</option>
                        <option value="AL">AL</option>
                        <option value="AP">AP</option>
                        <option value="AM">AM</option>
                        <option value="BA">BA</option>
                        <option value="CE">CE</option>
                        <option value="DF">DF</option>
                        <option value="ES">ES</option>
                        <option value="GO">GO</option>
                        <option value="MA">MA</option>
                        <option value="MT">MT</option>
                        <option value="MS">MS</option>
                        <option value="MG">MG</option>
                        <option value="PA">PA</option>
                        <option value="PB">PB</option>
                        <option value="PR">PR</option>
                        <option value="PE">PE</option>
                        <option value="PI">PI</option>
                        <option value="RJ">RJ</option>
                        <option value="RN">RN</option>
                        <option value="RS">RS</option>
                        <option value="RO">RO</option>
                        <option value="RR">RR</option>
                        <option value="SC">SC</option>
                        <option value="SP" selected>SP</option>
                        <option value="SE">SE</option>
                        <option value="TO">TO</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="complemento">COMPLEMENTO</label>
                    <input type="text" id="complemento" name="complemento" />
                </div>
                <div class="buttons">
                    <a href="../views/minhaConta.php">Cancelar</a>
                    <button type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>