<?php
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

require_once '../models/UsuarioFactory.php';
require_once '../functions/utils.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);

    try {
        validateRequiredFields([
            'email' => $email,
            'senha' => $senha
        ]);

        // Cria o Usuário usando a factory
        $usuario = UsuarioFactory::criarUsuario($email);
        
        if ($usuario->logar($email, $senha)) {
            $_SESSION['id_usuario'] = $usuario->getIdUsuario();
            $_SESSION['email'] = $usuario->getEmail();
            $_SESSION['tipo'] = $usuario->getTipo();

            if ($usuario->getTipo() === 'administrador') {
                $_SESSION['id_admin'] = $usuario->getIdAdmin();
                $_SESSION['nome_admin'] = $usuario->getNome();
                header('Location: ../admin/views/painelAdministrativo/administradores.php');
                exit;
            } elseif ($usuario->getTipo() === 'cliente') {
                if ($usuario->getIdCliente($_SESSION['id_usuario']) !== null) {
                    $_SESSION['id_cliente'] = $usuario->getIdCliente();
                }
                $_SESSION['success_message'] = 'Login realizado com sucesso!';
                header('Location: ../views/minhaConta.php');
                exit();
            }
        } else {
            // Referenciar o SweetAlert2 e chamar o alerta
            echo '<script type="module">
            import {errorLogin} from "../functions/templates.js";
            errorLogin();
            </script>';
        }
    } catch (PDOException $e) {
        echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral(' . json_encode($e->getMessage()) . ');
          </script>';
    } catch (Exception $e) {
        echo '<script type="module">
            import {errorGeral} from "../functions/templates.js";
            errorGeral(' . json_encode($e->getMessage()) . ');
          </script>';
    }
}
