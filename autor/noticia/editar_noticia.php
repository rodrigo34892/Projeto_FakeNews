<?php
session_start();
require_once '../../includes/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/tela_login.php");
    exit;
}

// Obtém o ID da notícia
if (!isset($_GET['id'])) {
    echo "Notícia não encontrada.";
    exit;
}

$id = intval($_GET['id']);
$mensagem = "";

// Busca a notícia
$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ? AND autor = ?");
$stmt->execute([$id, $_SESSION['usuario_id']]);
$noticia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$noticia) {
    echo "Notícia não encontrada ou você não tem permissão para editá-la.";
    exit;
}

// Atualiza a notícia se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $texto = $_POST['noticia'];
    $imagem = $noticia['imagem'];

    // Upload de nova imagem (opcional)
    if (!empty($_FILES['imagem']['name'])) {
        $nomeImagem = uniqid() . '_' . $_FILES['imagem']['name'];
        $caminho = '../assets/imagens/noticias/' . $nomeImagem;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagem = $nomeImagem;
        }
    }

    $stmt = $pdo->prepare("UPDATE noticias SET titulo = ?, noticia = ?, imagem = ? WHERE id = ? AND autor = ?");
    if ($stmt->execute([$titulo, $texto, $imagem, $id, $_SESSION['usuario_id']])) {
        $mensagem = "<div class='alert alert-success'>Notícia atualizada com sucesso!</div>";
        // Atualiza os dados exibidos
        $noticia['titulo'] = $titulo;
        $noticia['noticia'] = $texto;
        $noticia['imagem'] = $imagem;
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao atualizar notícia.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Notícia - Fato ou Fruta</title>
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
            <h3 class="mb-3 text-primary">Editar Notícia</h3>
            <?= $mensagem ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($noticia['titulo']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="noticia" class="form-label">Texto da Notícia</label>
                    <textarea class="form-control" id="noticia" name="noticia" rows="6" required><?= htmlspecialchars($noticia['noticia']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagem atual:</label><br>
                    <?php if (!empty($noticia['imagem'])): ?>
                        <img src="../assets/imagens/noticias/<?= htmlspecialchars($noticia['imagem']) ?>" alt="Imagem atual" style="max-width: 100%; height: 150px; object-fit:cover;">
                    <?php else: ?>
                        <span class="text-muted">Sem imagem</span>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="imagem" class="form-label">Nova Imagem (opcional)</label>
                    <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
            </form>
            <a href="minhas_noticias.php" class="btn btn-link mt-3">Voltar</a>
        </div>
    </div>
    <script src=""