<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../usuarios/tela_login.php");
    exit;
}
require_once '../../includes/conexao.php';

// Buscar dados do usuário logado
$stmt = $pdo->prepare("SELECT nome, email, tipo FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Fato ou Fruta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ícones Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle" style="height: 40px; margin-right: 10px;">
                <span class="fw-bold">Fato ou Fruta</span>
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 text-primary">Bem-vindo, <?= htmlspecialchars($usuario['nome']) ?>!</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card p-3">
                    <h5 class="card-title"><i class="bi bi-person"></i> Seus Dados</h5>
                    <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']) ?></p>
                    <p><strong>E-mail:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
                    <p><strong>Tipo:</strong> <?= htmlspecialchars($usuario['tipo']) ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card p-3">
                    <h5 class="card-title"><i class="bi bi-newspaper"></i> Minhas Notícias</h5>
                    <a href="../../noticias/minhas_noticias.php" class="btn btn-primary btn-sm w-100 mb-2">Ver minhas notícias</a>
                    <a href="../../noticias/cadastrar_noticia.php" class="btn btn-primary btn-sm w-100" style="background-color: #0d6efd; border-color: #0d6efd;">Cadastrar nova notícia</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card p-3">
                    <h5 class="card-title"><i class="bi bi-chat-dots"></i> Comentários</h5>
                    <a href="../../comentarios/meus_comentarios.php" class="btn btn-primary btn-sm w-100">Ver meus comentários</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>