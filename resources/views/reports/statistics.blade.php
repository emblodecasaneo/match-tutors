@extends('layouts.app')

@section('title', 'Statistiques Détaillées')
@section('subtitle', 'Analyse approfondie des données')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Statistiques Détaillées</h4>
                <small class="text-muted">Analyse approfondie des données du système</small>
            </div>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
        </div>
    </div>
</div>

<!-- Statistiques par matière -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0">
                    <i class="bi bi-book me-2"></i>Statistiques par Matière
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Matière</th>
                                <th>Tuteurs</th>
                                <th>Étudiants</th>
                                <th>Demande</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjectStats as $subject)
                            <tr>
                                <td>
                                    <strong>{{ $subject->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $subject->tutors_count }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $subject->students_count }}</span>
                                </td>
                                <td>
                                    @php
                                        $demand = $subject->students_count > 0 ? round(($subject->tutors_count / $subject->students_count) * 100, 1) : 0;
                                    @endphp
                                    <span class="badge {{ $demand >= 100 ? 'bg-success' : ($demand >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $demand }}%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques par niveau -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0">
                    <i class="bi bi-mortarboard me-2"></i>Tuteurs par Niveau
                </h6>
            </div>
            <div class="card-body">
                @foreach($levelStats['tutors_by_level'] as $level)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-capitalize">{{ $level->school_level }}</span>
                    <span class="badge bg-primary">{{ $level->count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0">
                    <i class="bi bi-people me-2"></i>Étudiants par Niveau
                </h6>
            </div>
            <div class="card-body">
                @foreach($levelStats['students_by_level'] as $level)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-capitalize">{{ $level->school_level }}</span>
                    <span class="badge bg-success">{{ $level->count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Statistiques des disponibilités -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0">
                    <i class="bi bi-calendar-week me-2"></i>Disponibilités par Jour
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($availabilityStats as $day)
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="text-center p-3 rounded" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                            <div class="fw-bold text-capitalize">{{ $day->day_of_week }}</div>
                            <div class="fs-4 text-primary">{{ $day->count }}</div>
                            <div class="small text-muted">créneaux</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 