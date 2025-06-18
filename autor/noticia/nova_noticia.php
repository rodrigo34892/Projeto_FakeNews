<?php
// filepath: c:\xampp\htdocs\Projeto_FakeNews\autor\noticia\nova_noticia.php

session_start();
require_once '../../includes/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/tela_login.php");
    exit;
}

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $noticia = $_POST['noticia'];
    $autor = $_SESSION['usuario_id'];
    $imagem = null;

    // Upload da imagem (opcional)
    if (!empty($_FILES['imagem']['name'])) {
        $nomeImagem = uniqid() . '_' . $_FILES['imagem']['name'];
        $caminho = '../assets/imagens/noticias/' . $nomeImagem;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagem = $nomeImagem;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO noticias (titulo, noticia, autor, imagem) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$titulo, $noticia, $autor, $imagem])) {
        $mensagem = "<div class='alert alert-success'>Notícia cadastrada com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao cadastrar notícia.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Notícia - Fato ou Fruta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f8fb; }
        .navbar { background: #0d6efd; }
        .navbar-brand img { height: 40px; margin-right: 10px; }
        .card { box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: none; }
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
    <div class="container mt-5" style="max-width:600px;">
        <div class="card p-4">
            <h3 class="mb-3 text-primary">Nova Notícia</h3>
            <?= $mensagem ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label for="noticia" class="form-label">Texto da Notícia</label>
                    <textarea class="form-control" id="noticia" name="noticia" rows="6" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="imagem" class="form-label">Imagem (opcional)</label>
                    <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                </div>
                <button type="submit" class="btn btn-success w-100">Cadastrar Notícia</button>
            </form>
            <a href="minhas_noticias.php" class="btn btn-link mt-3">Voltar</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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