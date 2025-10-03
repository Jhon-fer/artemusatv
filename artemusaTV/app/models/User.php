<?php
require_once __DIR__. '/../../config/database.php';

class User {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function validar($usurname, $password) {
        $stmt = $this->pdo->prepare("SELEC * FROM usuarios WHERE usuarios = ? AND password = ?");
        $stmt->execute([$usurname, $password]);
        return $stmt->fetch();
    }
}
