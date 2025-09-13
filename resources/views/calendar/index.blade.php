@extends('layouts.app')

@section('title', 'Calendrier des Disponibilités')
@section('subtitle', 'Planification et gestion des créneaux')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Calendrier des Disponibilités</h4>
                <small class="text-muted">Gestion des créneaux tuteurs et étudiants</small>
            </div>
            <a href="{{ route('calendar.availability') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-eye me-1"></i>Vue détaillée
            </a>
        </div>
    </div>
</div>

<!-- Statistiques modernes -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-center text-white p-3">
                <i class="bi bi-person-check fs-4 mb-2"></i>
                <div class="fs-5 fw-bold">{{ $stats['total_tutor_slots'] }}</div>
                <div class="small opacity-75">Créneaux tuteurs</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="card-body text-center text-white p-3">
                <i class="bi bi-people fs-4 mb-2"></i>
                <div class="fs-5 fw-bold">{{ $stats['total_student_slots'] }}</div>
                <div class="small opacity-75">Créneaux étudiants</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <div class="card-body text-center text-white p-3">
                <i class="bi bi-calendar-day fs-4 mb-2"></i>
                <div class="fs-5 fw-bold">{{ ucfirst($stats['most_popular_day']->day_of_week ?? 'N/A') }}</div>
                <div class="small opacity-75">Jour populaire</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
            <div class="card-body text-center text-white p-3">
                <i class="bi bi-clock fs-4 mb-2"></i>
                <div class="fs-5 fw-bold">{{ $stats['busiest_hour']->hour ?? 'N/A' }}h</div>
                <div class="small opacity-75">Heure chargée</div>
            </div>
        </div>
    </div>
</div>

<!-- Calendrier moderne par jour -->
<div class="row">
    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-gradient text-white border-0" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <h6 class="mb-0 text-capitalize">
                    <i class="bi bi-calendar-day me-2"></i>{{ ucfirst($day) }}
                </h6>
            </div>
            <div class="card-body p-3">
                <!-- Tuteurs disponibles -->
                @if($tutorAvailabilities->has($day))
                    <div class="mb-3">
                        <h6 class="text-primary mb-2 d-flex align-items-center">
                            <i class="bi bi-person-check me-1"></i>Tuteurs
                        </h6>
                        @foreach($tutorAvailabilities[$day] as $availability)
                            @if($availability->available && $availability->available->name)
                                <div class="availability-item mb-2 p-2 rounded" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);">
                                    <div class="fw-bold text-dark">{{ $availability->available->name }}</div>
                                    <div class="small text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $availability->start_time }} - {{ $availability->end_time }}
                                    </div>
                                </div>
                            @else
                                <div class="availability-item mb-2 p-2 rounded bg-light">
                                    <div class="text-muted"><em>Tuteur supprimé</em></div>
                                    <div class="small text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $availability->start_time }} - {{ $availability->end_time }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                <!-- Étudiants disponibles -->
                @if($studentAvailabilities->has($day))
                    <div>
                        <h6 class="text-success mb-2 d-flex align-items-center">
                            <i class="bi bi-people me-1"></i>Étudiants
                        </h6>
                        @foreach($studentAvailabilities[$day] as $availability)
                            @if($availability->available && $availability->available->name)
                                <div class="availability-item mb-2 p-2 rounded" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                                    <div class="fw-bold text-dark">{{ $availability->available->name }}</div>
                                    <div class="small text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $availability->start_time }} - {{ $availability->end_time }}
                                    </div>
                                </div>
                            @else
                                <div class="availability-item mb-2 p-2 rounded bg-light">
                                    <div class="text-muted"><em>Étudiant supprimé</em></div>
                                    <div class="small text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $availability->start_time }} - {{ $availability->end_time }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if(!$tutorAvailabilities->has($day) && !$studentAvailabilities->has($day))
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x text-muted" style="font-size: 2rem;"></i>
                        <div class="text-muted mt-2">Aucune disponibilité</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
.availability-item {
    border-left: 3px solid #e5e7eb;
    transition: all 0.2s ease;
    border-radius: 8px;
}

.availability-item:hover {
    transform: translateX(2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card {
    border-radius: 12px;
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}
</style>
@endsection 