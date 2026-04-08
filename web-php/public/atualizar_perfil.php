<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Verifica se o usuário está logado e se os dados vieram via POST
if (!isset($_SESSION['cliente_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$id_cliente = $_SESSION['cliente_id'];
$telefone = $_POST['telefone'] ?? '';
$endereco = $_POST['endereco'] ?? '';

try {
    // Comando SQL para atualizar apenas os campos permitidos (RF-W09)
    $stmt = $pdo->prepare("UPDATE clientes SET telefone = ?, endereco = ? WHERE id_cliente = ?");
    $stmt->execute([$telefone, $endereco, $id_cliente]);

    // Redireciona de volta com uma mensagem de sucesso 
    header("Location: minha_conta.php?sucesso=1");
} catch (PDOException $e) {
    // Em caso de erro, você pode tratar aqui (RNF-07)
    header("Location: minha_conta.php?erro=1");
}
exit;