<?php
session_start();
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
        body { background: #f4f8fb; }
        .navbar { background: #0d6efd; }
        .navbar-brand img { height: 40px; margin-right: 10px; }
        .footer { background: #0d6efd; color: #fff; padding: 30px 0 10px 0; margin-top: auto; }
        .footer .social-icons a { color: #fff; font-size: 1.5rem; margin: 0 10px; transition: color 0.2s; }
        .footer .social-icons a:hover { color: #ffc107; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="assets/imagens/logo.png" alt="Logo" class="rounded-circle" style="height: 40px; margin-right: 10px;">
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
                        <a class="nav-link" href="conta/alterar_perfil.php">
                            <i class="bi bi-person"></i> Alterar Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios/alterar_senha.php">
                            <i class="bi bi-key"></i> Alterar Senha
                        </a>
                    </li>
                    <?php if ($_SESSION['usuario_tipo'] === 'autor'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="autor/noticia/nova_noticia.php">
                                <i class="bi bi-plus-circle"></i> Cadastrar Notícia
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="autor/noticia/editar_noticias.php">
                                <i class="bi bi-pencil-square"></i> Editar Notícia
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="autor/noticia/excluir_noticias.php">
                                <i class="bi bi-trash"></i> Excluir Notícia
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="autor/noticia/dashboard.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios/logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios/tela_login.php">
                            <i class="bi bi-box-arrow-in-right"></i> Entrar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios/tela_cadastro.php">
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
    <!-- Aqui você pode colocar o conteúdo principal da sua página -->
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