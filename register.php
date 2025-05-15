<?php
// Previne acesso direto a este arquivo
if (!defined('ALLOW_ACCESS')) {
    header("Location: index.php");
    exit;
}

session_start();
// Usar caminho absoluto para arquivo de banco de dados
require __DIR__ . '/config/Db.php';

$registrationError = "";
$formData = [
    'username' => '',
    'email' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Salvar os dados do formulário para repreenchimento em caso de erro
    $formData['username'] = htmlspecialchars($username);
    $formData['email'] = htmlspecialchars($email);

    // Verificar se as senhas são iguais
    if ($password !== $confirmPassword) {
        $registrationError = "password_mismatch";
    } else {
        // Verificar se o email já existe
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $registrationError = "email_exists";
        } else {
            // Verificar se o nome de usuário já existe
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $userByUsername = $stmt->fetch();

            if ($userByUsername) {
                $registrationError = "username_exists";
            } else {
                // Hash da senha
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Inserir novo usuário
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $result = $stmt->execute([$username, $email, $hashedPassword]);

                if ($result) {
                    // Adicionar dados a sessão para mostrar mensagem na página de login
                    $_SESSION['registration_success'] = true;
                    $_SESSION['registered_username'] = $username;

                    // Redirecionar para a página de login
                    header("Location: index.php?page=login");
                    exit;
                } else {
                    $registrationError = "db_error";
                }
            }
        }
    }
}
?>

<div class="container-fluid">
    <!-- Toast para mensagens de erro -->
    <?php if (!empty($registrationError)): ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
            <div id="errorToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto">Erro no cadastro</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <?php
                    switch ($registrationError) {
                        case 'password_mismatch':
                            echo 'As senhas não coincidem. Por favor, tente novamente.';
                            break;
                        case 'email_exists':
                            echo 'Este email já está em uso. Por favor, use outro ou faça login.';
                            break;
                        case 'username_exists':
                            echo 'Este nome de usuário já está em uso. Por favor, escolha outro.';
                            break;
                        case 'db_error':
                            echo 'Ocorreu um erro ao registrar. Por favor, tente novamente mais tarde.';
                            break;
                        default:
                            echo 'Ocorreu um erro inesperado. Por favor, tente novamente.';
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row" style="height: 100vh;">
        <div class="col-md-6 p-5" id="fundo-animate" style="display: flex;color: #fff;/* align-content: space-between; */justify-content: flex-end;flex-direction: column;">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-left align-items-end p-5">
                <p id="text-login">Comece sua<br>
                    jornada conosco.<br>
                    Registre-se agora<br>
                    para acessar!</p>
            </div>
        </div>
        <div class="col-md-6" style="display: flex; flex-direction: column; justify-content: center;">
            <div class="container w-50 p-3">
                <h1 id="head-login" class="mb-3">Crie sua conta</h1>
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nome de usuário</label>
                        <input type="text" name="username" class="form-control" id="username" required value="<?php echo $formData['username']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required value="<?php echo $formData['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirme a senha</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2 p-2 submit-button">Registrar</button>
                    <button type="button" id="googleSignIn" class="btn btn-secondary w-100 p-2 google-button">
                        <i class="bi bi-google me-2"></i>Continuar com Google
                    </button>
                </form>
                <h5 class="text-center" id="link-account">Já tem uma conta? <a href="index.php?page=login">Faça login</a></h5>
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
                alert('Funcionalidade de login com Google será implementada em breve!');
                // Aqui você implementará a autenticação OAuth do Google
                // window.location.href = 'auth/google.php';
            });
        });
    </script>
</div>