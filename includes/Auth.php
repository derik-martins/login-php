<?php
// A sessão já deve ter sido iniciada no arquivo que inclui este

// Verificar se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
