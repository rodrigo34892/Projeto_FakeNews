<?php
// Nenhuma lógica PHP necessária para a página "Política de Privacidade"
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Política de Privacidade - Fato ou Fruta</title>
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

        .dark-mode a {
            color: #66b3ff !important;
        }

        /* Estilos específicos para política de privacidade */
        .privacy-section {
            margin-bottom: 2rem;
        }

        .privacy-section h3 {
            color: #0d6efd;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
        }

        .dark-mode .privacy-section h3 {
            border-bottom-color: #444;
        }

        .privacy-list {
            padding-left: 1.5rem;
        }

        .privacy-list li {
            margin-bottom: 0.5rem;
        }

        .highlight-box {
            background-color: #f8f9fa;
            border-left: 4px solid #0d6efd;
            padding: 1rem;
            margin: 1rem 0;
        }

        .dark-mode .highlight-box {
            background-color: #2c3034;
            border-left-color: #66b3ff;
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

    <div class="container py-5">
        <div class="card p-4 p-md-5">
            <h1 class="text-center text-primary mb-4">Política de Privacidade</h1>
            <p class="text-muted text-center mb-4">Última atualização: <?php echo date('d/m/Y'); ?></p>

            <div class="privacy-section">
                <p>Bem-vindo à Política de Privacidade do <strong>Fato ou Fruta</strong>. Esta página informa sobre
                    nossas políticas relativas à coleta, uso e divulgação de dados pessoais quando você utiliza nosso
                    site e as escolhas que você tem associadas a esses dados.</p>

                <div class="highlight-box">
                    <p><strong>Resumo:</strong> Nós valorizamos sua privacidade. Coletamos apenas informações
                        necessárias para fornecer e melhorar nosso serviço. Não compartilhamos suas informações pessoais
                        com terceiros, exceto conforme descrito nesta política.</p>
                </div>
            </div>

            <div class="privacy-section">
                <h3>1. Informações que Coletamos</h3>
                <p>Coletamos vários tipos diferentes de informações para diversos fins para fornecer e melhorar nosso
                    serviço para você:</p>
                <ul class="privacy-list">
                    <li><strong>Dados Pessoais:</strong> Nome, e-mail, foto de perfil (opcional) quando você se cadastra
                        em nossa plataforma.</li>
                    <li><strong>Dados de Uso:</strong> Coletamos informações sobre como o serviço é acessado e usado
                        ("Dados de Uso").</li>
                    <li><strong>Cookies e Dados de Navegação:</strong> Utilizamos cookies e tecnologias similares para
                        rastrear a atividade em nosso site e manter certas informações.</li>
                </ul>
            </div>

            <div class="privacy-section">
                <h3>2. Como Usamos Seus Dados</h3>
                <p>O Fato ou Fruta utiliza os dados coletados para diversas finalidades:</p>
                <ul class="privacy-list">
                    <li>Para fornecer e manter nosso serviço</li>
                    <li>Para notificá-lo sobre mudanças em nosso serviço</li>
                    <li>Para permitir que você participe de recursos interativos do nosso site quando você optar por
                        fazê-lo</li>
                    <li>Para fornecer atendimento ao cliente e suporte</li>
                    <li>Para fornecer análises ou informações valiosas para que possamos melhorar nosso serviço</li>
                    <li>Para monitorar o uso do serviço</li>
                    <li>Para detectar, prevenir e resolver problemas técnicos</li>
                </ul>
            </div>

            <div class="privacy-section">
                <h3>3. Compartilhamento de Dados</h3>
                <p>Não compartilhamos suas informações pessoais com terceiros, exceto nas seguintes situações:</p>
                <ul class="privacy-list">
                    <li>Com prestadores de serviços para monitorar e analisar o uso de nosso serviço</li>
                    <li>Para cumprir com obrigações legais</li>
                    <li>Para proteger e defender os direitos ou propriedade do Fato ou Fruta</li>
                    <li>Para prevenir ou investigar possíveis irregularidades em conexão com o serviço</li>
                    <li>Para proteger a segurança pessoal de usuários do serviço ou do público</li>
                    <li>Para proteger contra responsabilidade legal</li>
                </ul>
            </div>

            <div class="privacy-section">
                <h3>4. Segurança de Dados</h3>
                <p>A segurança de seus dados é importante para nós, mas lembre-se que nenhum método de transmissão pela
                    Internet ou método de armazenamento eletrônico é 100% seguro. Embora nos esforcemos para usar meios
                    comercialmente aceitáveis para proteger seus dados pessoais, não podemos garantir sua segurança
                    absoluta.</p>
            </div>

            <div class="privacy-section">
                <h3>5. Cookies</h3>
                <p>Utilizamos cookies e tecnologias similares para rastrear a atividade em nosso site e manter
                    determinadas informações. Você pode instruir seu navegador a recusar todos os cookies ou a indicar
                    quando um cookie está sendo enviado.</p>
            </div>

            <div class="privacy-section">
                <h3>6. Links para Outros Sites</h3>
                <p>Nosso serviço pode conter links para outros sites que não são operados por nós. Se você clicar em um
                    link de terceiros, será direcionado para o site desse terceiro. Recomendamos fortemente que você
                    revise a Política de Privacidade de cada site que visitar.</p>
            </div>

            <div class="privacy-section">
                <h3>7. Direitos do Usuário</h3>
                <p>Você tem o direito de:</p>
                <ul class="privacy-list">
                    <li>Acessar, atualizar ou excluir as informações que temos sobre você</li>
                    <li>Solicitar a correção dos dados que acreditamos estar imprecisos</li>
                    <li>Opor ao processamento de seus dados pessoais</li>
                    <li>Solicitar a limitação do processamento de seus dados pessoais</li>
                    <li>Solicitar a portabilidade de seus dados</li>
                    <li>Retirar seu consentimento a qualquer momento</li>
                </ul>
                <p>Para exercer esses direitos, entre em contato conosco através das informações fornecidas na seção
                    "Contato" abaixo.</p>
            </div>

            <div class="privacy-section">
                <h3>8. Alterações nesta Política de Privacidade</h3>
                <p>Podemos atualizar nossa Política de Privacidade periodicamente. Notificaremos você sobre quaisquer
                    alterações publicando a nova Política de Privacidade nesta página.</p>
                <p>Recomendamos que você revise esta Política de Privacidade periodicamente para quaisquer alterações.
                    As alterações a esta Política de Privacidade são efetivas quando são publicadas nesta página.</p>
            </div>

            <div class="privacy-section">
                <h3>9. Contato</h3>
                <p>Se você tiver alguma dúvida sobre esta Política de Privacidade, entre em contato conosco:</p>
                <ul class="privacy-list">
                    <li>Por e-mail: privacidade@fatooufruta.com</li>
                    <li>Através do formulário de contato em nosso site</li>
                </ul>
            </div>

            <div class="highlight-box mt-5">
                <p><strong>Observação importante:</strong> Esta política de privacidade se aplica apenas às informações
                    coletadas através do nosso site e não às informações coletadas offline ou por outros canais.</p>
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
        // Dark mode automático 
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