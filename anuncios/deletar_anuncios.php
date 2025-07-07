<?php
require_once '../includes/conexao.php';
session_start();

// Verifica se o usuário é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: ../usuarios/tela_login.php');
    exit;
}

$mensagem = '';

// Processamento da exclusão
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Primeiro busca o anúncio para pegar o nome da imagem
    $stmt = $pdo->prepare("SELECT imagem FROM anuncio WHERE id = ?");
    $stmt->execute([$id]);
    $anuncio = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($anuncio) {
        try {
            $pdo->beginTransaction();
            
            // Deleta do banco de dados
            $stmtDelete = $pdo->prepare("DELETE FROM anuncio WHERE id = ?");
            $stmtDelete->execute([$id]);
            
            // Deleta a imagem se existir
            if (!empty($anuncio['imagem'])) {
                $caminhoImagem = '../assets/imagens/anuncios/' . $anuncio['imagem'];
                if (file_exists($caminhoImagem)) {
                    unlink($caminhoImagem);
                }
            }
            
            $pdo->commit();
            $mensagem = "<div class='alert alert-success'>Anúncio deletado com sucesso!</div>";
        } catch (Exception $e) {
            $pdo->rollBack();
            $mensagem = "<div class='alert alert-danger'>Erro ao deletar anúncio: " . $e->getMessage() . "</div>";
        }
    } else {
        $mensagem = "<div class='alert alert-danger'>Anúncio não encontrado.</div>";
    }
}

// Lista todos os anúncios para seleção
$stmtAnuncios = $pdo->query("SELECT * FROM anuncio ORDER BY data_cadastro DESC");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Deletar Anúncios - Fato ou Fruta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
        }

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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: none;
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

        .anuncio-img {
            max-height: 120px;
            object-fit: contain;
            width: 100%;
        }

        .destaque {
            border: 2px solid #0d6efd;
        }

        .btn-delete {
            background-color: #0d6efd;
            color: white;
            transition: all 0.3s;
        }

        .btn-delete:hover {
            background-color: #0b5ed7;
            color: white;
            transform: scale(1.05);
        }

        .tr-destaque {
            background-color: #ffffff;
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
        .dark-mode .navbar-brand span,
        .dark-mode .navbar-nav .nav-link {
            color: #f1f1f1 !important;
        }

        .dark-mode .btn-delete {
            background-color: #1a73e8 !important;
        }

        .dark-mode .tr-destaque {
            background-color: #2c3034 !important;
        }
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

    <div class="container mb-5 flex-grow-1">
        <div class="row">
            <div class="col-12">
                <div class="card p-4 mb-4">
                    <h3 class="text-primary mb-3"><i class="bi bi-trash"></i> Deletar Anúncios</h3>
                    <?= $mensagem ?>
                    
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Atenção: Esta ação é irreversível e removerá permanentemente o anúncio.
                    </div>
                </div>

                <div class="card p-4">
                    <h4 class="mb-3"><i class="bi bi-list-check"></i> Selecione um anúncio para deletar</h4>
                    
                    <?php if ($stmtAnuncios->rowCount() > 0): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Imagem</th>
                                        <th>Nome</th>
                                        <th>Valor</th>
                                        <th>Destaque</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($anuncio = $stmtAnuncios->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr class="<?= $anuncio['destaque'] ? 'tr-destaque' : '' ?>">
                                            <td>
                                                <img src="../assets/imagens/anuncios/<?= htmlspecialchars($anuncio['imagem']) ?>" 
                                                     alt="Anúncio" class="anuncio-img rounded" style="max-width: 100px;">
                                            </td>
                                            <td><?= htmlspecialchars($anuncio['nome']) ?></td>
                                            <td>R$ <?= number_format($anuncio['valorAnuncio'], 2, ',', '.') ?></td>
                                            <td>
                                                <?php if ($anuncio['destaque']): ?>
                                                    <span class="badge bg-primary"><i class="bi bi-star-fill"></i> Sim</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><i class="bi bi-star"></i> Não</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="deletar_anuncio.php?id=<?= $anuncio['id'] ?>" 
                                                   class="btn btn-delete btn-sm"
                                                   onclick="return confirm('Tem certeza que deseja deletar este anúncio?')">
                                                    <i class="bi bi-trash"></i> Deletar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">Nenhum anúncio cadastrado para deletar.</div>
                    <?php endif; ?>
                </div>
            </div>
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
        // Dark mode automático e manual
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