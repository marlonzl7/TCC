<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Administrador.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/functions/utils.php'); 

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
    $nome = htmlspecialchars(filter_input(INPUT_POST, 'nome', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');

    try {
        // Verificação de campos obrigatórios
        validateRequiredFields([
            'email' => $email,
            'senha' => $senha,
            'nome' => $nome
        ]);

        // Cria um novo administrador
        $administrador = new Administrador($email, $senha, $nome);

        // cadastra o Administrador
        if ($administrador->cadastrar()) {
            header("Location: /TCC/ecommerce/admin/views/painelAdministrativo/cadastroAdminSucesso.php");
        } else {
            echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral("Erro ao cadastrar administrador!");
          </script>';
        }
    } catch (Exception $e) {
        echo '<script type="module">
        import {errorGeral} from "../functions/templates.js";
        errorGeral(' . json_encode($e->getMessage()) . ');
      </script>';
    }
} 