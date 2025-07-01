<?php

session_start();
require_once '../includes/conexao.php';

// verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: tela_login.php");
    exit;
}

$id = $_SESSION['usuario_id'];
$mensagem = "";

// faz a busca dos dados atuais do usuário
$stmt = $pdo->prepare("SELECT nome, email FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuário não encontrado.";
    exit;
}

// atualiza os dados se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // verifica se o email já está sendo usado por outro usuário
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
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle"
                    style="height: 40px; margin-right: 10px;">
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
                    <input type="text" class="form-control" id="nome" name="nome"
                        value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
            </form>
            <a href="../pagina/index.php" class="btn btn-link mt-3">Voltar ao painel</a>
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