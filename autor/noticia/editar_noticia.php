<?php


session_start();
require_once '../../includes/conexao.php';

// Verifica se o usuário está logado e é autor
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'autor') {
    header("Location: ../../usuarios/tela_login.php");
    exit;
}

$mensagem = "";

// Se veio um id na URL, busca a notícia para edição
$noticia_editar = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt_editar = $pdo->prepare("SELECT * FROM noticias WHERE id = ? AND autor = ?");
    $stmt_editar->execute([$id, $_SESSION['usuario_id']]);
    $noticia_editar = $stmt_editar->fetch(PDO::FETCH_ASSOC);

    if (!$noticia_editar) {
        $mensagem = "<div class='alert alert-danger'>Notícia não encontrada ou você não tem permissão para editá-la.</div>";
    }
}

// Se enviou o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_id'])) {
    $editar_id = intval($_POST['editar_id']);
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    // Busca a notícia para pegar a imagem atual
    $stmt_img = $pdo->prepare("SELECT imagem FROM noticias WHERE id = ? AND autor = ?");
    $stmt_img->execute([$editar_id, $_SESSION['usuario_id']]);
    $dados = $stmt_img->fetch(PDO::FETCH_ASSOC);
    $imagem = $dados ? $dados['imagem'] : null;

    // Upload de nova imagem (opcional)
    if (!empty($_FILES['imagem']['name'])) {
        $nomeImagem = uniqid() . '_' . $_FILES['imagem']['name'];
        $caminho = '../../assets/imagens/noticias/' . $nomeImagem;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagem = $nomeImagem;
        }
    }

    $stmt_upd = $pdo->prepare("UPDATE noticias SET titulo = ?, conteudo = ?, imagem = ? WHERE id = ? AND autor = ?");
    if ($stmt_upd->execute([$titulo, $conteudo, $imagem, $editar_id, $_SESSION['usuario_id']])) {
        $mensagem = "<div class='alert alert-success'>Notícia atualizada com sucesso!</div>";
        header("Location: editar_noticia.php");
        exit;
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao atualizar notícia.</div>";
    }
}

// Busca todas as notícias do autor logado
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
    <title>Editar Notícias - Fato ou Fruta</title>
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
        <h1 class="mb-4 text-primary">Minhas Notícias para Editar</h1>
        <?= $mensagem ?>
        <?php if ($noticia_editar): ?>
            <div class="card mb-4 border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        <i class="bi bi-pencil-square text-primary"></i> Editar Notícia
                    </h5>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="editar_id" value="<?= $noticia_editar['id'] ?>">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo"
                                value="<?= htmlspecialchars($noticia_editar['titulo']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="conteudo" class="form-label">Texto da Notícia</label>
                            <textarea class="form-control" id="conteudo" name="conteudo" rows="6"
                                required><?= htmlspecialchars($noticia_editar['conteudo']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Imagem atual:</label><br>
                            <?php if (!empty($noticia_editar['imagem'])): ?>
                                <img src="../../assets/imagens/noticias/<?= htmlspecialchars($noticia_editar['imagem']) ?>"
                                    alt="Imagem atual" style="max-width: 100%; height: 150px; object-fit:cover;">
                            <?php else: ?>
                                <span class="text-muted">Sem imagem</span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Nova Imagem (opcional)</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-pencil-square text-white"></i> Salvar Alterações
                        </button>
                        <a href="editar_noticia.php" class="btn btn-link w-100 mt-2 text-primary">Cancelar</a>
                    </form>
                </div>
            </div>
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
                        <a href="editar_noticia.php?id=<?= $noticia['id'] ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square text-white"></i> Editar
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
                <a href="https://instagram.com" target="_blank" title="Instagram"><i
                        class="bi bi-instagram text-primary"></i></a>
                <a href="https://facebook.com" target="_blank" title="Facebook"><i
                        class="bi bi-facebook text-primary"></i></a>
                <a href="https://youtube.com" target="_blank" title="YouTube"><i
                        class="bi bi-youtube text-primary"></i></a>
                <a href="mailto:contato@fatooufruta.com" title="E-mail"><i class="bi bi-envelope text-primary"></i></a>
            </div>
            <div>
                &copy; <?php echo date('Y'); ?> Fato ou Fruta. Todos os direitos reservados.
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>