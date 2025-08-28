<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/config/Database.php');

class DatabaseConnect {
    protected $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
}
