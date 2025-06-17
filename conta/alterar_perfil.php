<?php
// filepath: c:\xampp\htdocs\ProjetoFakeNews\usuarios\alterar_perfil.php

session_start();
require_once '../includes/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: tela_login.php");
    exit;
}

$id = $_SESSION['usuario_id'];
$mensagem = "";

// Busca os dados atuais do usuário
$stmt = $pdo->prepare("SELECT nome, email FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuário não encontrado.";
    exit;
}

// Atualiza os dados se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Verifica se o e-mail já está em uso por outro usuário
    $stmtEmail = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
    $stmtEmail->execute([$email, $id]);
    if ($stmtEmail->fetch()) {
        $mensagem = "<div class='alert alert-danger'>E-mail já está em uso por outro usuário.</div>";
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
        if ($stmt->execute([$nome, $email, $id])) {
            $mensagem = "<div class='alert alert-success'>Perfil atualizado com sucesso!</div>";
            $usuario['nome'] = $nome;
            $usuario['email'] = $email;
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao atualizar perfil.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Perfil - Fato ou Fruta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f8fb; }
        .navbar { background: #0d6efd; }
        .navbar-brand img { height: 40px; margin-right: 10px; }
        .card { box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: none; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../assets/imagens/logo.png" alt="Logo" class="rounded-circle" style="height: 40px; margin-right: 10px;">
                <span class="fw-bold">Fato ou Fruta</span>
            </a>
        </div>
    </nav>
    <div class="container mt-5" style="max-width:500px;">
        <div class="card p-4">
            <h3 class="mb-3 text-primary">Alterar Perfil</h3>
            <?= $mensagem ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
            </form>
            <a href="../sistema/dashboard.php" class="btn btn-link mt-3">Voltar ao painel</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>