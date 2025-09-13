@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Vue d\'ensemble du système de matchmaking')

@section('content')
<div class="row">
    <!-- Statistiques -->
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="stats-icon primary">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="stats-number">{{ $stats['tutors'] }}</div>
                    <div class="stats-label">Tuteurs</div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="stats-icon success">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stats-number">{{ $stats['students'] }}</div>
                    <div class="stats-label">Étudiants</div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="stats-icon warning">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="stats-number">{{ $stats['total_matches'] }}</div>
                    <div class="stats-label">Matchs totaux</div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="stats-icon danger">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="stats-number">{{ $stats['perfect_matches'] }}</div>
                    <div class="stats-label">Matchs parfaits</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Actions rapides -->
    <div class="col-md-6 mb-4">
        <div class="action-card">
            <h5 class="mb-3">
                <i class="bi bi-lightning-charge text-primary me-2"></i>
                Actions Rapides
            </h5>
            
            <a href="{{ route('tutors.create') }}" class="btn-action">
                <i class="bi bi-plus-circle"></i>
                Ajouter un Tuteur
            </a>
            
            <a href="{{ route('students.create') }}" class="btn-action">
                <i class="bi bi-plus-circle"></i>
                Ajouter un Étudiant
            </a>
            
            <a href="{{ route('matchmaking.example') }}" class="btn-action">
                <i class="bi bi-play-circle"></i>
                Exécuter l'exemple
            </a>
            
            <a href="{{ route('tutors.index') }}" class="btn-action">
                <i class="bi bi-list-ul"></i>
                Voir les Tuteurs
            </a>
            
            <a href="{{ route('students.index') }}" class="btn-action">
                <i class="bi bi-list-ul"></i>
                Voir les Étudiants
            </a>
        </div>
    </div>
    
    <!-- Liste des étudiants -->
    <div class="col-md-6 mb-4">
        <div class="action-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="bi bi-people text-success me-2"></i>
                    Étudiants
                </h5>
                <a href="{{ route('students.create') }}" class="btn btn-sm btn-outline-success">
                    <i class="bi bi-plus"></i> Ajouter
                </a>
            </div>
            
            @if($students->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($students as $student)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $student->name }}</h6>
                                <small class="text-muted">{{ $student->email }}</small>
                                <br>
                                <small class="text-muted">
                                    {{ ucfirst($student->school_level) }} - 
                                    {{ $student->subjects->pluck('name')->join(', ') }}
                                </small>
                            </div>
                            <div>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">Aucun étudiant trouvé</p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Ajouter le premier étudiant
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 