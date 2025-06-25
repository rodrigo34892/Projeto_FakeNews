# 📰 Fato ou Fruta

**Portal de notícias sobre fake news desenvolvido em aula, com sistema de cadastro, login, comentários e gerenciamento de notícias.**

---

## 📌 Sobre o Projeto

**Fato ou Fruta** é um portal de notícias sobre fake news, onde leitores e autores podem interagir, publicar, comentar e gerenciar conteúdos. O projeto foi desenvolvido com o objetivo de criar uma plataforma colaborativa para compartilhar informações, com foco na conscientização sobre fake news. O sistema conta com autenticação de usuários e permissões diferenciadas para interação e criação de conteúdos.

---

## 🌐 Funcionalidades

- ✅ **Cadastro e Login de Usuários**: Leitores e autores podem criar contas, fazer login e recuperar senhas.
- ✅ **Edição de Perfil**: Usuários autenticados podem atualizar nome e e-mail.
- ✅ **Gerenciamento de Notícias**: Autores podem criar, editar, excluir e visualizar notícias.
- ✅ **Comentários**: Usuários autenticados podem comentar nas notícias.
- ✅ **Upload de Imagens**: Inclusão de imagens nas notícias.
- ✅ **Interface Responsiva**: Uso do Bootstrap para um layout adaptável a dispositivos móveis.

---

## 🌍 Estrutura das Páginas

- **Página Inicial**: Exibe as últimas notícias e permite que os usuários comentem.
- **Cadastro/Login**: Permite criar conta, acessar e recuperar senha.
- **Perfil**: Usuários autenticados podem alterar nome, e-mail e senha.
- **Notícias**: Autores podem cadastrar, editar, excluir e visualizar notícias.
- **Comentários**: Usuários autenticados podem comentar nas notícias e visualizar os comentários.

---

## 🛠️ Tecnologias Utilizadas

- **PHP** (backend)
- **MySQL** (banco de dados)
- **HTML5**
- **CSS3** (Bootstrap)
- **JavaScript**
- **FontAwesome/Bootstrap Icons**

---

## 📁 Estrutura de Pastas

```plaintext
ProjetoFakeNews/
├── assets/            # Armazena imagens usadas nas notícias
│   └── imagens/       # Imagens
├── autor/             # Gerenciamento de notícias (autores)
│   ├── cadastrar.php  # Cadastrar novas notícias
│   ├── editar.php     # Editar notícias existentes
│   ├── excluir.php    # Excluir notícias
│   └── visualizar.php # Visualizar notícias
├── conta/             # Alteração de perfil do usuário
│   └── alterar_perfil.php # Alterar nome e e-mail
├── includes/          # Funções auxiliares e conexão com o banco de dados
│   ├── conexao.php    # Conexão com o banco de dados
│   └── funcoes.php    # Funções auxiliares
├── pagina/            # Páginas principais e comentários
│   ├── comentarios.php # Gerenciamento de comentários
│   └── index.php      # Página principal com as notícias
├── usuarios/          # Funcionalidades relacionadas ao usuário
│   ├── cadastro.php   # Tela de cadastro
│   ├── login.php      # Tela de login
│   ├── recuperar_senha.php # Recuperação de senha
│   ├── alterar_senha.php   # Alteração de senha
│   └── logout.php     # Logout do usuário
├── README.md