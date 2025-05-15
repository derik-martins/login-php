<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../config/google_config.php';

// Criar uma nova instância do cliente Google
$client = new Google\Client();
$client->setClientId($googleClientId);
$client->setClientSecret($googleClientSecret);
$client->setRedirectUri($googleRedirectUri);
$client->addScope("email");
$client->addScope("profile");

// Criar URL de autenticação e redirecionar
$authUrl = $client->createAuthUrl();
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
exit;
