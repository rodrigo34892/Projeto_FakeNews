<?php
require_once '../includes/conexao.php';
session_start();

$mensagem = '';

// faz o processamento  do formulário de anúncio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $link = trim($_POST['link']);
    $valor = floatval($_POST['valorAnuncio']);
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    $imagem = '';

    // upload de imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($ext, $permitidas)) {
            $nome_arquivo = uniqid('anuncio_') . '.' . $ext;
            $destino = '../assets/imagens/anuncios/' . $nome_arquivo;
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $imagem = $nome_arquivo;
            } else {
                $mensagem = "<div class='alert alert-danger'>Erro ao salvar a imagem.</div>";
            }
        } else {
            $mensagem = "<div class='alert alert-warning'>Formato de imagem não permitido.</div>";
        }
    }

    // Se não houve erro de imagem, salva no banco
    if ($mensagem === '') {
        $stmt = $pdo->prepare("INSERT INTO anuncio (nome, imagem, link, valorAnuncio, destaque) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$nome, $imagem, $link, $valor, $destaque])) {
            $mensagem = "<div class='alert alert-success'>Anúncio enviado para avaliação!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao cadastrar anúncio.</div>";
        }
    }
}

// lista de anúncios ativos e aprovados
$stmtAnuncios = $pdo->query("SELECT * FROM anuncio WHERE ativo = 1 ORDER BY destaque DESC, data_cadastro DESC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Anuncie no Fato ou Fruta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f8fb; }
        .navbar { background: #0d6efd; }
        .navbar-brand img { height: 40px; margin-right: 10px; }
        .card { box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: none; }
        .footer { background: #0d6efd; color: #fff; padding: 30px 0 10px 0; }
        .footer .social-icons a { color: #fff; font-size: 1.5rem; margin: 0 10px; transition: color 0.2s; }
        .footer .social-icons a:hover { color: #ffc107; }
        .anuncio-img { max-height: 120px; object-fit: contain; width: 100%; }
        .destaque { border: 2px solid #ffc107; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="../pagina/index.php">
                <img src="../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle">
                <span class="fw-bold">Fato ou Fruta</span>
            </a>
        </div>
    </nav>
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card p-4">
                    <h3 class="text-primary mb-3"><i class="bi bi-megaphone"></i> Anuncie Aqui</h3>
                    <?= $mensagem ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label class="form-label">Nome do Anúncio</label>
                            <input type="text" name="nome" class="form-control" required maxlength="100">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Link do Anúncio</label>
                            <input type="url" name="link" class="form-control" required maxlength="255">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Imagem (jpg, png, gif, webp)</label>
                            <input type="file" name="imagem" class="form-control" accept="image/*" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Valor do Anúncio (R$)</label>
                            <input type="number" name="valorAnuncio" class="form-control" min="0" step="0.01" required>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="destaque" id="destaque">
                            <label class="form-check-label" for="destaque">Destaque (aparece primeiro)</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Enviar Anúncio</button>
                    </form>
                </div>
            </div>
           


</body>
</html>