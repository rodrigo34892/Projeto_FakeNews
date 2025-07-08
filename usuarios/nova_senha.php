<?php
require_once '../includes/conexao.php';
require_once '../includes/funcoes.php';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $codigo = $_POST['codigo'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($nova_senha !== $confirmar_senha) {
        $mensagem = '<div class="alert alert-danger">As senhas não coincidem.</div>';
    } else {
        // Verifica se o código está correto
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND codigo_verificacao = ?");
        $stmt->execute([$email, $codigo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Atualiza a senha e limpa o código de verificação
            $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE usuarios SET senha = ?, codigo_verificacao = NULL WHERE id = ?");
            if ($stmt->execute([$senha_hash, $usuario['id']])) {
                $mensagem = '<div class="alert alert-success">Senha alterada com sucesso! <a href="tela_login.php" class="text-primary">Entrar</a></div>';
            } else {
                $mensagem = '<div class="alert alert-danger">Erro ao atualizar senha. Tente novamente.</div>';
            }
        } else {
            $mensagem = '<div class="alert alert-danger">Código de verificação ou e-mail inválido.</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Nova Senha - Fato ou Fruta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ícones Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background: #f4f8fb;
        }

        .navbar {
            background: #0d6efd;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .card {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .footer {
            background: #0d6efd;
            color: #fff;
            padding: 30px 0 10px 0;
        }

        .footer .social-icons a {
            color: #fff;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: color 0.2s;
        }

        .footer .social-icons a:hover {
            color: #ffc107;
        }

        /* Dark mode */
        .dark-mode {
            background: #181a1b !important;
            color: #f1f1f1 !important;
        }

        .dark-mode .card {
            background: #23272b !important;
            color: #f1f1f1 !important;
        }

        .dark-mode .navbar,
        .dark-mode .footer {
            background: #111 !important;
        }

        .dark-mode .form-control,
        .dark-mode .btn {
            background: #23272b !important;
            color: #f1f1f1 !important;
            border-color: #444 !important;
        }

        .dark-mode .navbar-brand,
        .dark-mode .navbar-brand span {
            color: #f1f1f1 !important;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="../pagina/index.php">
                <img src="../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle"
                    style="height: 40px; margin-right: 10px;">
                <span class="fw-bold">Fato ou Fruta</span>
            </a>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4" style="max-width: 400px; width: 100%;">
            <h3 class="text-center text-primary mb-3">Definir Nova Senha</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail cadastrado:</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="codigo" class="form-label">Código de verificação:</label>
                    <input type="text" class="form-control" name="codigo" required>
                </div>
                <div class="mb-3">
                    <label for="nova_senha" class="form-label">Nova senha:</label>
                    <input type="password" class="form-control" name="nova_senha" required>
                </div>
                <div class="mb-3">
                    <label for="confirmar_senha" class="form-label">Confirmar nova senha:</label>
                    <input type="password" class="form-control" name="confirmar_senha" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Alterar Senha</button>
            </form>
            <div class="mt-3"><?= $mensagem ?></div>
            <div class="text-center mt-3">
                Lembrou a senha? <a href="tela_login.php" class="text-primary">Entrar</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
    <script>
        // Dark mode automático e persistente
        function aplicarTemaInicial() {
            const temaSalvo = localStorage.getItem('tema');
            if (temaSalvo) {
                document.body.classList.toggle('dark-mode', temaSalvo === 'dark');
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.body.classList.add('dark-mode');
            }
        }
        document.addEventListener('DOMContentLoaded', aplicarTemaInicial);
    </script>
</body>

</html>