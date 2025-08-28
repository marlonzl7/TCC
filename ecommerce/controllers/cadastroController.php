<?php
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

require_once '../models/Cliente.php';
require_once '../functions/utils.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar dados de acesso
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $confirmarEmail = filter_input(INPUT_POST, 'confirmarEmail', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
    $confirmarSenha = filter_input(INPUT_POST, 'confirmarSenha', FILTER_DEFAULT);
    // Sanitizar dados pessoais
    $nome = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT);
    $dataNasc = filter_input(INPUT_POST, 'dataNasc', FILTER_DEFAULT);
    $sexo = filter_input(INPUT_POST, 'sexo', FILTER_DEFAULT);
    $celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_NUMBER_INT);
    $telefoneFixo = filter_input(INPUT_POST, 'telefoneFixo', FILTER_SANITIZE_NUMBER_INT) ?: '';
    // Sanitizar dados de endereço
    $rua = filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_SPECIAL_CHARS);
    $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
    $complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_SPECIAL_CHARS) ?: '';
    $bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_SPECIAL_CHARS);
    $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS);
    $uf = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_SPECIAL_CHARS);
    $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_NUMBER_INT);

    try {
        // Verificação de campos obrigatórios
        validateRequiredFields([
            'email' => $email,
            'confirmarEmail' => $confirmarEmail,
            'senha' => $senha,
            'confirmarSenha' => $confirmarSenha,
            'cpf' => $cpf,
            'nome' => $nome,
            'dataNasc' => $dataNasc,
            'sexo' => $sexo,
            'celular' => $celular,
            'cep' => $cep,
            'rua' => $rua,
            'numero' => $numero,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'uf' => $uf
        ]);

        // Verifica e-mails coincidem
        if ($email !== $confirmarEmail) {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Os email informados não coincidem!");
            </script>';
            return;
        }

        // Verifica se as senhas coincidem
        if ($senha !== $confirmarSenha) {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("As senhas informadas não coincidem!");
            </script>';
            return;
        }

        // Cria um novo cliente
        $cliente = new Cliente($email, $senha, $cpf, $nome, $dataNasc, $sexo);

        // Adiciona celular se informado
        if (!empty($celular)) {
            $cliente->adicionarTelefone($celular);
        }

        // Adiciona telefone fixo se informado
        if (!empty($telefoneFixo)) {
            $cliente->adicionarTelefone($telefoneFixo);
        }

        // Adiciona endereço
        $cliente->adicionarEndereco($rua, $numero, $complemento, $bairro, $cidade, $uf, $cep);

        // cadastrar o cliente
        if ($cliente->cadastrar()) {
            header("Location: ../views/cadastroSucesso.html");
            exit;
        } else {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao cadastrar cliente");
            </script>';
        }
    } catch (Exception $e) {
        echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral(' . json_encode($e->getMessage()) . ');
            </script>';
    }
}
