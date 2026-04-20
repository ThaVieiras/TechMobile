<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$id = (int) ($_GET['id'] ?? 0);

if (!$id) {
    header("Location: produtos.php");
    exit;
}

$stmt = $pdo->prepare("SELECT id_produto FROM produtos WHERE id_produto = ? AND ativo = 1");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header("Location: produtos.php");
    exit;
}

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + 1;

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'carrinho.php'));
exit;