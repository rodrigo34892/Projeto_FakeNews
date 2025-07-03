<?php
session_start();
require_once '../includes/conexao.php';

// lógica para inserir comentário 
if (isset($_POST['comentar'], $_POST['comentario'], $_POST['noticia_id']) && isset($_SESSION['usuario_id'])) {
    $comentario = trim($_POST['comentario']);
    $noticia_id = intval($_POST['noticia_id']);
    if ($comentario !== '') {
        $stmtInsere = $pdo->prepare("INSERT INTO comentarios (noticia_id, usuario_id, comentario) VALUES (?, ?, ?)");
        $stmtInsere->execute([$noticia_id, $_SESSION['usuario_id'], $comentario]);
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }
}
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

        .card-img-top {
            max-height: 330px;
            object-fit: cover;
            width: 100%;
        }

        .comentario-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 8px;
        }

        .comentario-nome {
            font-weight: bold;
            color: #0d6efd;
        }

        .comentario-data {
            font-size: 0.85em;
            color: #888;
        }

        /* Estilos para dark mode */
        .dark-mode {
            background: #181a1b !important;
            color: #f1f1f1 !important;
        }

        .dark-mode .card,
        .dark-mode .comentario-box {
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
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle"
                    style="height: 40px; margin-right: 10px;">
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
                            <a class="nav-link" href="../conta/alterar_perfil.php">
                                <i class="bi bi-person"></i> Alterar Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../usuarios/alterar_senha.php">
                                <i class="bi bi-key"></i> Alterar Senha
                            </a>
                        </li>
                        <?php if ($_SESSION['usuario_tipo'] === 'autor'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../autor/noticia/nova_noticia.php">
                                    <i class="bi bi-plus-circle"></i> Cadastrar Notícia
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../autor/noticia/editar_noticia.php">
                                    <i class="bi bi-pencil-square"></i> Editar Notícia
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../autor/noticia/excluir_noticia.php">
                                    <i class="bi bi-trash"></i> Excluir Notícia
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../autor/noticia/dashbord.php">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../Admin/administrador.php">
                                    <i class="bi bi-shield-lock"></i> Admin
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link" href="comentarios.php">
                                <i class="bi bi-chat-dots"></i> Comentários
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../usuarios/logout.php">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../usuarios/tela_login.php">
                                <i class="bi bi-box-arrow-in-right"></i> Entrar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../usuarios/tela_cadastro.php">
                                <i class="bi bi-person-plus"></i> Cadastrar
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- Ícone Sobre (visível para todos) -->
                    <li class="nav-item">
                        <a class="nav-link" href="//redirecionar aq" data-bs-toggle="modal"
                            data-bs-target="#modalSobre">
                            <i class="bi bi-info-circle"></i> Sobre
                        </a>
                    </li>
                    <!-- Botão modo escuro como link do menu -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="toggleDark">
                            <i class="bi bi-moon"></i> Modo Escuro
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container mt-5">
        <h1 class="mb-4 text-primary">Últimas Notícias</h1>
        <?php
        $stmt = $pdo->query("SELECT n.id, n.titulo, n.conteudo, n.imagem, u.nome AS autor_nome
                         FROM noticias n
                         JOIN usuarios u ON n.autor = u.id
                         ORDER BY n.id DESC");
        if ($stmt->rowCount() > 0):
            while ($noticia = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                <div class="card mb-4">
                    <?php if (!empty($noticia['imagem'])): ?>
                        <img src="../assets/imagens/noticias/<?= htmlspecialchars($noticia['imagem']) ?>" class="card-img-top"
                            alt="Imagem da notícia">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($noticia['conteudo'])) ?></p>
                        <p class="card-text"><small class="text-muted">Por
                                <?= htmlspecialchars($noticia['autor_nome']) ?></small></p>
                        <!-- Comentários -->
                        <hr>
                        <h6 class="mb-2"><i class="bi bi-chat-dots"></i> Comentários</h6>
                        <?php
                        $stmtComentarios = $pdo->prepare("SELECT c.comentario, c.data, u.nome FROM comentarios c JOIN usuarios u ON c.usuario_id = u.id WHERE c.noticia_id = ? ORDER BY c.data DESC");
                        $stmtComentarios->execute([$noticia['id']]);
                        if ($stmtComentarios->rowCount() > 0):
                            while ($coment = $stmtComentarios->fetch(PDO::FETCH_ASSOC)):
                                ?>
                                <div class="comentario-box mb-2">
                                    <span class="comentario-nome"><?= htmlspecialchars($coment['nome']) ?></span>
                                    <span class="comentario-data float-end"><?= date('d/m/Y H:i', strtotime($coment['data'])) ?></span>
                                    <div><?= nl2br(htmlspecialchars($coment['comentario'])) ?></div>
                                </div>
                                <?php
                            endwhile;
                        else:
                            echo "<div class='text-muted'>Nenhum comentário ainda.</div>";
                        endif;
                        ?>
                        <!-- Formulário de novo comentário -->
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <form method="post" action="">
                                <div class="input-group mt-2">
                                    <input type="hidden" name="noticia_id" value="<?= $noticia['id'] ?>">
                                    <input type="text" name="comentario" class="form-control" placeholder="Escreva um comentário..."
                                        required maxlength="500">
                                    <button class="btn btn-primary" type="submit" name="comentar"><i
                                            class="bi bi-send"></i></button>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="text-muted mt-2">Faça <a href="../usuarios/tela_login.php">login</a> para comentar.</div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            endwhile;
        else:
            echo "<p>Nenhuma notícia cadastrada ainda.</p>";
        endif;
        ?>
    </div>

    <!-- Widget de clima -->
    <div class="container my-4">
        <h4 class="mb-3"><i class="bi bi-cloud-sun"></i> Verificar Clima</h4>
        <form id="formClima" class="row g-2">
            <div class="col-auto">
                <input type="text" id="cidade" class="form-control" placeholder="Digite sua cidade" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Ver clima</button>
            </div>
        </form>
        <div id="resultadoClima" class="mt-3"></div>
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
        document.getElementById('formClima').addEventListener('submit', function (e) {
            e.preventDefault();
            const cidade = document.getElementById('cidade').value.trim();
            const resultado = document.getElementById('resultadoClima');
            resultado.innerHTML = "Buscando...";
            fetch(`https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(cidade)}&appid=ebba3fce4cdd0e053bd525570da4bd74&units=metric&lang=pt_br`)
                .then(res => res.json())
                .then(data => {
                    if (data.cod === 200) {
                        resultado.innerHTML = `
        <div class="card p-3 mx-auto" style="max-width:350px;">
            <h5>${data.name}, ${data.sys.country}</h5>
            <p class="mb-1"><strong>Temperatura:</strong> ${data.main.temp}°C</p>
            <p class="mb-1"><strong>Situação:</strong> ${data.weather[0].description}</p>
        </div>
                        `;
                    } else {
                        resultado.innerHTML = "<div class='alert alert-danger'>Cidade não encontrada.</div>";
                    }
                })
                .catch(() => {
                    resultado.innerHTML = "<div class='alert alert-danger'>Erro ao buscar clima.</div>";
                });
        });

        // Dark mode automático e manual
        function aplicarTemaInicial() {
            const temaSalvo = localStorage.getItem('tema');
            if (temaSalvo) {
                document.body.classList.toggle('dark-mode', temaSalvo === 'dark');
                atualizarBotao(temaSalvo === 'dark');
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.body.classList.add('dark-mode');
                atualizarBotao(true);
            }
        }
        function atualizarBotao(escuro) {
            const btn = document.getElementById('toggleDark');
            if (btn) {
                if (escuro) {
                    btn.innerHTML = '<i class="bi bi-brightness-high"></i> Modo Claro';
                } else {
                    btn.innerHTML = '<i class="bi bi-moon"></i> Modo Escuro';
                }
            }
        }
        document.addEventListener('DOMContentLoaded', function () {
            aplicarTemaInicial();
            const btn = document.getElementById('toggleDark');
            if (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const escuro = !document.body.classList.contains('dark-mode');
                    document.body.classList.toggle('dark-mode', escuro);
                    localStorage.setItem('tema', escuro ? 'dark' : 'light');
                    atualizarBotao(escuro);
                });
            }
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('tema')) {
                    document.body.classList.toggle('dark-mode', e.matches);
                    atualizarBotao(e.matches);
                }
            });
        });
    </script>
    <!-- Banner de Cookies -->
    <div id="cookieConsent"
        style="display:none; position:fixed; bottom:0; left:0; width:100%; background:#111; color:#fff; z-index:9999; padding:18px 0; box-shadow:0 -2px 8px rgba(0,0,0,0.08);">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="mb-2 mb-md-0">
                <i class="bi bi-shield-check" style="font-size:1.5rem; color:#0d6efd; margin-right:8px;"></i>
                Este site utiliza cookies para melhorar sua experiência. Ao continuar navegando, você concorda com nossa
                <a href="#" style="color:#0d6efd; text-decoration:underline;">Política de Privacidade</a>.
            </div>
            <button id="btnAceitarCookies" class="btn btn-primary btn-sm ms-md-3">
                <i class="bi bi-check-circle"></i> Aceitar
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!localStorage.getItem('cookiesAceitos')) {
                document.getElementById('cookieConsent').style.display = 'block';
            }
            document.getElementById('btnAceitarCookies').onclick = function () {
                localStorage.setItem('cookiesAceitos', 'sim');
                document.getElementById('cookieConsent').style.display = 'none';
            };
        });
    </script>
</body>

</html>