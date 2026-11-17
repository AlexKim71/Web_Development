<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRM') - CRM Фотоссесій</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #43e97b;
            --danger-color: #f5576c;
            --warning-color: #f093fb;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .sidebar {
            background: linear-gradient(180deg, #34495e 0%, #2c3e50 100%);
            min-height: calc(100vh - 56px);
            color: #ecf0f1;
            position: fixed;
            width: 250px;
            padding: 20px 0;
            left: 0;
            top: 56px;
        }

        .sidebar a {
            color: #bdc3c7;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #2c3e50;
            border-left-color: #3498db;
            color: #ecf0f1;
            padding-left: 25px;
        }

        .sidebar a.active {
            background-color: #2c3e50;
            border-left-color: #3498db;
            color: #3498db;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            min-height: calc(100vh - 56px);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
                min-height: auto;
            }
            .main-content {
                margin-left: 0;
            }
        }

        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-radius: 8px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-card h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-card h5 {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
        }

        .stat-card.success {
            background: linear-gradient(135deg, var(--success-color) 0%, #38f9d7 100%);
        }

        .stat-card.danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #fa7e7e 100%);
        }

        .stat-card.warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #f5576c 100%);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
        }

        .table tbody tr {
            transition: background-color 0.2s;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 500;
        }

        .alert {
            border: none;
            border-radius: 8px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3f93 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .sidebar-section {
            padding: 15px 0;
            margin: 10px 0;
        }

        .sidebar-label {
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #95a5a6;
            padding: 0 20px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .user-info {
            padding: 15px 20px;
            background-color: rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .user-info small {
            color: #bdc3c7;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                📸 CRM Фотоссесій
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                👤 {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Профіль</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Вихід</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Вхід</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @auth
    <div class="d-flex">
        <div class="sidebar">
            <div class="user-info">
                <small>👤 Користувач</small>
                <div>{{ Auth::user()->name }}</div>
                @if(Auth::user()->hasRole('admin'))
                    <span class="badge bg-danger mt-2">Адміністратор</span>
                @elseif(Auth::user()->hasRole('manager'))
                    <span class="badge bg-warning mt-2">Менеджер</span>
                @else
                    <span class="badge bg-info mt-2">Клієнт</span>
                @endif
            </div>

            <div class="sidebar-section">
                <div class="sidebar-label">Навігація</div>
                <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">
                    <i class="fas fa-chart-line"></i> Дашбоард
                </a>
                <a href="{{ route('clients.index') }}" class="@if(request()->routeIs('clients.*')) active @endif">
                    <i class="fas fa-users"></i> Клієнти
                </a>
                <a href="{{ route('photo-sessions.index') }}" class="@if(request()->routeIs('photo-sessions.*')) active @endif">
                    <i class="fas fa-camera"></i> Фотоссесії
                </a>
            </div>

            @if(Auth::user()->hasRole('admin'))
            <div class="sidebar-section">
                <div class="sidebar-label">Дії</div>
                <a href="{{ route('clients.create') }}">
                    <i class="fas fa-plus"></i> Новий клієнт
                </a>
                <a href="{{ route('photo-sessions.create') }}">
                    <i class="fas fa-plus"></i> Нова фотоссесія
                </a>
            </div>
            @endif
        </div>

        <div class="main-content flex-grow-1">
    @else
        <div style="width: 100%;">
    @endauth
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-circle"></i> Помилка!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <script>
        // Активне посилання в меню
        document.querySelectorAll('.sidebar a').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>

