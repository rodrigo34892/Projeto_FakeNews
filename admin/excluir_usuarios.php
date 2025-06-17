<?php
// filepath: c:\xampp\htdocs\ProjetoFakeNews\usuarios\excluir_usuario.php

session_start();
require_once '../includes/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: tela_login.php");
    exit;
}

$id = $_SESSION['usuario_id'];

// Exclui o usuário e suas notícias/comentários (por causa do ON DELETE CASCADE)
$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
if ($stmt->execute([$id])) {
    // Destroi a sessão e redireciona para a tela de login
    session_destroy();
    header("Location: tela_login.php?msg=usuario_excluido");
    exit;
} else {
    echo "Erro ao excluir usuário.";
}