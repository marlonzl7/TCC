<?php

require_once '../models/Administrador.php';
require_once '../models/Cliente.php';

class UsuarioFactory {
    public static function criarUsuario($email) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare('SELECT tipo FROM Usuario WHERE email = :email');
        $stmt->bindParam('email', $email);
        $stmt->execute();
        $tipo = $stmt->fetchColumn();

        switch ($tipo) {
            case 'cliente':
                return new Cliente($email, null);
            case 'administrador':
                return new Administrador($email, null);
            default:
                echo '<script type="module">
                import {errorLogin} from "../functions/templates.js";
                errorLogin();
                </script>';
        }
    }
}