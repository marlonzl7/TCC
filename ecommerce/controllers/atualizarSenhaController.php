<?php
session_start();

require_once '../models/Cliente.php';
require_once '../functions/utils.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_SESSION['email'];
    $senha_atual = filter_input(INPUT_POST, 'senha_atual', FILTER_DEFAULT);
    $nova_senha = filter_input(INPUT_POST, 'nova_senha', FILTER_DEFAULT);
    $confirmar_nova_senha = filter_input(INPUT_POST, 'confirmar_nova_senha', FILTER_DEFAULT);

    try {
        validateRequiredFields([
            'senha_atual' => $senha_atual,
            'nova_senha' => $nova_senha,
            'confirmar_nova_senha' => $confirmar_nova_senha
        ]);

        if ($nova_senha !== $confirmar_nova_senha) {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("As senhas não coincidem!");
            </script>';
            return;
        }

        $cliente = New Cliente($email, null);

        if ($cliente->atualizar_senha($senha_atual, $nova_senha)) {
            header("Location: ../views/minhaConta.php");
        } else {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao atualizar senha");
            </script>';
        }

    } catch(Exception $e) {
        echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral(' . json_encode($e->getMessage()) . ');
          </script>';
    }
}