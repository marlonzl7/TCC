<?php
function validateRequiredFields($fields) {
    foreach ($fields as $field => $value) {
        if (!isset($value) || $value === "") {
            throw new Exception("O campo $field é obrigatório.");
        }
    }
}