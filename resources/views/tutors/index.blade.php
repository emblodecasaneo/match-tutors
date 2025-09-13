@extends('layouts.app')

@section('title', 'Liste des Tuteurs')
@section('subtitle', 'Gestion des tuteurs')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Tuteurs</h4>
                <small class="text-muted">{{ $tutors->count() }} tuteur{{ $tutors->count() > 1 ? 's' : '' }} enregistré{{ $tutors->count() > 1 ? 's' : '' }}</small>
            </div>
            <a href="{{ route('tutors.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Nouveau
            </a>
        </div>

        @if($tutors->count() > 0)
            <div class="row g-4">
                @foreach($tutors as $tutor)
                    <div class="col-lg-4 col-md-6">
                        <div class="tutor-card h-100">
                            <div class="tutor-header">
                                <div class="tutor-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div class="tutor-info">
                                    <h5 class="tutor-name">{{ $tutor->name }}</h5>
                                    <p class="tutor-email">{{ $tutor->email }}</p>
                                </div>
                                <div class="tutor-actions">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('tutors.edit', $tutor) }}">
                                                <i class="bi bi-pencil me-2"></i>Modifier
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('tutors.destroy', $tutor) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                                        <i class="bi bi-trash me-2"></i>Supprimer
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tutor-body">
                                <div class="tutor-stats">
                                    <div class="stat-item">
                                        <i class="bi bi-clock text-primary"></i>
                                        <span>{{ $tutor->experience_years }} ans</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="bi bi-currency-euro text-success"></i>
                                        <span>{{ $tutor->hourly_rate }}€/h</span>
                                    </div>
                                </div>
                                
                                <div class="tutor-subjects">
                                    <label class="section-label">Matières</label>
                                    <div class="subjects-tags">
                                        @foreach($tutor->subjects as $subject)
                                            <span class="subject-tag">{{ $subject->name }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="tutor-levels">
                                    <label class="section-label">Niveaux</label>
                                    <div class="levels-tags">
                                        @foreach($tutor->school_levels as $level)
                                            <span class="level-tag">{{ ucfirst($level) }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                @if($tutor->bio)
                                    <div class="tutor-bio">
                                        <p class="bio-text">{{ Str::limit($tutor->bio, 100) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="text-center py-5">
                    <div class="empty-icon mb-4">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h4 class="text-muted mb-3">Aucun tuteur trouvé</h4>
                    <p class="text-muted mb-4">Commencez par ajouter votre premier tuteur.</p>
                    <a href="{{ route('tutors.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Ajouter un tuteur
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.tutor-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.tutor-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.tutor-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #5b21b6 100%);
    color: white;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.tutor-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
}

.tutor-info {
    flex: 1;
}

.tutor-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.tutor-email {
    font-size: 0.875rem;
    opacity: 0.9;
    margin: 0;
}

.tutor-actions .btn {
    border-color: rgba(255,255,255,0.3);
    color: white;
}

.tutor-actions .btn:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.5);
}

.tutor-body {
    padding: 1.5rem;
}

.tutor-stats {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6c757d;
}

.section-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: #6c757d;
    margin-bottom: 0.5rem;
    display: block;
}

.tutor-subjects, .tutor-levels {
    margin-bottom: 1rem;
}

.subjects-tags, .levels-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
}

.subject-tag {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    color: #1976d2;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    border: 1px solid #90caf9;
}

.level-tag {
    background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
    color: #7b1fa2;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    border: 1px solid #ce93d8;
}

.tutor-bio {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
}

.bio-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin: 0;
    line-height: 1.4;
}

.empty-state {
    background: #f8f9fa;
    border-radius: 12px;
    border: 2px dashed #dee2e6;
}

.empty-icon {
    font-size: 4rem;
    color: #dee2e6;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

@media (max-width: 768px) {
    .tutor-header {
        flex-direction: column;
        text-align: center;
    }
    
    .tutor-stats {
        justify-content: center;
    }
}
</style>
@endsection