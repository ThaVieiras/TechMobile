<?php
session_start();
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos - Nexus Celulares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; }
        .text-nexus { color: #240046; }
        .list-group-item.active { background-color: #240046 !important; border-color: #240046 !important; }
        .btn-outline-nexus { 
            color: #240046; 
            border: 2px solid #240046; 
            border-radius: 50px; 
            font-weight: bold; 
            text-decoration: none;
        }
        .btn-outline-nexus:hover { background-color: #240046; color: white; }
        .badge-status { 
            background-color: #FF5733; 
            color: white; 
            border-radius: 50px; 
            padding: 6px 16px; 
            font-size: 0.85rem;
        }
        .card-pedidos { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .btn-nexus-buy { background-color: #FF5733; color: white; border-radius: 50px; padding: 10px 25px; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="list-group shadow-sm border-0 rounded-4 overflow-hidden">
                    <a href="minha_conta.php" class="list-group-item list-group-item-action py-3">
                        <i class="fa-solid fa-user-gear me-2 text-nexus"></i> Meus Dados
                    </a>
                    <a href="meus_pedidos.php" class="list-group-item list-group-item-action active py-3">
                        <i class="fa-solid fa-box-open me-2"></i> Meus Pedidos
                    </a>
                    <a href="limpar.php" class="list-group-item list-group-item-action py-3 text-danger fw-bold">
                        <i class="fa-solid fa-power-off me-2"></i> Sair
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card card-pedidos p-4 bg-white">
                    <h2 class="fw-bold mb-4 text-nexus">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i>Histórico de Pedidos
                    </h2>

                    <?php if (isset($pedidos) && count($pedidos) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Pedido</th>
                                        <th>Data</th>
                                        <th>Total</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end pe-4">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pedidos as $ped): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-nexus">#<?php echo $ped['id_pedido']; ?></td>
                                            <td class="small text-muted"><?php echo date('d/m/Y', strtotime($ped['data_pedido'])); ?></td>
                                            <td class="fw-bold">R$ <?php echo number_format($ped['valor_total'], 2, ',', '.'); ?></td>
                                            <td class="text-center">
                                                <span class="badge badge-status"><?php echo $ped['nome_status']; ?></span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="detalhe_pedido.php?id=<?php echo $ped['id_pedido']; ?>" class="btn btn-outline-nexus btn-sm px-3">
                                                    Ver Detalhes
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted mb-3">Nenhum pedido encontrado em sua conta.</h5>
                            <a href="produtos.php" class="btn btn-nexus-buy">
                                <i class="fa-solid fa-shop me-2"></i>Explorar Produtos
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



<!--<h2 class="fw-bold mb-4 text-nexus">Histórico de Pedidos</h2>

<td class="text-nexus fw-bold">R$ //<?//php echo number_format($ped['valor_total'], 2, ',', '.'); ?>//</td>
<td><span class="badge badge-status"><?//php echo $ped['nome_status']; ?></span></td>
<td>
    <a href="detalhe_pedido.php?id=////php echo $ped['id_pedido']; ?>" class="btn btn-outline-nexus btn-sm px-3">Ver Detalhes</a>
</td>-->