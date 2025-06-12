<?php
session_start();
require_once '../includes/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Fato ou Fruta - Portal de Notícias</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background: #0d6efd;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        .card {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: none;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px) scale(1.01);
        }
        .card-title {
            color: #0d6efd;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../assets/imagens/logo.png" alt="Logo">
                <span class="fw-bold">Fato ou Fruta</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="../usuarios/tela_login.php">Entrar</a></li>
                    <li class="nav-item"><a class="nav-link" href="../usuarios/tela_cadastro.php">Cadastrar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container mt-5">
        <h1 class="mb-4 text-primary">Últimas Notícias</h1>
        <div class="row">
            <?php
            $stmt = $pdo->query("SELECT n.*, u.nome AS autor_nome FROM noticias n JOIN usuarios u ON n.autor = u.id ORDER BY n.data DESC");
            $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($noticias) === 0): ?>
                <div class="col-12">
                    <div class="alert alert-info">Nenhuma notícia cadastrada ainda.</div>
                </div>
            <?php endif; ?>

            <?php foreach ($noticias as $noticia): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($noticia['imagem'])): ?>
                            <img src="../assets/imagens/noticias/<?= htmlspecialchars($noticia['imagem']) ?>" class="card-img-top" alt="Imagem da notícia" style="height:220px;object-fit:cover;">
                        <?php else: ?>
                            <img src="../assets/imagens/logo.png" class="card-img-top" alt="Sem imagem" style="height:220px;object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']) ?></h5>
                            <p class="card-text mb-2"><?= substr(strip_tags($noticia['noticia']), 0, 120) ?>...</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <small class="text-muted">
                                Por <?= htmlspecialchars($noticia['autor_nome']) ?> em <?= date('d/m/Y H:i', strtotime($noticia['data'])) ?>
                            </small>
                            <a href="../noticia.php?id=<?= $noticia['id'] ?>" class="btn btn-outline-primary btn-sm float-end">Ler mais</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Seção de Comentários -->
    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-chat-dots"></i> Comentários
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <!-- Formulário de comentário para usuários logados -->
                    <form action="processa_comentario.php" method="POST">
                        <div class="mb-3">
                            <label for="comentario" class="form-label">Deixe seu comentário:</label>
                            <textarea class="form-control" id="comentario" name="comentario" rows="3" placeholder="Digite seu comentário aqui..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Comentar</button>
                    </form>
                    <hr>
                <?php else: ?>
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-circle"></i>
                        Faça <a href="../usuarios/tela_login.php" class="text-primary">login</a> para comentar.
                    </div>
                    <hr>
                <?php endif; ?>

                <!-- Lista de comentários (tem que  trocar pelo nosso foreach do banco depois) -->
                <div class="mb-2">
                    <strong>Maria:</strong> Muito boa a notícia! <br>
                    <small class="text-muted">11/06/2025 14:30</small>
                </div>
                <div class="mb-2">
                    <strong>João:</strong> Parabéns pela matéria. <br>
                    <small class="text-muted">11/06/2025 13:10</small>
                </div>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>