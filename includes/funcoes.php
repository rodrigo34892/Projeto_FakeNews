<?php
// filepath: c:\xampp\htdocs\ProjetoFakeNews\includes\funcoes.php

function gerarCodigoVerificacao($pdo, $email) {
    $codigo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
    $stmt = $pdo->prepare("UPDATE usuarios SET codigo_verificacao = ? WHERE email = ?");
    $stmt->execute([$codigo, $email]);
    return ($stmt->rowCount() > 0) ? $codigo : false;
}

function verificarCodigo($pdo, $codigo) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE codigo_verificacao = ?");
    $stmt->execute([$codigo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function redefinirSenha($pdo, $codigo, $senha) {
    $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = ?, codigo_verificacao = NULL WHERE codigo_verificacao = ?");
    $stmt->execute([$hashed_password, $codigo]);
    return $stmt->rowCount() > 0;
}