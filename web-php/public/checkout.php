<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Validação de Segurança 
if (empty($_SESSION['carrinho'])) {
    header("Location: produtos.php");
    exit;
}

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php?erro=checkout_login");
    exit;
}

$id_cliente = $_SESSION['cliente_id'];
$id_status_novo = 1; 

try {
    $pdo->beginTransaction(); 

    // Calcular total (O preço vem do Banco, não da Sessão - Segurança!)
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

    // Inserir Pedido 
    $sqlPedido = "INSERT INTO pedidos (id_cliente, id_status, data_pedido, valor_total, atualizado_em) 
                  VALUES (?, ?, NOW(), ?, NOW())";
    $stmtPedido = $pdo->prepare($sqlPedido);
    $stmtPedido->execute([$id_cliente, $id_status_novo, $total_geral]);
    $id_pedido = $pdo->lastInsertId();

    // Inserir Itens e Baixar Estoque
    $stmtItem = $pdo->prepare("INSERT INTO itens_pedidos (id_pedido, id_produto, quantidade, preco_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
    // QA: A tabela de estoque usa id_produto
    $stmtEstoque = $pdo->prepare("UPDATE estoque SET quantidade_atual = quantidade_atual - ?, atualizado_em = NOW() WHERE id_produto = ?");

    foreach ($_SESSION['carrinho'] as $id_prod => $qtd) {
        $sub = $precos[$id_prod] * $qtd;
        $stmtItem->execute([$id_pedido, $id_prod, $qtd, $precos[$id_prod], $sub]);
        $stmtEstoque->execute([$qtd, $id_prod]);
    }

    $pdo->commit(); 
    unset($_SESSION['carrinho']); 

    // Redirecionamento para a página de sucesso 
    header("Location: sucesso.php?id=" . $id_pedido);
    exit;

} catch (Exception $e) {
    $pdo->rollBack(); 
    // Erro estilizado com as cores da Nexus
    include __DIR__ . '/../../app/views/header.php';
    echo "
    <div class='container my-5 text-center'>
        <div class='card border-0 shadow-lg p-5 rounded-4'>
            <h1 class='display-1'>⚠️</h1>
            <h2 style='color: #240046; font-weight: bold;'>Ops! Algo deu errado.</h2>
            <p class='text-muted'>Não conseguimos processar sua energia agora. Por favor, tente novamente.</p>
            <a href='carrinho.php' class='btn px-5 py-3 mt-3' style='background: #FF5733; color: white; border-radius: 50px; font-weight: bold;'>VOLTAR AO CARRINHO</a>
            <p class='small text-danger mt-4'>Código do erro: " . $e->getMessage() . "</p>
        </div>
    </div>";
    include __DIR__ . '/../../app/views/footer.php';
    exit;
}