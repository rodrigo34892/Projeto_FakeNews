<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/conexao.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
    $tipo = $_POST['tipo'];

    // Verifica se o e-mail já existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $mensagem = "<div class='alert alert-danger'>E-mail já cadastrado.</div>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nome, $email, $senha, $tipo])) {
            $mensagem = "<div class='alert alert-success'>Cadastro realizado com sucesso! <a href='tela_login.php'>Entrar</a></div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao cadastrar.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Fato ou Fruta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background: #f4f8fb; }
        .navbar { background: #0d6efd; }
        .navbar-brand img { height: 40px; margin-right: 10px; }
        .card { box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: none; }
        .footer { background: #0d6efd; color: #fff; padding: 30px 0 10px 0; }
        .footer .social-icons a { color: #fff; font-size: 1.5rem; margin: 0 10px; transition: color 0.2s; }
        .footer .social-icons a:hover { color: #ffc107; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle" style="height: 40px; margin-right: 10px;">
                <span class="fw-bold">Fato ou Fruta</span>
            </a>
        </div>
    </nav>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4" style="max-width: 400px; width: 100%;">
            <h3 class="text-center text-primary mb-3">Criar Conta</h3>
            <?= $mensagem ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome completo</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de usuário</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="leitor" selected>Leitor</option>
                        <option value="autor">Autor</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
            </form>
            <div class="text-center mt-3">
                Já tem uma conta? <a href="tela_login.php" class="text-primary">Entrar</a>
            </div>
        </div>
    </div>
    <footer class="footer mt-5">
        <div class="container text-center">
            <div class="mb-3 social-icons">
                <a href="https://instagram.com" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="https://facebook.com" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://youtube.com" target="_blank" title="YouTube"><i class="bi bi-youtube"></i></a>
                <a href="mailto:contato@fatooufruta.com" title="E-mail"><i class="bi bi-envelope"></i></a>
            </div>
            <div>
                &copy; <?php echo date('Y'); ?> Fato ou Fruta. Todos os direitos reservados.
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>