# Sistema de Login com Google Auth

Um sistema de autenticação simples e seguro em PHP que permite login tradicional por email/senha e autenticação via conta Google. Ideal para projetos que precisam de uma implementação rápida e confiável de autenticação dupla.

## 🚀 Funcionalidades

- Login tradicional (email e senha)
- Login com Google OAuth 2.0
- Registro de novos usuários
- Painel de controle personalizado
- Gerenciamento de sessões

## 🛠️ Tecnologias

- PHP
- MySQL
- Google API Client
- Bootstrap 5
- PDO para conexões seguras com banco de dados

## 📋 Pré-requisitos

- PHP 7.4+
- Servidor MySQL/MariaDB
- Composer para gerenciamento de dependências
- Conta Google Cloud Platform para configuração do OAuth

## 🔧 Instalação

1. Clone este repositório

```
git clone https://github.com/seu-usuario/sistema-login-google.git
cd sistema-login-google
```

2. Instale as dependências usando Composer

```
composer install
```

3. Configure o banco de dados

- Crie um banco de dados chamado `login`
- Importe o arquivo `db_update.sql` para criar a estrutura necessária

4. Configure suas credenciais Google

- Abra o arquivo `config/google_config.php`
- Substitua com suas próprias credenciais OAuth:

```php
$googleClientId = "SEU_CLIENT_ID";
$googleClientSecret = "SEU_CLIENT_SECRET";
$googleRedirectUri = "https://seu-dominio.com/auth/google_callback.php";
```

5. Configure a conexão com o banco de dados

- Abra o arquivo `config/Db.php`
- Atualize as credenciais:

```php
$host = "seu-host";
$user = "seu-usuario";
$pass = "sua-senha";
$db = "login";
```

## 🚀 Uso

1. Navegue até a página inicial para acessar o formulário de login
2. Utilize o botão "Login com Google" para autenticação via conta Google
3. Ou faça login com email e senha previamente cadastrados
4. Novos usuários podem se registrar na página de registro

## ⚙️ Personalizando

O sistema é facilmente personalizável:

- Modifique o layout e estilos utilizando Bootstrap 5
- Adicione novos campos ao banco de dados conforme necessário
- Estenda a funcionalidade adicionando novos provedores de autenticação

## 🔒 Segurança

- Senhas armazenadas com hash seguro
- Proteção contra injeção SQL usando PDO
- Validação de dados de entrada
- Gerenciamento seguro de sessões

## 📄 Licença

Este projeto está sob a licença MIT - veja o arquivo [LICENSE.md](LICENSE.md) para mais detalhes.

## 📞 Contato

Seu Nome - [@seu-twitter](https://twitter.com/seu-twitter) - email@exemplo.com

Link do projeto: [https://github.com/seu-usuario/sistema-login-google](https://github.com/seu-usuario/sistema-login-google)
