<?php
session_start();

$id   = (int) ($_GET['id'] ?? 0);
$acao = $_GET['acao'] ?? '';

if ($id && isset($_SESSION['carrinho'][$id])) {
    if ($acao === 'add') {
        $_SESSION['carrinho'][$id]++;
    } elseif ($acao === 'sub') {
        $_SESSION['carrinho'][$id]--;
        // Remove do carrinho se chegar a zero
        if ($_SESSION['carrinho'][$id] <= 0) {
            unset($_SESSION['carrinho'][$id]);
        }
    }
}

header("Location: carrinho.php");
exit;