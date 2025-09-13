@extends('layouts.app')

@section('title', 'Vue Détaillée des Disponibilités')
@section('subtitle', 'Analyse complète des créneaux')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Vue Détaillée des Disponibilités</h4>
                <small class="text-muted">Analyse complète des créneaux tuteurs et étudiants</small>
            </div>
            <a href="{{ route('calendar.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Retour au calendrier
            </a>
        </div>
    </div>
</div>

<!-- Disponibilités des Tuteurs -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient text-white border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h6 class="mb-0">
                    <i class="bi bi-person-check me-2"></i>Disponibilités des Tuteurs
                </h6>
            </div>
            <div class="card-body p-0">
                @if($availabilities->has('App\Models\Tutor'))
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Tuteur</th>
                                    <th class="border-0">Jour</th>
                                    <th class="border-0">Heure de début</th>
                                    <th class="border-0">Heure de fin</th>
                                    <th class="border-0">Durée</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availabilities['App\Models\Tutor'] as $availability)
                                <tr class="availability-row">
                                    <td class="border-0">
                                        @if($availability->available && $availability->available->name)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary text-white me-3">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                                <div>
                                                    <strong class="text-dark">{{ $availability->available->name }}</strong><br>
                                                    <small class="text-muted">{{ $availability->available->email }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-secondary text-white me-3">
                                                    <i class="bi bi-person-x"></i>
                                                </div>
                                                <div>
                                                    <strong class="text-muted">Tuteur supprimé</strong><br>
                                                    <small class="text-muted">ID: {{ $availability->available_id }}</small>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="border-0">
                                        <span class="badge bg-info text-capitalize">{{ $availability->day_of_week }}</span>
                                    </td>
                                    <td class="border-0">
                                        <span class="time-badge">{{ $availability->start_time }}</span>
                                    </td>
                                    <td class="border-0">
                                        <span class="time-badge">{{ $availability->end_time }}</span>
                                    </td>
                                    <td class="border-0">
                                        @php
                                            $start = new DateTime($availability->start_time);
                                            $end = new DateTime($availability->end_time);
                                            $duration = $start->diff($end);
                                        @endphp
                                        <span class="badge bg-success">{{ $duration->format('%Hh%I') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-person-x text-muted" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mt-3">Aucune disponibilité de tuteur</h5>
                        <p class="text-muted">Aucune disponibilité de tuteur enregistrée dans le système</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Disponibilités des Étudiants -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient text-white border-0" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <h6 class="mb-0">
                    <i class="bi bi-people me-2"></i>Disponibilités des Étudiants
                </h6>
            </div>
            <div class="card-body p-0">
                @if($availabilities->has('App\Models\Student'))
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Étudiant</th>
                                    <th class="border-0">Jour</th>
                                    <th class="border-0">Heure de début</th>
                                    <th class="border-0">Heure de fin</th>
                                    <th class="border-0">Durée</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availabilities['App\Models\Student'] as $availability)
                                <tr class="availability-row">
                                    <td class="border-0">
                                        @if($availability->available && $availability->available->name)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-success text-white me-3">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                                <div>
                                                    <strong class="text-dark">{{ $availability->available->name }}</strong><br>
                                                    <small class="text-muted">{{ $availability->available->email }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-secondary text-white me-3">
                                                    <i class="bi bi-person-x"></i>
                                                </div>
                                                <div>
                                                    <strong class="text-muted">Étudiant supprimé</strong><br>
                                                    <small class="text-muted">ID: {{ $availability->available_id }}</small>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="border-0">
                                        <span class="badge bg-info text-capitalize">{{ $availability->day_of_week }}</span>
                                    </td>
                                    <td class="border-0">
                                        <span class="time-badge">{{ $availability->start_time }}</span>
                                    </td>
                                    <td class="border-0">
                                        <span class="time-badge">{{ $availability->end_time }}</span>
                                    </td>
                                    <td class="border-0">
                                        @php
                                            $start = new DateTime($availability->start_time);
                                            $end = new DateTime($availability->end_time);
                                            $duration = $start->diff($end);
                                        @endphp
                                        <span class="badge bg-success">{{ $duration->format('%Hh%I') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mt-3">Aucune disponibilité d'étudiant</h5>
                        <p class="text-muted">Aucune disponibilité d'étudiant enregistrée dans le système</p>
                    </div>
                @endif
            </div>
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
    font-size: 1rem;
}

.time-badge {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    padding: 4px 8px;
    border-radius: 6px;
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
}

.availability-row {
    transition: all 0.2s ease;
}

.availability-row:hover {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    transform: translateX(2px);
}

.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    border-radius: 0 !important;
}

.table th {
    font-weight: 600;
    font-size: 0.9rem;
    color: #6b7280;
}

.table td {
    vertical-align: middle;
    padding: 1rem;
}
</style>
@endsection 