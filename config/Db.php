<?php

// Configurações específicas por ambiente
// Configuração para ambiente de desenvolvimento
$host = "localhost";
$user = "root";
$pass = "";  // Senha vazia para XAMPP padrão
$db = "login";

// Conexão PDO (mesma para ambos os ambientes)
$dsn = "mysql:host=$host;dbname=$db";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Em produção, não mostrar detalhes do erro para o usuário final
    if ($isProduction) {
        die("Erro de conexão com o banco de dados. Por favor, tente novamente mais tarde.");
    } else {
        die("Connection failed: " . $e->getMessage());
    }
}
