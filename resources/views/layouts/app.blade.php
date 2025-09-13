<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Studena Matchmaking')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #4f46e5;
            --secondary-color: #6366f1;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-brand {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .sidebar-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin: 0.25rem 0.75rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            font-weight: 600;
        }
        
        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        .content-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 2rem;
        }
        
        .content-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        
        .content-subtitle {
            color: #6b7280;
            font-size: 1.125rem;
        }
        
        .stats-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }
        
        .stats-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        
        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .stats-icon.primary {
            background-color: #eef2ff;
            color: var(--primary-color);
        }
        
        .stats-icon.success {
            background-color: #ecfdf5;
            color: var(--success-color);
        }
        
        .stats-icon.warning {
            background-color: #fffbeb;
            color: var(--warning-color);
        }
        
        .stats-icon.danger {
            background-color: #fef2f2;
            color: var(--danger-color);
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }
        
        .stats-label {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .action-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }
        
        .action-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        
        .btn-action {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background: white;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 0.5rem;
        }
        
        .btn-action:hover {
            background-color: #f9fafb;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-action i {
            margin-right: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                Studena
            </a>
            <div class="sidebar-subtitle">Matchmaking System</div>
        </div>
        
        <div class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 nav-icon"></i>
                    Dashboard
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('tutors.index') }}" class="nav-link {{ request()->routeIs('tutors.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge nav-icon"></i>
                    Tuteurs
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                    <i class="bi bi-people nav-icon"></i>
                    Étudiants
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('subjects.index') }}" class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                    <i class="bi bi-book nav-icon"></i>
                    Matières
                </a>
            </div>

            
            
            <div class="nav-item">
                <a href="{{ route('matchmaking.example') }}" class="nav-link {{ request()->routeIs('matchmaking.*') ? 'active' : '' }}">
                    <i class="bi bi-lightning-charge nav-icon"></i>
                    Matchmaking
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph nav-icon"></i>
                    Rapports
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('calendar.index') }}" class="nav-link {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-week nav-icon"></i>
                    Calendrier
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('messages.index') }}" class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots nav-icon"></i>
                    Messages
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear nav-icon"></i>
                    Paramètres
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header p-3">
            <span class="card-title fw-bold">@yield('title', 'Dashboard')</span>
        </div>
        
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 