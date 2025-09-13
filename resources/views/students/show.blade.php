@extends('layouts.app')

@section('title', 'Détails de l\'Étudiant')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">👨‍🎓 {{ $student->name }}</h1>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('students.edit', $student) }}" class="btn btn-secondary">Modifier</a>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">← Retour</a>
        </div>
    </div>
    
    <div class="grid-2">
        <div>
            <h3>Informations personnelles</h3>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Téléphone:</strong> {{ $student->phone ?? 'Non renseigné' }}</p>
            <p><strong>Niveau scolaire:</strong> 
                <span class="badge badge-primary">{{ ucfirst($student->school_level) }}</span>
            </p>
            @if($student->notes)
                <p><strong>Notes:</strong> {{ $student->notes }}</p>
            @endif
        </div>
        
        <div>
            <h3>Matières demandées</h3>
            @forelse($student->subjects as $subject)
                <span class="badge badge-success">{{ $subject->name }}</span>
            @empty
                <p>Aucune matière demandée</p>
            @endforelse
            
            <h3 style="margin-top: 2rem;">Disponibilités</h3>
            @forelse($student->availabilities as $availability)
                <div style="background: #f7fafc; padding: 0.5rem; margin: 0.5rem 0; border-radius: 4px;">
                    <strong>{{ ucfirst($availability->day_of_week) }}</strong>: 
                    {{ \Carbon\Carbon::parse($availability->start_time)->format('H:i') }} - 
                    {{ \Carbon\Carbon::parse($availability->end_time)->format('H:i') }}
                </div>
            @empty
                <p>Aucune disponibilité renseignée</p>
            @endforelse
        </div>
    </div>
</div>
@endsection 