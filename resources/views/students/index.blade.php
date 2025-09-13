@extends('layouts.app')

@section('title', 'Liste des Étudiants')
@section('subtitle', 'Gestion des étudiants')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Étudiants</h4>
                <small class="text-muted">{{ $students->count() }} étudiant{{ $students->count() > 1 ? 's' : '' }} enregistré{{ $students->count() > 1 ? 's' : '' }}</small>
            </div>
            <a href="{{ route('students.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus"></i> Nouveau
            </a>
        </div>

        @if($students->count() > 0)
            <div class="row g-4">
                @foreach($students as $student)
                    <div class="col-lg-4 col-md-6">
                        <div class="student-card h-100">
                            <div class="student-header">
                                <div class="student-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div class="student-info">
                                    <h5 class="student-name">{{ $student->name }}</h5>
                                    <p class="student-email">{{ $student->email }}</p>
                                </div>
                                <div class="student-actions">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('students.edit', $student) }}">
                                                <i class="bi bi-pencil me-2"></i>Modifier
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
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
                            
                            <div class="student-body">
                                <div class="student-level">
                                    <div class="level-badge">
                                        <i class="bi bi-mortarboard me-2"></i>
                                        {{ ucfirst($student->school_level) }}
                                    </div>
                                </div>
                                
                                <div class="student-subjects">
                                    <label class="section-label">Matières demandées</label>
                                    <div class="subjects-tags">
                                        @foreach($student->subjects as $subject)
                                            <span class="subject-tag">{{ $subject->name }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                @if($student->notes)
                                    <div class="student-notes">
                                        <label class="section-label">Notes</label>
                                        <p class="notes-text">{{ Str::limit($student->notes, 100) }}</p>
                                    </div>
                                @endif

                                <div class="student-footer">
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil me-1"></i>Modifier
                                    </a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">
                                            <i class="bi bi-trash me-1"></i>Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="text-center py-5">
                    <div class="empty-icon mb-4">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="text-muted mb-3">Aucun étudiant trouvé</h4>
                    <p class="text-muted mb-4">Commencez par ajouter votre premier étudiant.</p>
                    <a href="{{ route('students.create') }}" class="btn btn-success">
                        <i class="bi bi-plus"></i> Ajouter un étudiant
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.student-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.student-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.student-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
    color: white;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.student-avatar {
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

.student-info {
    flex: 1;
}

.student-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.student-email {
    font-size: 0.875rem;
    opacity: 0.9;
    margin: 0;
}

.student-actions .btn {
    border-color: rgba(255,255,255,0.3);
    color: white;
}

.student-actions .btn:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.5);
}

.student-body {
    padding: 1.5rem;
}

.student-level {
    margin-bottom: 1rem;
}

.level-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
    color: #0369a1;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid #bae6fd;
    box-shadow: 0 2px 4px rgba(3, 105, 161, 0.1);
}

.section-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: #6c757d;
    margin-bottom: 0.5rem;
    display: block;
}

.student-subjects {
    margin-bottom: 1rem;
}

.subjects-tags {
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

.student-notes {
    margin-bottom: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.notes-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin: 0;
    line-height: 1.4;
}

.student-footer {
    display: flex;
    gap: 0.5rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.btn-outline-primary {
    border-color: #10b981;
    color: #10b981;
}

.btn-outline-primary:hover {
    background-color: #10b981;
    border-color: #10b981;
}

.btn-outline-danger {
    border-color: #ef4444;
    color: #ef4444;
}

.btn-outline-danger:hover {
    background-color: #ef4444;
    border-color: #ef4444;
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

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

@media (max-width: 768px) {
    .student-header {
        flex-direction: column;
        text-align: center;
    }
    
    .student-footer {
        flex-direction: column;
    }
    
    .student-footer .btn {
        width: 100%;
    }
}
</style>
@endsection