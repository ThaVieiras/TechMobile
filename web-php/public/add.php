<?php
session_start();
// Sobe dois níveis para achar a config (MVC enxuto)
require_once __DIR__ . '/../../config/database.php';

// Filtra o ID vindo da URL (RF-W03)
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if ($id) {
    // Valida se o produto existe e tem estoque (RN-01)
    $stmt = $pdo->prepare("SELECT p.id_produto, e.quantidade_atual FROM produtos p 
                           JOIN estoque e ON p.id_produto = e.id_produto 
                           WHERE p.id_produto = ? AND p.ativo = 1");
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto && $produto['quantidade_atual'] > 0) {
        // Se já existe no carrinho (sessão), incrementa. Se não, inicia com 1.
        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]++;
        } else {
            $_SESSION['carrinho'][$id] = 1;
        }
    }
}

// Redireciona de volta para a vitrine (UX fluida)
header("Location: produtos.php");
exit;