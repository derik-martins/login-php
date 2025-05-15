<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

include 'includes/Auth.php';

// Store the welcome message for use in the template
$welcomeMessage = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0046c8;
            --secondary-color: #0a1e3c;
            --accent-color: #00c3ff;
            --dark-blue: #051a38;
            --light-blue: #e6f3ff;
            --gradient-blue: linear-gradient(135deg, #0046c8, #00c3ff);
        }

        body {
            background-color: #f0f5ff;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: var(--secondary-color);
            color: #fff;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .sidebar .logo-area {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            border-radius: 8px;
            margin: 4px 10px;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff;
            background-color: rgba(0, 198, 255, 0.2);
            box-shadow: 0 0 10px rgba(0, 198, 255, 0.3);
        }

        .nav-link.active {
            border-left: 3px solid var(--accent-color);
        }

        .nav-link i {
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 16px rgba(10, 30, 60, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: white;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(10, 30, 60, 0.12);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #e6f0ff;
            font-weight: 600;
            color: var(--secondary-color);
        }

        .stats-card {
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--gradient-blue);
        }

        .stats-card .card-body {
            padding-top: 20px;
            position: relative;
            z-index: 1;
        }

        .stats-card .icon-bg {
            position: absolute;
            right: -15px;
            bottom: -15px;
            font-size: 5rem;
            opacity: 0.1;
            color: var(--primary-color);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
        }

        .main-content {
            background-color: #f0f5ff;
        }

        .dropdown-toggle {
            border-radius: 20px;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table tr {
            box-shadow: 0 2px 6px rgba(10, 30, 60, 0.04);
            border-radius: 8px;
        }

        .table td,
        .table th {
            background-color: white;
            vertical-align: middle;
            padding: 12px 16px;
        }

        .table tbody tr td:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .table tbody tr td:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .dashboard-header {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(10, 30, 60, 0.08);
            padding: 16px 24px;
            margin-bottom: 24px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0">
                <div class="logo-area text-center">
                    <h4 class="mb-0">
                        <i class="bi bi-hexagon-fill me-2 text-info"></i>
                        TechAdmin
                    </h4>
                </div>
                <div class="position-sticky">
                    <div class="text-center mb-4">
                        <div class="bg-white mx-auto mb-3" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person-fill text-primary" style="font-size: 1.8rem;"></i>
                        </div>
                        <p class="text-light mb-0">
                            Bem-vindo, <?php echo $welcomeMessage; ?>!
                        </p>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-people me-2"></i>
                                Usuários
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-bar-chart me-2"></i>
                                Estatísticas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-file-earmark-text me-2"></i>
                                Relatórios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-gear me-2"></i>
                                Configurações
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <a class="nav-link text-danger" href="logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4 py-4 main-content">
                <div class="dashboard-header d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4">
                    <div>
                        <h4 class="m-0 text-primary">Dashboard</h4>
                        <p class="text-muted m-0">Visão geral e análises</p>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-share me-1"></i> Compartilhar
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download me-1"></i> Exportar
                            </button>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle">
                            <i class="bi bi-calendar-week me-1"></i>
                            Esta semana
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row my-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted">Usuários</h6>
                                        <h3 class="mb-0">5,230</h3>
                                        <p class="card-text text-success mb-0">
                                            <i class="bi bi-arrow-up-short"></i>3.5%
                                        </p>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                        <i class="bi bi-people text-primary fs-3"></i>
                                    </div>
                                </div>
                                <i class="bi bi-people icon-bg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted">Receita</h6>
                                        <h3 class="mb-0">R$ 15K</h3>
                                        <p class="card-text text-success mb-0">
                                            <i class="bi bi-arrow-up-short"></i>8.2%
                                        </p>
                                    </div>
                                    <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                        <i class="bi bi-currency-dollar text-success fs-3"></i>
                                    </div>
                                </div>
                                <i class="bi bi-currency-dollar icon-bg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted">Pedidos</h6>
                                        <h3 class="mb-0">1,753</h3>
                                        <p class="card-text text-danger mb-0">
                                            <i class="bi bi-arrow-down-short"></i>1.2%
                                        </p>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                        <i class="bi bi-cart3 text-warning fs-3"></i>
                                    </div>
                                </div>
                                <i class="bi bi-cart3 icon-bg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted">Visitas</h6>
                                        <h3 class="mb-0">20,241</h3>
                                        <p class="card-text text-success mb-0">
                                            <i class="bi bi-arrow-up-short"></i>5.1%
                                        </p>
                                    </div>
                                    <div class="bg-info bg-opacity-10 rounded-3 p-3">
                                        <i class="bi bi-eye text-info fs-3"></i>
                                    </div>
                                </div>
                                <i class="bi bi-eye icon-bg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mb-4">
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Visão Geral de Vendas</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#">Exportar</a></li>
                                        <li><a class="dropdown-item" href="#">Detalhes</a></li>
                                        <li><a class="dropdown-item" href="#">Configurar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="bg-light rounded-3" style="height: 300px; display: flex; align-items: center; justify-content: center; background-color: #f5f9ff !important; background-image: linear-gradient(rgba(0, 70, 200, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(0, 70, 200, 0.05) 1px, transparent 1px); background-size: 20px 20px;">
                                    <div class="text-center">
                                        <i class="bi bi-bar-chart-line text-primary" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-2">Gráfico de Vendas (Simulado)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Distribuição de Tráfego</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <li><a class="dropdown-item" href="#">Exportar</a></li>
                                        <li><a class="dropdown-item" href="#">Detalhes</a></li>
                                        <li><a class="dropdown-item" href="#">Configurar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="bg-light rounded-3" style="height: 300px; display: flex; align-items: center; justify-content: center; background-color: #f5f9ff !important; background-image: radial-gradient(circle, rgba(0, 70, 200, 0.05) 1px, transparent 1px); background-size: 15px 15px;">
                                    <div class="text-center">
                                        <i class="bi bi-pie-chart text-primary" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-2">Gráfico de Pizza (Simulado)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Table -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Atividades Recentes</span>
                                <button class="btn btn-sm btn-primary rounded-pill">
                                    <i class="bi bi-plus-lg me-1"></i> Nova Atividade
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="rounded-start">#</th>
                                                <th scope="col">Usuário</th>
                                                <th scope="col">Atividade</th>
                                                <th scope="col">Status</th>
                                                <th scope="col" class="rounded-end">Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">MS</div>
                                                        Maria Silva
                                                    </div>
                                                </td>
                                                <td>Novo cadastro</td>
                                                <td><span class="badge bg-success">Completo</span></td>
                                                <td>01/06/2023</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-warning text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">JS</div>
                                                        João Santos
                                                    </div>
                                                </td>
                                                <td>Atualização de perfil</td>
                                                <td><span class="badge bg-warning">Pendente</span></td>
                                                <td>31/05/2023</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-info text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">AO</div>
                                                        Ana Oliveira
                                                    </div>
                                                </td>
                                                <td>Compra finalizada</td>
                                                <td><span class="badge bg-success">Completo</span></td>
                                                <td>30/05/2023</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-danger text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">CP</div>
                                                        Carlos Pereira
                                                    </div>
                                                </td>
                                                <td>Solicitação de suporte</td>
                                                <td><span class="badge bg-danger">Cancelado</span></td>
                                                <td>29/05/2023</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">5</th>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-success text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">LC</div>
                                                        Luiza Costa
                                                    </div>
                                                </td>
                                                <td>Atualização de endereço</td>
                                                <td><span class="badge bg-info">Em progresso</span></td>
                                                <td>28/05/2023</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>