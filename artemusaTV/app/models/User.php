<?php 
require_once __DIR__. '/../../config/database.php';

class User {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function validar($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
        $stmt->execute([$username, $password]);
        return $stmt->fetch();
    }
}