<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// 1 - Validação de Segurança
if (empty($_SESSION['carrinho'])) {
    header("Location: produtos.php");
    exit;
}

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php?erro=checkout_login");
    exit;
}

// Definindo variáveis que o SQL vai usar
$id_cliente = $_SESSION['cliente_id'];
$id_status_novo = 1; // ID 1 costuma ser 'Novo/Pendente' no banco

try {
    $pdo->beginTransaction(); 

    // 2 - Calcular total geral (RN-04)
    $total_geral = 0;
    $ids = array_keys($_SESSION['carrinho']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    
    $stmt = $pdo->prepare("SELECT id_produto, preco FROM produtos WHERE id_produto IN ($placeholders)");
    $stmt->execute($ids);
    $produtos_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $precos = [];
    foreach ($produtos_info as $p) {
        $precos[$p['id_produto']] = $p['preco'];
        $total_geral += $p['preco'] * $_SESSION['carrinho'][$p['id_produto']];
    }

    // 3 - Inserir Pedido (RF-W07)
    // usando id_status_pedido conforme DER provável
    $sqlPedido = "INSERT INTO pedidos (id_cliente, id_status, data_pedido, valor_total, atualizado_em) 
                  VALUES (?, ?, NOW(), ?, NOW())";
    $stmtPedido = $pdo->prepare($sqlPedido);
    $stmtPedido->execute([$id_cliente, $id_status_novo, $total_geral]);
    $id_pedido = $pdo->lastInsertId();

    // 4 - Inserir Itens e Baixar Estoque
    $stmtItem = $pdo->prepare("INSERT INTO itens_pedidos (id_pedido, id_produto, quantidade, preco_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
    $stmtEstoque = $pdo->prepare("UPDATE estoque SET quantidade_atual = quantidade_atual - ?, atualizado_em = NOW() WHERE id_produto = ?");

    foreach ($_SESSION['carrinho'] as $id_prod => $qtd) {
        $sub = $precos[$id_prod] * $qtd;
        $stmtItem->execute([$id_pedido, $id_prod, $qtd, $precos[$id_prod], $sub]);
        $stmtEstoque->execute([$qtd, $id_prod]);
    }

    $pdo->commit(); 
    unset($_SESSION['carrinho']); // Carrinho limpo com sucesso!

    // Redirecionamento para a página de sucesso 
    header("Location: sucesso.php?id=" . $id_pedido);
    exit;

} catch (Exception $e) {
    $pdo->rollBack(); 
    die("Erro Crítico no Checkout: " . $e->getMessage());
}