<?php
session_start();
require_once '../includes/conexao.php';

// Verificação de permissão de administrador
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: ../pagina/index.php');
    exit;
}

// Total arrecadado com anúncios ativos
$stmtValor = $pdo->query("SELECT SUM(valorAnuncio) AS total FROM anuncio WHERE ativo = 1");
$totalArrecadado = $stmtValor->fetchColumn();
if ($totalArrecadado === null)
    $totalArrecadado = 0;

// Total de usuários cadastrados
$stmtUsuarios = $pdo->query("SELECT COUNT(*) FROM usuarios");
$totalUsuarios = $stmtUsuarios->fetchColumn();

// Lista de usuários
$stmtListaUsuarios = $pdo->query("SELECT nome, email, tipo FROM usuarios");

// Lista de anúncios
$stmtListaAnuncios = $pdo->query("SELECT nome, valorAnuncio, ativo, destaque, data_cadastro FROM anuncio ORDER BY data_cadastro DESC");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador - Fato ou Fruta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
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

        /* Custom para alinhar o botão de anúncio */
        .btn-anuncio-admin {
            width: 100%;
            max-width: 350px;
            display: block;
            margin-left: 0;
            margin-right: auto;
        }

        @media (min-width: 768px) {
            .btn-anuncio-admin {
                width: 70%;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="../pagina/index.php">
                <img src="../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle"
                    style="height: 40px; margin-right: 10px;">
                <span class="fw-bold">Fato ou Fruta - Admin</span>
            </a>
        </div>
    </nav>
    <div class="container">
        <h2 class="mb-4 text-primary"><i class="bi bi-bar-chart"></i> Painel do Administrador</h2>

        <!-- Botão de cadastrar anúncio (alinhado à esquerda e menor) -->
        <div class="mb-4">
            <a href="../anuncios/anuncios.php" class="btn btn-primary btn-anuncio-admin">
                <i class="bi bi-plus-circle"></i> Cadastrar Anúncio
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card p-3 mb-3">
                    <h5 class="mb-2"><i class="bi bi-cash-coin"></i> Total Arrecadado com Anúncios Ativos</h5>
                    <span class="fs-4 text-success">R$ <?= number_format($totalArrecadado, 2, ',', '.') ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 mb-3">
                    <h5 class="mb-2"><i class="bi bi-people"></i> Usuários Cadastrados</h5>
                    <span class="fs-4 text-primary"><?= $totalUsuarios ?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Lista de Anúncios -->
            <div class="col-md-6">
                <div class="card p-3 mb-4">
                    <h5 class="mb-3"><i class="bi bi-megaphone"></i> Anúncios Recentes</h5>
                    <table class="table table-sm table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Valor (R$)</th>
                                <th>Ativo</th>
                                <th>Destaque</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($anuncio = $stmtListaAnuncios->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($anuncio['nome']) ?></td>
                                    <td><?= number_format($anuncio['valorAnuncio'], 2, ',', '.') ?></td>
                                    <td><?= $anuncio['ativo'] ? 'Sim' : 'Não' ?></td>
                                    <td><?= $anuncio['destaque'] ? 'Sim' : 'Não' ?></td>
                                    <td><?= isset($anuncio['data_cadastro']) ? date('d/m/Y H:i', strtotime($anuncio['data_cadastro'])) : '-' ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Lista de Usuários -->
            <div class="col-md-6">
                <div class="card p-3 mb-4">
                    <h5 class="mb-3"><i class="bi bi-person-lines-fill"></i> Usuários Recentes</h5>
                    <table class="table table-sm table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($usuario = $stmtListaUsuarios->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    <td><?= ucfirst($usuario['tipo']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
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
                &copy; <?= date('Y'); ?> Fato ou Fruta. Todos os direitos reservados.
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
<html>