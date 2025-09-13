@extends('layouts.app')

@section('title', 'Modifier la Matière')
@section('subtitle', 'Modification des informations')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <div class="d-flex align-items-center">
                    <div class="avatar-circle me-3">
                        <i class="bi bi-book-gear"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Modifier {{ $subject->name }}</h5>
                        <small class="text-white-50">Mise à jour des informations de la matière</small>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('subjects.update', $subject) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $subject->name) }}" placeholder="Nom de la matière" required>
                        <label for="name">Nom de la matière</label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-floating mb-4">
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" style="height: 100px" placeholder="Description">{{ old('description', $subject->description) }}</textarea>
                        <label for="description">Description</label>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: #8b5cf6;
}

.form-control:focus {
    border-color: #8b5cf6;
    box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
}

.btn-outline-secondary {
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
}
</style>
@endsection 