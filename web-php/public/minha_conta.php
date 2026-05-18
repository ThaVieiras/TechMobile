<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

// Salva as alterações quando o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['nome']);
    $telefone = trim($_POST['telefone'] ?? '');
    $cpf      = trim($_POST['cpf'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    $stmt = $pdo->prepare("UPDATE clientes 
                           SET nome = ?, telefone = ?, cpf = ?, endereco = ? 
                           WHERE id_cliente = ?");
    $stmt->execute([$nome, $telefone, $cpf, $endereco, $_SESSION['cliente_id']]);

    // Atualiza o nome na sessão imediatamente
    $_SESSION['cliente_nome'] = $nome;
    $salvo = true;
}

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
$stmt->execute([$_SESSION['cliente_id']]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMobile - Minha Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <?php include __DIR__ . '/../../app/views/header.php'; ?>

    <main class="container my-5">
        <div class="row g-4">

            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <i class="fa-solid fa-circle-user fa-4x text-techmobile mb-3"></i>
                    <h5 class="fw-bold text-techmobile"><?php echo $cliente['nome']; ?></h5>
                    <p class="text-muted small mb-3"><?php echo $cliente['email']; ?></p>
                    <hr class="opacity-25">
                    <div class="d-grid gap-2">
                        <a href="meus_pedidos.php" class="btn btn-outline-techmobile btn-sm">
                            <i class="fa-solid fa-box me-2"></i> Meus Pedidos
                        </a>
                        <a href="favoritos.php" class="btn btn-outline-techmobile btn-sm">
                            <i class="fa-regular fa-heart me-2"></i> Favoritos
                        </a>
                        <a href="limpar.php" class="btn btn-outline-danger btn-sm rounded-pill">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Sair
                        </a>
                    </div>
                </div>
            </div>

            <!-- Dados da Conta -->
            <div class="col-md-9">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold text-techmobile border-bottom pb-3 mb-4">
                        <i class="fa-solid fa-user me-2"></i> Dados da Conta
                    </h5>

                    <?php if (isset($salvo)): ?>
                        <div class="alert alert-success rounded-3 small mb-4">
                            <i class="fa-solid fa-circle-check me-2"></i> Dados atualizados com sucesso!
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Nome</label>
                                <input type="text" name="nome" class="form-control rounded-pill px-4"
                                    value="<?php echo htmlspecialchars($cliente['nome']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">CPF</label>
                                <input type="text" name="cpf" class="form-control rounded-pill px-4"
                                    value="<?php echo htmlspecialchars($cliente['cpf'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">E-mail</label>
                                <input type="email" class="form-control rounded-pill px-4 bg-light"
                                    value="<?php echo htmlspecialchars($cliente['email']); ?>" disabled>
                                <small class="text-muted">O e-mail não pode ser alterado.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Endereço</label>
                                <input type="text" name="endereco" class="form-control rounded-pill px-4"
                                    value="<?php echo htmlspecialchars($cliente['endereco'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Telefone</label>
                                <input type="text" name="telefone" class="form-control rounded-pill px-4"
                                    value="<?php echo htmlspecialchars($cliente['telefone'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Membro desde</label>
                                <p class="fw-bold pt-2">
                                    <?php echo date('d/m/Y', strtotime($cliente['criado_em'] ?? 'now')); ?>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="minha_conta.php" class="btn btn-outline-techmobile px-4 py-2">
                                <i class="fa-solid fa-xmark me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-techmobile px-4 py-2">
                                <i class="fa-solid fa-check me-2"></i> Salvar Alterações
                            </button>
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