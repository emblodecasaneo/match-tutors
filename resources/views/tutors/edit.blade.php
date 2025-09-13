@extends('layouts.app')

@section('title', 'Modifier le Tuteur')
@section('subtitle', 'Modification des informations')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12">
        <div class="card shadow-sm">
            <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex align-items-center">
                    <div class="avatar-circle me-3">
                        <i class="bx bx-user"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 text-black">Modifier {{ $tutor->name }}</h5>
                        <small class="text-black">Mise à jour des informations du tuteur</small>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('tutors.update', $tutor) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Première ligne : Nom, Email, Téléphone, Expérience -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $tutor->name) }}" placeholder="Nom complet" required>
                                <label for="name">Nom complet</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $tutor->email) }}" placeholder="Email" required>
                                <label for="email">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $tutor->phone) }}" placeholder="Téléphone">
                                <label for="phone">Téléphone</label>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="number" class="form-control @error('experience_years') is-invalid @enderror" 
                                       id="experience_years" name="experience_years" value="{{ old('experience_years', $tutor->experience_years) }}" 
                                       placeholder="Années d'expérience" min="0" required>
                                <label for="experience_years">Expérience (ans)</label>
                                @error('experience_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Deuxième ligne : Tarif et Bio -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" step="0.01" class="form-control @error('hourly_rate') is-invalid @enderror" 
                                       id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $tutor->hourly_rate) }}" 
                                       placeholder="Tarif horaire" min="0">
                                <label for="hourly_rate">Tarif horaire (€)</label>
                                @error('hourly_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="form-floating">
                                <textarea class="form-control @error('bio') is-invalid @enderror" 
                                          id="bio" name="bio" style="height: 60px" placeholder="Biographie">{{ old('bio', $tutor->bio) }}</textarea>
                                <label for="bio">Biographie</label>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Troisième ligne : Matières -->
                    <div class="mb-4">
                        <h6 class="section-title-compact">
                            <i class="bi bi-book me-2"></i>Matières enseignées
                        </h6>
                        <div class="subjects-grid-compact">
                            @foreach($subjects as $subject)
                                <div class="form-check form-check-compact">
                                    <input class="form-check-input" type="checkbox" 
                                           name="subjects[]" value="{{ $subject->id }}" 
                                           id="subject_{{ $subject->id }}"
                                           {{ in_array($subject->id, old('subjects', $tutor->subjects->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                    
                    <!-- Quatrième ligne : Niveaux scolaires et boutons -->
                    <div class="row g-3">
                        <div class="col-md-8">
                            <h6 class="section-title-compact">
                                <i class="bi bi-mortarboard me-2"></i>Niveaux scolaires
                            </h6>
                            <div class="levels-grid-compact">
                                @php
                                    $currentLevels = old('school_levels', $tutor->school_levels);
                                @endphp
                                <div class="form-check form-check-compact">
                                    <input class="form-check-input" type="checkbox" name="school_levels[]" 
                                           value="college" id="college" {{ in_array('college', $currentLevels) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="college">Collège</label>
                                </div>
                                <div class="form-check form-check-compact">
                                    <input class="form-check-input" type="checkbox" name="school_levels[]" 
                                           value="lycee" id="lycee" {{ in_array('lycee', $currentLevels) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="lycee">Lycée</label>
                                </div>
                                <div class="form-check form-check-compact">
                                    <input class="form-check-input" type="checkbox" name="school_levels[]" 
                                           value="terminale" id="terminale" {{ in_array('terminale', $currentLevels) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="terminale">Terminale</label>
                                </div>
                                <div class="form-check form-check-compact">
                                    <input class="form-check-input" type="checkbox" name="school_levels[]" 
                                           value="university" id="university" {{ in_array('university', $currentLevels) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="university">Université</label>
                                </div>
                            </div>
                            @error('school_levels')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="d-flex gap-2 w-100">
                                <a href="{{ route('tutors.index') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="bi bi-arrow-left me-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-primary flex-fill">
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

.subjects-grid-compact, .levels-grid-compact {
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
    border-color: #667eea;
    background: #f0f2ff;
}

.form-check-compact .form-check-input:checked + .form-check-label {
    color: #667eea;
    font-weight: 600;
}

.form-check-compact .form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.form-check-compact .form-check-label {
    font-size: 0.875rem;
    margin-left: 0.5rem;
}

@media (max-width: 768px) {
    .subjects-grid-compact, .levels-grid-compact {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    }
    
    .row.g-3 > .col-md-3, .row.g-3 > .col-md-4 {
        margin-bottom: 1rem;
    }
}
</style>
@endsection 