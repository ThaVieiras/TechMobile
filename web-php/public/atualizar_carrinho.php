<?php
session_start();

$id = $_GET['id'] ?? null;
$acao = $_GET['acao'] ?? null;

if ($id && $acao) {
    // Verifica se o produto já existe no carrinho para evitar erros
    if (isset($_SESSION['carrinho'][$id])) {
        if ($acao === 'add') {
            $_SESSION['carrinho'][$id] += 1;
        } elseif ($acao === 'sub') {
            $_SESSION['carrinho'][$id] -= 1;
            
            // Se a quantidade chegar a 0, remove o item da sessão
            if ($_SESSION['carrinho'][$id] <= 0) {
                unset($_SESSION['carrinho'][$id]);
            }
        }
    }
}

// Redirecionar para o carrinho, não para a home
header("Location: carrinho.php");
exit;