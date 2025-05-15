<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../config/google_config.php';
require_once '../config/db.php';

// Criar uma nova instância do cliente Google
$client = new Google\Client();
$client->setClientId($googleClientId);
$client->setClientSecret($googleClientSecret);
$client->setRedirectUri($googleRedirectUri);

// Verificar o código recebido do Google
if (isset($_GET['code'])) {
    // Trocar o código por um token de acesso
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Obter informações do usuário
    $google_oauth = new Google\Service\Oauth2($client);
    $userInfo = $google_oauth->userinfo->get();

    // Extrair dados do usuário
    $google_id = $userInfo->getId();
    $email = $userInfo->getEmail();
    $name = $userInfo->getName();
    $picture = $userInfo->getPicture();

    // Verificar se o usuário já existe (pelo google_id)
    $stmt = $pdo->prepare("SELECT * FROM users WHERE google_id = ?");
    $stmt->execute([$google_id]);
    $user = $stmt->fetch();

    if ($user) {
        // Usuário já existe, fazer login
        $_SESSION['user'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['profile_picture'] = $user['profile_picture'];

        // Redirecionar para o dashboard
        header("Location: ../dashboard.php");
        exit();
    } else {
        // Verificar se já existe um usuário com o mesmo email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Atualizar o usuário existente com o Google ID
            $updateStmt = $pdo->prepare("UPDATE users SET google_id = ?, profile_picture = ? WHERE id = ?");
            $updateStmt->execute([$google_id, $picture, $user['id']]);

            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['profile_picture'] = $picture;
        } else {
            // Criar um novo usuário
            // Gerar um nome de usuário baseado no email
            $username = strtolower(explode('@', $email)[0]);

            // Verificar se o username já existe e adicionar número se necessário
            $baseUsername = $username;
            $counter = 1;

            while (true) {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $count = $stmt->fetchColumn();

                if ($count == 0) {
                    break;
                }

                $username = $baseUsername . $counter;
                $counter++;
            }

            // Inserir o novo usuário
            $stmt = $pdo->prepare("INSERT INTO users (username, email, google_id, profile_picture, password) VALUES (?, ?, ?, ?, NULL)");
            $stmt->execute([$username, $email, $google_id, $picture]);

            $_SESSION['user'] = $username;
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['profile_picture'] = $picture;
        }

        // Redirecionar para o dashboard
        header("Location: ../dashboard.php");
        exit();
    }
} else {
    // Se não houver código, redirecionar para a página inicial
    header("Location: ../index.php");
    exit();
}
