<?php
require_once '../models/Endereco.php';
session_start();
$id = $_SESSION['id_cliente'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Novo Endereço</title>
    <link rel="stylesheet" href="../assets/estilo/novoEndereco.css" />
    <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
</head>

<body>
    <div class="container">
        <div class="title">
            <h1>Cadastrar novo endereço</h1>
            <p>Preencha todos os campos para cadastrar um novo endereço</p>
        </div>
        <div>
            <form action="../controllers/enderecosController.php" method="post" class="form-container">
                <div class="form-group">
                    <label for="cep" id="cep">Cep</label>
                    <input type="text" id="cep" name="cep" maxlength="9" pattern="\d{5}-\d{3}" />
                </div>
                <div class="form-group">
                    <label for="rua">Rua</label>
                    <input type="text" id="rua" name="rua" />
                </div>
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="number" id="numero" name="numero" />
                </div>
                <div class="form-group">
                    <label for="bairro">Bairro</label>
                    <input type="text" id="bairro" name="bairro" />
                </div>
                <div class="form-group">
                    <label for="cidade">Cidade</label>
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
                    <button type="button" class="cancel-button"
                        onclick="window.location.href='../views/minhaConta.php'">CANCELAR</button>
                    <button type="submit" class="submit-button">ENVIAR</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="../functions/format.js"></script>
</html>