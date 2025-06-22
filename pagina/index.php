<?php
session_start();
require_once '../includes/conexao.php';

// Lógica para inserir comentário (deve ser antes do HTML!)
if (isset($_POST['comentar'], $_POST['comentario'], $_POST['noticia_id']) && isset($_SESSION['usuario_id'])) {
    $comentario = trim($_POST['comentario']);
    $noticia_id = intval($_POST['noticia_id']);
    if ($comentario !== '') {
        $stmtInsere = $pdo->prepare("INSERT INTO comentarios (noticia_id, usuario_id, comentario) VALUES (?, ?, ?)");
        $stmtInsere->execute([$noticia_id, $_SESSION['usuario_id'], $comentario]);
        // Redireciona para evitar repost em refresh
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Fato ou Fruta - Portal de Notícias</title>
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
            margin-top: auto;
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

        .comentario-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 8px;
        }

        .comentario-nome {
            font-weight: bold;
            color: #0d6efd;
        }

        .comentario-data {
            font-size: 0.85em;
            color: #888;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <li class="nav-item">
                            <span class="nav-link">Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../conta/alterar_perfil.php">
                                <i class="bi bi-person"></i> Alterar Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../usuarios/alterar_senha.php">
                                <i class="bi bi-key"></i> Alterar Senha
                            </a>
                        </li>
                        <?php if ($_SESSION['usuario_tipo'] === 'autor'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../autor/noticia/nova_noticia.php">
                                    <i class="bi bi-plus-circle"></i> Cadastrar Notícia
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../autor/noticia/editar_noticia.php">
                                    <i class="bi bi-pencil-square"></i> Editar Notícia
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../autor/noticia/excluir_noticia.php">
                                    <i class="bi bi-trash"></i> Excluir Notícia
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../autor/noticia/dashbord.php">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="comentarios.php">
                                <i class="bi bi-chat-dots"></i> Comentários
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../usuarios/logout.php">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../usuarios/tela_login.php">
                                <i class="bi bi-box-arrow-in-right"></i> Entrar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../usuarios/tela_cadastro.php">
                                <i class="bi bi-person-plus"></i> Cadastrar
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container mt-5">
        <h1 class="mb-4 text-primary">Últimas Notícias</h1>
        <?php
        // Busca e exibe as notícias cadastradas
        $stmt = $pdo->query("SELECT n.id, n.titulo, n.conteudo, n.imagem, u.nome AS autor_nome
                         FROM noticias n
                         JOIN usuarios u ON n.autor = u.id
                         ORDER BY n.id DESC");
        if ($stmt->rowCount() > 0):
            while ($noticia = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                <div class="card mb-4">
                    <?php if (!empty($noticia['imagem'])): ?>
                        <img src="../assets/imagens/noticias/<?= htmlspecialchars($noticia['imagem']) ?>" class="card-img-top"
                            alt="Imagem da notícia">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($noticia['conteudo'])) ?></p>
                        <p class="card-text"><small class="text-muted">Por
                                <?= htmlspecialchars($noticia['autor_nome']) ?></small></p>
                        <!-- Comentários -->
                        <hr>
                        <h6 class="mb-2"><i class="bi bi-chat-dots"></i> Comentários</h6>
                        <?php
                        // Busca comentários da notícia
                        $stmtComentarios = $pdo->prepare("SELECT c.comentario, c.data, u.nome FROM comentarios c JOIN usuarios u ON c.usuario_id = u.id WHERE c.noticia_id = ? ORDER BY c.data DESC");
                        $stmtComentarios->execute([$noticia['id']]);
                        if ($stmtComentarios->rowCount() > 0):
                            while ($coment = $stmtComentarios->fetch(PDO::FETCH_ASSOC)):
                                ?>
                                <div class="comentario-box mb-2">
                                    <span class="comentario-nome"><?= htmlspecialchars($coment['nome']) ?></span>
                                    <span class="comentario-data float-end"><?= date('d/m/Y H:i', strtotime($coment['data'])) ?></span>
                                    <div><?= nl2br(htmlspecialchars($coment['comentario'])) ?></div>
                                </div>
                                <?php
                            endwhile;
                        else:
                            echo "<div class='text-muted'>Nenhum comentário ainda.</div>";
                        endif;
                        ?>
                        <!-- Formulário de novo comentário -->
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <form method="post" action="">
                                <div class="input-group mt-2">
                                    <input type="hidden" name="noticia_id" value="<?= $noticia['id'] ?>">
                                    <input type="text" name="comentario" class="form-control" placeholder="Escreva um comentário..."
                                        required maxlength="500">
                                    <button class="btn btn-primary" type="submit" name="comentar"><i
                                            class="bi bi-send"></i></button>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="text-muted mt-2">Faça <a href="../usuarios/tela_login.php">login</a> para comentar.</div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            endwhile;
        else:
            echo "<p>Nenhuma notícia cadastrada ainda.</p>";
        endif;
        ?>
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