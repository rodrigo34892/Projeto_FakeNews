<?php
session_start();
require_once '../includes/conexao.php';

// faz verificação de permissão de administrador
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: ../pagina/index.php');
    exit;
}

// total arrecadado com anúncios ativos
$stmtValor = $pdo->query("SELECT SUM(valorAnuncio) AS total FROM anuncio WHERE ativo = 1");
$totalArrecadado = $stmtValor->fetchColumn();
if ($totalArrecadado === null)
    $totalArrecadado = 0;

// total de usuários cadastrados
$stmtUsuarios = $pdo->query("SELECT COUNT(*) FROM usuarios");
$totalUsuarios = $stmtUsuarios->fetchColumn();

// Lista de usuários
$stmtListaUsuarios = $pdo->query("SELECT nome, email, tipo FROM usuarios");

// Lista de anúncios
$stmtListaAnuncios = $pdo->query("SELECT nome, valorAnuncio, ativo, destaque, data_cadastro FROM anuncio ORDER BY data_cadastro DESC");
?>


if (password_verify($senha, PASSWORD_BCRYPT){
    //ok
}