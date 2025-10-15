<?php
$host = 'localhost';
$db   = 'artemusa_artemusatvphp';
$user = 'artemusa_artemusa';
$pass = '7j4vV2mp5V';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}