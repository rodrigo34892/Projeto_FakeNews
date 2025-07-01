<?php
session_start();
require_once '../includes/conexao.php';

// Só permite acesso se estiver logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/tela_login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// exclui comentário se solicitado
if (isset($_POST['excluir_comentario'], $_POST['comentario_id'])) {
    $comentario_id = intval($_POST['comentario_id']);
    // só exclui se o comentário for do usuário logado
    $stmtDel = $pdo->prepare("DELETE FROM comentarios WHERE id = ? AND usuario_id = ?");
    $stmtDel->execute([$comentario_id, $usuario_id]);
    header("Location: comentarios.php");
    exit;
}

// faz a busca de todos os comentários do usuário, junto com o título da notícia e o id do comentário
$stmt = $pdo->prepare("
    SELECT c.id, c.comentario, c.data, n.titulo, n.id AS noticia_id
    FROM comentarios c
    JOIN noticias n ON c.noticia_id = n.id
    WHERE c.usuario_id = ?
    ORDER BY c.data DESC
");
$stmt->execute([$usuario_id]);
$comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Meus Comentários - Fato ou Fruta</title>
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

        .comentario-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 16px;
            position: relative;
        }

        .comentario-data {
            font-size: 0.85em;
            color: #888;
        }

        .comentario-titulo {
            font-weight: bold;
            color: #0d6efd;
        }

        .btn-excluir-comentario {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 2px 8px;
            font-size: 0.9em;
        }

        .footer {
            background: #0d6efd;
            color: #fff;
            padding: 30px 0 10px 0;
            margin-top: 40px;
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
        .dark-mode .card,
        .dark-mode .comentario-box {
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
        .dark-mode a {
            color: #66b3ff !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle"
                    style="height: 40px; margin-right: 10px;">
                <span class="fw-bold">Fato ou Fruta</span>
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 text-primary"><i class="bi bi-chat-dots"></i> Meus Comentários</h2>
        <?php if (count($comentarios) > 0): ?>
            <?php foreach ($comentarios as $coment): ?>
                <div class="comentario-box">
                    <div class="comentario-titulo">
                        <i class="bi bi-newspaper"></i>
                        <a href="index.php#noticia-<?= $coment['noticia_id'] ?>" class="text-decoration-none text-primary">
                            <?= htmlspecialchars($coment['titulo']) ?>
                        </a>
                    </div>
                    <div class="comentario-data mb-1"><?= date('d/m/Y H:i', strtotime($coment['data'])) ?></div>
                    <div><?= nl2br(htmlspecialchars($coment['comentario'])) ?></div>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="comentario_id" value="<?= $coment['id'] ?>">
                        <button type="submit" name="excluir_comentario" class="btn btn-primary btn-sm btn-excluir-comentario"
                            onclick="return confirm('Tem certeza que deseja excluir este comentário?')">
                            <i class="bi bi-trash"></i> Excluir
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">Você ainda não fez nenhum comentário.</div>
        <?php endif; ?>
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