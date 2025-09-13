<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Studena')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --primary: #667eea;
            --primary-dark: #5a67d8;
            --secondary: #764ba2;
            --success: #48bb78;
            --warning: #ed8936;
            --danger: #f56565;
            --info: #4299e1;
            --light: #f7fafc;
            --dark: #2d3748;
            --gray: #718096;
            --gray-light: #e2e8f0;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
            --radius: 8px;
            --radius-lg: 12px;
        }
        
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }
        
        .dashboard {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--white);
            box-shadow: var(--shadow-lg);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid var(--gray-light);
        }
        
        .sidebar-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .sidebar-header p {
            color: var(--gray);
            font-size: 0.875rem;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin: 0.25rem 1rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--gray);
            text-decoration: none;
            border-radius: var(--radius);
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .nav-link:hover {
            background: var(--light);
            color: var(--primary);
        }
        
        .nav-link.active {
            background: var(--primary);
            color: var(--white);
        }
        
        .nav-link svg {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            background: var(--light);
        }
        
        .topbar {
            background: var(--white);
            padding: 1rem 2rem;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .topbar-content {
            display: flex;
            justify-content: between;
            align-items: center;
        }
        
        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--dark);
        }
        
        .content {
            padding: 2rem;
        }
        
        /* Cards */
        .card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-light);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-light);
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary);
            transition: transform 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .stat-card.success {
            border-left-color: var(--success);
        }
        
        .stat-card.warning {
            border-left-color: var(--warning);
        }
        
        .stat-card.danger {
            border-left-color: var(--danger);
        }
        
        .stat-card.info {
            border-left-color: var(--info);
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--gray);
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .stat-icon.primary {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary);
        }
        
        .stat-icon.success {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success);
        }
        
        .stat-icon.warning {
            background: rgba(237, 137, 54, 0.1);
            color: var(--warning);
        }
        
        .stat-icon.danger {
            background: rgba(245, 101, 101, 0.1);
            color: var(--danger);
        }
        
        .stat-icon.info {
            background: rgba(66, 153, 225, 0.1);
            color: var(--info);
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--radius);
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }
        
        .btn svg {
            width: 16px;
            height: 16px;
            margin-right: 0.5rem;
        }
        
        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        
        .btn-success {
            background: var(--success);
            color: var(--white);
        }
        
        .btn-warning {
            background: var(--warning);
            color: var(--white);
        }
        
        .btn-danger {
            background: var(--danger);
            color: var(--white);
        }
        
        .btn-secondary {
            background: var(--gray-light);
            color: var(--dark);
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background: var(--primary);
            color: var(--white);
        }
        
        /* Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
        }
        
        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-primary {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary);
        }
        
        .badge-success {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success);
        }
        
        .badge-warning {
            background: rgba(237, 137, 54, 0.1);
            color: var(--warning);
        }
        
        .badge-danger {
            background: rgba(245, 101, 101, 0.1);
            color: var(--danger);
        }
        
        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius);
            font-size: 0.875rem;
            transition: border-color 0.2s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius);
            font-size: 0.875rem;
            background: var(--white);
        }
        
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius);
            font-size: 0.875rem;
            resize: vertical;
            min-height: 100px;
        }
        
        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success);
            border: 1px solid rgba(72, 187, 120, 0.2);
        }
        
        .alert-error {
            background: rgba(245, 101, 101, 0.1);
            color: var(--danger);
            border: 1px solid rgba(245, 101, 101, 0.2);
        }
        
        .alert-info {
            background: rgba(66, 153, 225, 0.1);
            color: var(--info);
            border: 1px solid rgba(66, 153, 225, 0.2);
        }
        
        /* Loading */
        .loading {
            text-align: center;
            padding: 3rem;
            color: var(--gray);
        }
        
        .spinner {
            border: 3px solid var(--gray-light);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Match Results */
        .match-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 1rem;
            border-left: 4px solid var(--success);
            transition: all 0.2s ease;
        }
        
        .match-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .match-card.perfect {
            border-left-color: var(--success);
        }
        
        .match-card.good {
            border-left-color: var(--warning);
        }
        
        .match-card.bad {
            border-left-color: var(--danger);
        }
        
        .match-score {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .match-score.perfect {
            color: var(--success);
        }
        
        .match-score.good {
            color: var(--warning);
        }
        
        .match-score.bad {
            color: var(--danger);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h1>🎓 Studena</h1>
                <p>Dashboard Matchmaking</p>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-item">
                    <a href="{{ route('matchmaking.index') }}" class="nav-link {{ request()->routeIs('matchmaking.*') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                        </svg>
                        Dashboard
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('tutors.index') }}" class="nav-link {{ request()->routeIs('tutors.*') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Tuteurs
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                        Étudiants
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('matchmaking.example') }}" class="nav-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Exemple
                    </a>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="topbar">
                <div class="topbar-content">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                </div>
            </div>
            
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Configuration CSRF pour les requêtes AJAX
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Fonction utilitaire pour les requêtes AJAX
        async function fetchData(url, options = {}) {
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            };
            
            const response = await fetch(url, { ...defaultOptions, ...options });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.json();
        }

        // Fonction pour afficher les résultats
        function displayResults(data, containerId = 'results') {
            const container = document.getElementById(containerId);
            if (!container) return;

            let html = '<div class="card"><div class="card-header"><h2 class="card-title">🎯 Résultats du Matchmaking</h2></div>';
            
            if (data.results) {
                data.results.forEach(result => {
                    html += `<div class="match-card">
                        <h3>👨‍🎓 ${result.student.name}</h3>
                        <p><strong>Niveau:</strong> ${result.student.school_level}</p>`;
                    
                    if (result.best_match) {
                        const match = result.best_match;
                        const scoreClass = match.score >= 90 ? 'perfect' : match.score >= 70 ? 'good' : 'bad';
                        html += `<div class="match-score ${scoreClass}">
                            <h4>🏆 Meilleur match: ${match.tutor.name}</h4>
                            <p><strong>Score de compatibilité:</strong> ${match.score}/100</p>
                            <p><strong>Expérience:</strong> ${match.tutor.experience_years} ans</p>
                            <p><strong>Tarif:</strong> ${match.tutor.hourly_rate}€/h</p>
                        </div>`;
                    } else {
                        html += '<p>❌ Aucun tuteur compatible trouvé</p>';
                    }
                    
                    html += '</div>';
                });
            } else if (data.student && data.matches) {
                html += `<h3>👨‍🎓 ${data.student.name}</h3>`;
                data.matches.forEach(match => {
                    const scoreClass = match.score >= 90 ? 'perfect' : match.score >= 70 ? 'good' : 'bad';
                    html += `<div class="match-score ${scoreClass}">
                        <h4>👨‍🏫 ${match.tutor.name}</h4>
                        <p><strong>Score:</strong> ${match.score}/100</p>
                        <p><strong>Expérience:</strong> ${match.tutor.experience_years} ans</p>
                        <p><strong>Tarif:</strong> ${match.tutor.hourly_rate}€/h</p>
                    </div>`;
                });
            }
            
            html += '</div>';
            container.innerHTML = html;
        }

        // Fonction pour afficher un spinner de chargement
        function showLoading(containerId = 'results') {
            const container = document.getElementById(containerId);
            if (container) {
                container.innerHTML = `
                    <div class="loading">
                        <div class="spinner"></div>
                        <p>Chargement en cours...</p>
                    </div>
                `;
            }
        }
    </script>

    @yield('scripts')
</body>
</html> 