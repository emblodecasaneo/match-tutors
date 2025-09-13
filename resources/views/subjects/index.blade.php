@extends('layouts.app')

@section('title', 'Liste des Matières')
@section('subtitle', 'Gestion des matières enseignées')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Matières</h4>
                <small class="text-muted">{{ $subjects->count() }} matière{{ $subjects->count() > 1 ? 's' : '' }} enregistrée{{ $subjects->count() > 1 ? 's' : '' }}</small>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                <i class="bi bi-plus-circle me-1"></i>Ajouter une matière
            </button>
        </div>
    </div>
</div>

<!-- Grille des matières -->
<div class="row">
    @foreach($subjects as $subject)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        <div class="avatar-circle bg-primary text-white">
                            <i class="bi bi-book"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1 fw-bold">{{ $subject->name }}</h6>
                        <small class="text-muted">{{ $subject->tutors_count ?? 0 }} tuteur{{ ($subject->tutors_count ?? 0) > 1 ? 's' : '' }}</small>
                    </div>
                </div>
                
                @if($subject->description)
                    <p class="text-muted small mb-3">{{ Str::limit($subject->description, 80) }}</p>
                @endif
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        <i class="bi bi-people me-1"></i>{{ $subject->students_count ?? 0 }} étudiant{{ ($subject->students_count ?? 0) > 1 ? 's' : '' }}
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" onclick="editSubject({{ $subject->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteSubject({{ $subject->id }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    @if($subjects->count() == 0)
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                <h5 class="text-muted mt-3">Aucune matière enregistrée</h5>
                <p class="text-muted">Commencez par ajouter des matières pour organiser votre système</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                    <i class="bi bi-plus-circle me-1"></i>Ajouter la première matière
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="addSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter une matière
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom de la matière</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (optionnel)</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
</style>
@endsection 