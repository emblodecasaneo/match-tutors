@extends('layouts.app')

@section('title', 'Rapports et Statistiques')
@section('subtitle', 'Analyse des performances du système')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Rapports et Statistiques</h4>
                <small class="text-muted">Analyse des performances du système de matchmaking</small>
            </div>
            <div>
                <a href="{{ route('reports.statistics') }}" class="btn btn-info btn-sm me-2">
                    <i class="bi bi-graph-up me-1"></i>Statistiques détaillées
                </a>
                <a href="{{ route('reports.export') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-download me-1"></i>Exporter
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques principales -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-center text-white p-3">
                <i class="bi bi-person-check fs-4 mb-2"></i>
                <div class="fs-5 fw-bold">{{ $stats['total_tutors'] }}</div>
                <div class="small opacity-75">Tuteurs</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="card-body text-center text-white p-3">
                <i class="bi bi-people fs-4 mb-2"></i>
                <div class="fs-5 fw-bold">{{ $stats['total_students'] }}</div>
                <div class="small opacity-75">Étudiants</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <div class="card-body text-center text-white p-3">
                <i class="bi bi-book fs-4 mb-2"></i>
                <div class="fs-5 fw-bold">{{ $stats['total_subjects'] }}</div>
                <div class="small opacity-75">Matières</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
            <div class="card-body text-center text-white p-3">
                <i class="bi bi-graph-up fs-4 mb-2"></i>
                <div class="fs-5 fw-bold">{{ $stats['match_rate'] }}%</div>
                <div class="small opacity-75">Taux de match</div>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques de matchmaking -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0">
                    <i class="bi bi-check-circle me-2"></i>Résultats du Matchmaking
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <div class="fs-4 fw-bold text-primary">{{ $stats['total_matches'] }}</div>
                            <div class="small text-muted">Matchs totaux</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="fs-4 fw-bold text-success">{{ $stats['perfect_matches'] }}</div>
                        <div class="small text-muted">Matchs parfaits</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Répartition des Matchs
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small">Matchs parfaits</span>
                    <span class="badge bg-success">{{ $stats['perfect_matches'] }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small">Matchs partiels</span>
                    <span class="badge bg-warning">{{ $stats['total_matches'] - $stats['perfect_matches'] }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small">Aucun match</span>
                    <span class="badge bg-secondary">{{ $stats['total_students'] - $stats['total_matches'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graphiques et analyses -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0">
                    <i class="bi bi-bar-chart me-2"></i>Analyse des Performances
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <div class="p-3 rounded" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                            <i class="bi bi-clock text-warning fs-3 mb-2"></i>
                            <div class="fw-bold text-dark">Temps moyen</div>
                            <div class="small text-muted">de traitement</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="p-3 rounded" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);">
                            <i class="bi bi-cpu text-primary fs-3 mb-2"></i>
                            <div class="fw-bold text-dark">Efficacité</div>
                            <div class="small text-muted">de l'algorithme</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="p-3 rounded" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);">
                            <i class="bi bi-check-circle text-success fs-3 mb-2"></i>
                            <div class="fw-bold text-dark">Satisfaction</div>
                            <div class="small text-muted">des utilisateurs</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0">
                    <i class="bi bi-list-check me-2"></i>Actions Rapides
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('matchmaking.example') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-play-circle me-1"></i>Lancer le matchmaking
                    </a>
                    <a href="{{ route('tutors.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-person-check me-1"></i>Gérer les tuteurs
                    </a>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-people me-1"></i>Gérer les étudiants
                    </a>
                    <a href="{{ route('reports.export') }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-download me-1"></i>Télécharger le rapport
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 