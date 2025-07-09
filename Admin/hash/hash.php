<?php


// hash da senha de adminstrador 
$senha = 'admin@2025';
$hash = password_hash($senha, PASSWORD_BCRYPT);

echo "Hash gerado:" . $hash;
?>