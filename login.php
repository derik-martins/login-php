<?php
// Previne acesso direto a este arquivo
if (!defined('ALLOW_ACCESS')) {
    header("Location: index.php");
    exit;
}

session_start();
// Usar caminho absoluto para o arquivo de configuração do banco de dados
require __DIR__ . '/config/Db.php';

$loginError = "";
$showSuccessToast = false;
$registeredUsername = "";

// Verificar se o usuário foi redirecionado após um registro bem-sucedido
if (isset($_SESSION['registration_success']) && $_SESSION['registration_success'] === true) {
    $showSuccessToast = true;
    $registeredUsername = $_SESSION['registered_username'] ?? '';

    // Limpar a sessão para não mostrar a mensagem novamente
    unset($_SESSION['registration_success']);
    unset($_SESSION['registered_username']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $loginError = "invalid_credentials";
    }
}
?>

<div class="container-fluid">
    <!-- Toast para erro de login -->
    <?php if (!empty($loginError)): ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
            <div id="errorToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto">Erro no login</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Email ou senha inválidos. Por favor, tente novamente.
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Toast para registro bem-sucedido -->
    <?php if ($showSuccessToast): ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
            <div id="successToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <strong class="me-auto">Registro Concluído</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Parabéns <?php echo htmlspecialchars($registeredUsername); ?>! Sua conta foi criada com sucesso.
                    Agora você pode fazer login usando as credenciais que acabou de registrar.
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row" style="height: 100vh;">
        <div class="col-md-6 p-5" id="fundo-animate" style="display: flex;color: #fff;/* align-content: space-between; */justify-content: flex-end;flex-direction: column;">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-left align-items-end p-5">
                <p id="text-login">Bem-vindo.<br>
                    Comece sua jornada<br>
                    agora com nosso<br> sistema!</p>
            </div>
        </div>
        <div class="col-md-6" style="display: flex; flex-direction: column; justify-content: center;">
            <div class="container w-50 p-3">
                <h1 id="head-login" class="mb-3">Faça login</h1>
                <form method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Senha</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2 p-2 submit-button">Entrar</button>
                    <a href="auth/google.php" class="btn btn-secondary w-100 p-2 google-button">
                        <i class="bi bi-google me-2"></i>Continuar com Google
                    </a>
                </form>
                <h5 class="text-center" id="link-account">Não tem uma conta? <a href="index.php?page=register">Crie uma conta</a></h5>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.halo.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            VANTA.HALO({
                el: "#fundo-animate",
                mouseControls: true,
                touchControls: true,
                gyroControls: false,
                minHeight: 200.00,
                minWidth: 200.00,
                backgroundColor: 0x050A24
            });

            // Auto-fechar os toasts após 5 segundos
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function(toastEl) {
                setTimeout(function() {
                    const toast = new bootstrap.Toast(toastEl);
                    toast.hide();
                }, 5000);
            });

            // Preparar o botão de login com Google
            document.getElementById('googleSignIn').addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = 'auth/google.php';
            });
        });
    </script>
</div>