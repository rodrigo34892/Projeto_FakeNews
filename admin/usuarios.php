<?php
// filepath: c:\xampp\htdocs\ProjetoFakeNews\usuarios\usuarios.php

session_start();
require_once '../includes/conexao.php';

// Apenas admin pode acessar esta página
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: tela_login.php");
    exit;
}

// Buscar todos os usuários
$stmt = $pdo->query("SELECT id, nome, email, tipo FROM usuarios ORDER BY nome");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Usuários - Fato ou Fruta</title>
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
    <div class="container mt-5">
        <div class="card p-4">
            <h3 class="mb-3 text-primary">Lista de Usuários</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['nome']) ?></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td><?= htmlspecialchars($usuario['tipo']) ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                            <?php if ($usuario['id'] != $_SESSION['usuario_id']): ?>
                                <a href="excluir_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?')"><i class="bi bi-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <a href="../sistema/dashboard.php" class="btn btn-link mt-3">Voltar ao painel</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>