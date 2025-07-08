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

// lista de anúncios ativos e aprovados
$stmtAnuncios = $pdo->query("SELECT * FROM anuncio WHERE ativo = 1 ORDER BY destaque DESC, data_cadastro DESC");
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

        /* Estilos para os anúncios */
        .card-anuncio {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-anuncio:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-anuncio .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-anuncio .card-text {
            flex-grow: 1;
        }

        .anuncio-img {
            height: 180px;
            object-fit: contain;
            background: #f8f9fa;
            padding: 10px;
            width: 100%;
        }

        .destaque {
            border: 2px solid #0d6efd !important;
            /* Azul no lugar do amarelo */
        }

        .badge-destaque {
            background-color: #0d6efd !important;
            /* Azul no lugar do amarelo */
            color: white !important;
        }

        /* Estilos para o widget de clima */
        .weather-card {
            max-width: 350px;
            margin: 0 auto;
        }

        .weather-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .weather-details {
            display: flex;
            justify-content: space-around;
            text-align: center;
        }

        .weather-detail {
            flex: 1;
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

        .dark-mode .anuncio-img {
            background: #2c3034;
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

    <!-- Seção de Anúncios -->
    <div class="container my-5">
        <h2 class="text-primary mb-4"><i class="bi bi-megaphone"></i> Anúncios</h2>
        <div class="row">
            <?php if ($stmtAnuncios->rowCount() > 0): ?>
                <?php while ($anuncio = $stmtAnuncios->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 card-anuncio <?= $anuncio['destaque'] ? 'border-primary border-2' : '' ?>">
                            <a href="<?= htmlspecialchars($anuncio['link']) ?>" target="_blank" class="text-decoration-none">
                                <img src="../assets/imagens/anuncios/<?= htmlspecialchars($anuncio['imagem']) ?>"
                                    class="anuncio-img card-img-top" alt="<?= htmlspecialchars($anuncio['nome']) ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($anuncio['nome']) ?></h5>
                                    <?php if ($anuncio['destaque']): ?>
                                        <span class="badge bg-primary text-white mb-2">
                                            <i class="bi bi-star-fill"></i> Destaque
                                        </span>
                                    <?php endif; ?>
                                    <!-- Removida a linha do valor -->
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">Nenhum anúncio ativo no momento.</div>
                </div>
            <?php endif; ?>
        </div>
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
        // Widget de Clima
        document.getElementById('formClima').addEventListener('submit', function (e) {
            e.preventDefault();
            const cidade = document.getElementById('cidade').value.trim();
            const resultado = document.getElementById('resultadoClima');

            // Mostra um card de loading
            resultado.innerHTML = `
                <div class="card p-3 weather-card">
                    <div class="d-flex justify-content-center align-items-center" style="min-height:150px;">
                        <div class="spinner-border text-primary"></div>
                        <span class="ms-2">Buscando clima...</span>
                    </div>
                </div>
            `;

            fetch(`https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(cidade)}&appid=ebba3fce4cdd0e053bd525570da4bd74&units=metric&lang=pt_br`)
                .then(res => res.json())
                .then(data => {
                    if (data.cod === 200) {
                        const iconeClima = getWeatherIcon(data.weather[0].id);

                        resultado.innerHTML = `
                            <div class="card p-3 weather-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">${data.name}, ${data.sys.country}</h5>
                                    <span class="badge bg-primary rounded-pill">${new Date().toLocaleDateString('pt-BR')}</span>
                                </div>
                                <hr>
                                <div class="text-center my-3">
                                    <div class="weather-icon">${iconeClima}</div>
                                    <h2 class="my-2">${Math.round(data.main.temp)}°C</h2>
                                    <div class="text-capitalize">${data.weather[0].description}</div>
                                </div>
                                <div class="weather-details">
                                    <div class="weather-detail">
                                        <div><i class="bi bi-droplet"></i></div>
                                        <div>${data.main.humidity}%</div>
                                        <small>Humidade</small>
                                    </div>
                                    <div class="weather-detail">
                                        <div><i class="bi bi-wind"></i></div>
                                        <div>${(data.wind.speed * 3.6).toFixed(1)} km/h</div>
                                        <small>Vento</small>
                                    </div>
                                    <div class="weather-detail">
                                        <div><i class="bi bi-thermometer"></i></div>
                                        <div>${Math.round(data.main.feels_like)}°C</div>
                                        <small>Sensação</small>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        resultado.innerHTML = `
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle"></i> Cidade não encontrada. Tente novamente.
                            </div>
                        `;
                    }
                })
                .catch(() => {
                    resultado.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> Erro ao buscar clima. Verifique sua conexão.
                        </div>
                    `;
                });
        });

        // Função para determinar o ícone com base no ID do clima
        function getWeatherIcon(weatherId) {
            // Grupo 2xx: Tempestades
            if (weatherId >= 200 && weatherId < 300) {
                return '<i class="bi bi-lightning-fill" style="color: #ffc107;"></i>';
            }
            // Grupo 3xx: Chuvisco
            else if (weatherId >= 300 && weatherId < 400) {
                return '<i class="bi bi-cloud-drizzle-fill" style="color: #6c757d;"></i>';
            }
            // Grupo 5xx: Chuva
            else if (weatherId >= 500 && weatherId < 600) {
                if (weatherId < 502) {
                    return '<i class="bi bi-cloud-rain-fill" style="color: #0d6efd;"></i>';
                } else {
                    return '<i class="bi bi-cloud-rain-heavy-fill" style="color: #0d6efd;"></i>';
                }
            }
            // Grupo 6xx: Neve
            else if (weatherId >= 600 && weatherId < 700) {
                return '<i class="bi bi-snow2" style="color: #dee2e6;"></i>';
            }
            // Grupo 7xx: Atmosférico (névoa, etc)
            else if (weatherId >= 700 && weatherId < 800) {
                return '<i class="bi bi-cloud-fog-fill" style="color: #adb5bd;"></i>';
            }
            // Céu limpo
            else if (weatherId === 800) {
                return '<i class="bi bi-sun-fill" style="color: #ffc107;"></i>';
            }
            // Nuvens
            else if (weatherId > 800) {
                if (weatherId === 801) {
                    return '<i class="bi bi-cloud-sun-fill" style="color: #adb5bd;"></i>';
                } else if (weatherId === 802) {
                    return '<i class="bi bi-cloud-fill" style="color: #6c757d;"></i>';
                } else {
                    return '<i class="bi bi-clouds-fill" style="color: #6c757d;"></i>';
                }
            }
            // Padrão
            else {
                return '<i class="bi bi-cloud-fill" style="color: #6c757d;"></i>';
            }
        }

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