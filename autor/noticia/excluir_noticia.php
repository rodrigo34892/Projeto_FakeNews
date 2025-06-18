<?php
// filepath: c:\xampp\htdocs\ProjetoFakeNews\noticias\excluir_noticia.php

session_start();
require_once '../../includes/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/tela_login.php");
    exit;
}

// Verifica se o ID da notícia foi enviado
if (!isset($_GET['id'])) {
    echo "Notícia não encontrada.";
    exit;
}

$id = intval($_GET['id']);

// Verifica se a notícia pertence ao usuário logado
$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ? AND autor = ?");
$stmt->execute([$id, $_SESSION['usuario_id']]);
$noticia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$noticia) {
    echo "Notícia não encontrada ou você não tem permissão para excluí-la.";
    exit;
}

// Exclui a notícia
$stmt = $pdo->prepare("DELETE FROM noticias WHERE id = ? AND autor = ?");
if ($stmt->execute([$id, $_SESSION['usuario_id']])) {
    header("Location: minhas_noticias.php?msg=excluida");
    exit;
} else {
    echo "Erro ao