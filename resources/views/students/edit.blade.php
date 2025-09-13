@extends('layouts.app')

@section('title', 'Modifier l\'Étudiant')
@section('subtitle', 'Modification des informations')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12">
        <div class="card shadow-sm">
            <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="d-flex align-items-center">
                    <div class="avatar-circle me-3">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 text-black">Modifier {{ $student->name }}</h5>
                        <small class="text-black">Mise à jour des informations de l'étudiant</small>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('students.update', $student) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Première ligne : Nom, Email, Téléphone, Niveau -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $student->name) }}" placeholder="Nom complet" required>
                                <label for="name">Nom complet</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $student->email) }}" placeholder="Email" required>
                                <label for="email">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $student->phone) }}" placeholder="Téléphone">
                                <label for="phone">Téléphone</label>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select @error('school_level') is-invalid @enderror" 
                                        id="school_level" name="school_level" required>
                                    <option value="">Sélectionnez</option>
                                    <option value="college" {{ old('school_level', $student->school_level) == 'college' ? 'selected' : '' }}>Collège</option>
                                    <option value="lycee" {{ old('school_level', $student->school_level) == 'lycee' ? 'selected' : '' }}>Lycée</option>
                                    <option value="terminale" {{ old('school_level', $student->school_level) == 'terminale' ? 'selected' : '' }}>Terminale</option>
                                    <option value="university" {{ old('school_level', $student->school_level) == 'university' ? 'selected' : '' }}>Université</option>
                                </select>
                                <label for="school_level">Niveau scolaire</label>
                                @error('school_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Deuxième ligne : Matières en grid compact -->
                    <div class="mb-4">
                        <h6 class="section-title-compact">
                            <i class="bi bi-book me-2"></i>Matières demandées
                        </h6>
                        <div class="subjects-grid-compact">
                            @foreach(\App\Models\Subject::all() as $subject)
                                <div class="form-check form-check-compact">
                                    <input class="form-check-input" type="checkbox" 
                                           name="subjects[]" value="{{ $subject->id }}" 
                                           id="subject_{{ $subject->id }}"
                                           {{ in_array($subject->id, old('subjects', $student->subjects->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="subject_{{ $subject->id }}">
                                        {{ $subject->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('subjects')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Troisième ligne : Notes et boutons -->
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="form-floating">
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" style="height: 60px" placeholder="Notes">{{ old('notes', $student->notes) }}</textarea>
                                <label for="notes">Notes supplémentaires</label>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="d-flex gap-2 w-100">
                                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="bi bi-arrow-left me-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-success flex-fill">
                                    <i class="bi bi-check-lg me-1"></i>Mettre à jour
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.section-title-compact {
    color: #495057;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
}

.subjects-grid-compact {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 0.5rem;
}

.form-check-compact {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 0.5rem 0.75rem;
    transition: all 0.2s ease;
    margin: 0;
}

.form-check-compact:hover {
    border-color: #10b981;
    background: #f0fdf4;
}

.form-check-compact .form-check-input:checked + .form-check-label {
    color: #10b981;
    font-weight: 600;
}

.form-check-compact .form-check-input:checked {
    background-color: #10b981;
    border-color: #10b981;
}

.form-check-compact .form-check-label {
    font-size: 0.875rem;
    margin-left: 0.5rem;
}

@media (max-width: 768px) {
    .subjects-grid-compact {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    }
    
    .row.g-3 > .col-md-3 {
        margin-bottom: 1rem;
    }
}
</style>
@endsection 