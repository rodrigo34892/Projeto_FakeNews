<?php
session_start();
require_once '../../includes/conexao.php';

// verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../usuarios/tela_login.php");
    exit;
}

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['noticia'];
    $autor = $_SESSION['usuario_id'];
    $imagem = null;

    // Upload da imagem (opcional)
    if (!empty($_FILES['imagem']['name'])) {
        $nomeImagem = uniqid() . '_' . $_FILES['imagem']['name'];
        $caminho = '../../assets/imagens/noticias/' . $nomeImagem;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagem = $nomeImagem;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO noticias (titulo, conteudo, autor, imagem) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$titulo, $conteudo, $autor, $imagem])) {
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
    <link rel="stylesheet" href="../../assets/css/style.css">
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
                <img src="../../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle"
                    style="height: 40px; margin-right: 10px;">
                <span class="fw-bold">Fato ou Fruta</span>
            </a>
        </div>
    </nav>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4" style="max-width: 400px; width: 100%;">
            <h3 class="text-center text-primary mb-3">Nova Notícia</h3>
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
                <button type="submit" class="btn btn-primary w-100">Cadastrar Notícia</button>
            </form>
           <a href="../../pagina/index.php" class="btn btn-link mt-3">Voltar</a>
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