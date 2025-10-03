<?php
$host = 'localhost';
$db   = 'artemusatvphp';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
} catch (PDOException $e) {
    die("Error de conexion: " . $e->getMessage());
}