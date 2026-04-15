<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Segurança: Se não estiver logado, manda para o login (RNF-01)
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$id_cliente = $_SESSION['cliente_id'];

// Busca os dados atuais do cliente no banco (RF-W09)
$stmt = $pdo->prepare("SELECT nome, email, telefone, cpf FROM clientes WHERE id_cliente = ?");
$stmt->execute([$id_cliente]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucesso!</strong> Seus dados foram atualizados com segurança.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Erro!</strong> Não foi possível atualizar os dados. Tente novamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Dados - Nexus Celulares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; color: #240046; }
        .text-nexus { color: #240046; }
        
        /* Menu Lateral Padronizado */
        .list-group-item.active { 
            background-color: #240046 !important; 
            border-color: #240046 !important; 
        }
        .card-nexus { 
            border-radius: 15px; 
            border: none; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
        }

        /* Inputs e Botões */
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #ddd; }
        .form-control:focus { border-color: #240046; box-shadow: 0 0 0 0.25 mil rgba(36, 0, 70, 0.1); }
        
        .btn-nexus-save { 
            background-color: #FF5733 !important; 
            color: white !important; 
            border-radius: 50px; 
            padding: 12px 30px; 
            font-weight: bold; 
            border: none;
            transition: 0.3s;
        }
        .btn-nexus-save:hover { background-color: #E04B2B !important; transform: translateY(-2px); }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="list-group shadow-sm border-0 rounded-4 overflow-hidden text-start">
                    <a href="minha_conta.php" class="list-group-item list-group-item-action active py-3">
                        <i class="fa-solid fa-user-gear me-2 text-white"></i> Meus Dados
                    </a>
                    <a href="meus_pedidos.php" class="list-group-item list-group-item-action py-3">
                        <i class="fa-solid fa-box-open me-2 text-nexus"></i> Meus Pedidos
                    </a>
                    <a href="limpar.php" class="list-group-item list-group-item-action py-3 text-danger fw-bold">
                        <i class="fa-solid fa-power-off me-2"></i> Sair
                    </a>
                </div>
            </div>

            <div class="col-md-9 text-start">
                <div class="card card-nexus p-4 bg-white">
                    <h2 class="fw-bold mb-4 text-nexus">Meus Dados</h2>
                    
                    <form action="atualizar_dados.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nome Completo</label>
                                <input type="text" class="form-control bg-light" value="Teste" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">E-mail</label>
                                <input type="email" class="form-control bg-light" value="teste@teste.com" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Telefone</label>
                                <input type="text" name="telefone" class="form-control" value="1140028922">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">CPF</label>
                                <input type="text" class="form-control bg-light" value="000.000.000-00" readonly>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <h4 class="fw-bold text-nexus mb-3">Endereço de Entrega</h4>
                                <label class="form-label small fw-bold text-muted">Endereço Completo (Rua, nº, Bairro)</label>
                                <textarea name="endereco" class="form-control" rows="3" placeholder="Ex: Rua das Flores, 123 - Itaquera"></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-nexus-save shadow-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i> SALVAR ALTERAÇÕES
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../../app/views/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>