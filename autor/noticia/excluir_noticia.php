<?php
session_start();
require_once '../../includes/conexao.php';

// faz a verificação se o usuário está logado e é autor
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'autor') {
    header("Location: ../../usuarios/tela_login.php");
    exit;
}

// se recebeu o id para excluir
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    // verifica se a notícia pertence ao usuário logado
    $stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ? AND autor = ?");
    $stmt->execute([$id, $_SESSION['usuario_id']]);
    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($noticia) {
        // Exclui a imagem, se houver
        if (!empty($noticia['imagem'])) {
            $caminhoImagem = '../../assets/imagens/noticias/' . $noticia['imagem'];
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
        }
        // exclui a notícia
        $stmt = $pdo->prepare("DELETE FROM noticias WHERE id = ? AND autor = ?");
        $stmt->execute([$id, $_SESSION['usuario_id']]);
        $msg = "Notícia excluída com sucesso!";
    } else {
        $msg = "Notícia não encontrada ou você não tem permissão para excluí-la.";
    }
}

// busca todas as notícias do autor logado
$stmt = $pdo->prepare("SELECT n.id, n.titulo, n.conteudo, n.imagem, u.nome AS autor_nome
                       FROM noticias n
                       JOIN usuarios u ON n.autor = u.id
                       WHERE n.autor = ?
                       ORDER BY n.id DESC");
$stmt->execute([$_SESSION['usuario_id']]);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Excluir Notícias - Fato ou Fruta</title>
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

        .card-img-top {
            max-height: 300px;
            object-fit: cover;
            width: 100%;
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
                <img src="../../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle"
                    style="height: 40px; margin-right: 10px;">
                <span class="fw-bold">Fato ou Fruta</span>
            </a>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="mb-4 text-primary">Minhas Notícias para Excluir</h1>
        <?php if (!empty($msg)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <?php if ($stmt->rowCount() > 0): ?>
            <?php while ($noticia = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="card mb-4">
                    <?php if (!empty($noticia['imagem'])): ?>
                        <img src="../../assets/imagens/noticias/<?= htmlspecialchars($noticia['imagem']) ?>" class="card-img-top"
                            alt="Imagem da notícia">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($noticia['conteudo'])) ?></p>
                        <p class="card-text"><small class="text-muted">Por
                                <?= htmlspecialchars($noticia['autor_nome']) ?></small></p>
                        <a href="excluir_noticia.php?excluir=<?= $noticia['id'] ?>" class="btn btn-primary btn-sm"
                            onclick="return confirm('Tem certeza que deseja excluir esta notícia?');">
                            <i class="bi bi-trash text-white"></i> Excluir
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Você ainda não cadastrou nenhuma notícia.</p>
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