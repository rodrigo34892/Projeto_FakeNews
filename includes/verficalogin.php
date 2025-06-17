<?php
// filepath: c:\xampp\htdocs\ProjetoFakeNews\includes\verificarlogin.php

session_start();
require_once 'conexao.php';

function verificarLogin($email, $senha, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login válido, salva dados na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
        return true;
    }