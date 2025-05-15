<?php
// Exibir todos os erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Definir constante para permitir acesso aos arquivos incluídos
define('ALLOW_ACCESS', true);

$page = isset($_GET['page']) ? $_GET['page'] : 'login';

if ($page == 'register') {
    include 'register.php';
} else {
    include 'login.php';
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        #text-login {
            font-family: Poppins;
            font-size: 46px;
            font-style: italic;
            font-weight: 300;
            line-height: 120%;
            /* 67.2px */
            background: linear-gradient(180deg, #FFF 0%, rgba(255, 255, 255, 0.44) 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .google-button {
            font-family: Poppins;
            font-size: 15px;
            font-style: normal;
            font-weight: 600;
            line-height: 100%;
            /* 16px */
            color: var(--foreground-primary, #1570EF);
            border-radius: 8px;
            background: var(--container-primary-low, #D1E9FF);
            border: none;
        }

        .submit-button {
            font-family: Poppins;
            font-size: 15px;
            font-style: normal;
            font-weight: 600;
            line-height: 100%;
            background-color: #1570EF;
            color: #fff;
        }

        #head-login {
            color: var(--foreground-high, #101828);
            /* heading */
            font-family: Poppins;
            font-size: 28px;
            font-style: normal;
            font-weight: 600;
            line-height: 100%;
            /* 28px */
        }

        #link-account {
            color: var(--foreground-low, #98A2B3);

            /* body/large/regular */
            font-family: Poppins;
            font-size: 13px;
            font-style: normal;
            font-weight: 400;
            line-height: 100%;
            /* 16px */
            text-transform: capitalize;
            text-decoration: none;
            margin-top: 10px;
        }

        #link-account a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>