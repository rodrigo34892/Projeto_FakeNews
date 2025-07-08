<?php
// Nenhuma lógica PHP necessária para a página "Sobre"
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Sobre - Fato ou Fruta</title>
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

        .dev-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #0d6efd;
            margin-bottom: 8px;
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
        .dark-mode a {
            color: #66b3ff !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="../pagina/index.php">
                <img src="../img/logo/logo_fatooufruto.png" alt="Logo" class="rounded-circle"
                    style="height: 40px; margin-right: 10px;">
                <span class="fw-bold">Fato ou Fruta</span>
            </a>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4" style="max-width: 600px; width: 100%;">
            <h2 class="text-center text-primary mb-3">Sobre o Fato ou Fruta</h2>
            <p>
                O <strong>Fato ou Fruta</strong> é uma plataforma dedicada ao combate à desinformação e à disseminação de notícias falsas. Nosso objetivo é oferecer um ambiente confiável onde usuários podem ler, publicar e verificar notícias, promovendo o pensamento crítico e a responsabilidade digital.
            </p>
            <p>
                <strong>Funcionalidades principais:</strong>
                <ul>
                    <li>Cadastro e login de usuários</li>
                    <li>Publicação de notícias por autores</li>
                    <li>Leitura, comentários e interação nas notícias</li>
                    <li>Ambiente seguro e moderado</li>
                    <li>Design responsivo e modo escuro automático</li>
                    <li>Dashboard para autores acompanharem suas postagens</li>
                    <li>Recuperação de senha por código de verificação</li>
                    <li>Perfil do usuário com edição de dados</li>
                    <li>Exclusão e edição de notícias pelo autor</li>
                    <li>Visualização de todas as notícias publicadas</li>
                    <li>Consulta de comentários feitos pelo usuário</li>
                    <li>Aba do clima: previsão do tempo em tempo real</li>
                    <li>Página "Sobre" com informações da equipe</li>
                    <li><strong>Página de administração do sistema</strong></li>
                </ul>
            </p>
            <p>
                Desenvolvido por uma equipe apaixonada por tecnologia e informação, o Fato ou Fruta acredita que a verdade deve ser acessível a todos.
            </p>
            <hr>
            <h4 class="text-center text-primary mb-3">Desenvolvedores</h4>
            <div class="row justify-content-center">
                <div class="col-6 col-md-4 text-center mb-3">
                    <img src="../img/devs/20250707_210320.jpg" alt="Desenvolvedor 1" class="dev-img">
                    <div class="fw-bold">Rodrigo</div>
                    
                </div>
                <div class="col-6 col-md-4 text-center mb-3">
                    <img src="../img/devs/20250707_210334.jpg" alt="Desenvolvedor 2" class="dev-img">
                    <div class="fw-bold">Rafael</div>
                    
                </div>
                <!-- Adicione mais desenvolvedores conforme necessário -->
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