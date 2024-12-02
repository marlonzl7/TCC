<?php

function verificarSessao($tipoEsperado) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['tipo']) || $_SESSION['tipo'] !== $tipoEsperado) {
        header('Location: index.php');
        exit;
    }
}
