<?php
// Configurações do banco
$host = '127.0.0.1';
$db   = 'techmobile';
$user = 'root';
$pass = '#Go1232329@'; //Alterar senha para vazia se estiver usando o XAMPP sem senha
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Remoção o "echo" para não sujar o layout depois
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}