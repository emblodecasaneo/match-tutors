@extends('layouts.app')

@section('title', 'Résultats du Matchmaking')
@section('subtitle', 'Analyse des compatibilités tuteurs-étudiants')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Résultats du Matchmaking</h4>
                <small class="text-muted">Analyse automatique des compatibilités</small>
            </div>
            <a href="{{ route('matchmaking.example') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-arrow-clockwise me-1"></i>Relancer
            </a>
        </div>
    </div>
</div>

<!-- Résultats par étudiant - SEULEMENT LES MATCHS PARFAITS -->
<div class="row">
    @foreach($results as $result)
        @php
            $perfectMatches = array_filter($result['matches'], function($match) {
                return $match['compatibility_score'] == 100;
            });
        @endphp
        
        @if(count($perfectMatches) > 0)
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <!-- Header étudiant avec dégradé -->
                <div class="card-header border-0 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                    <div class="position-relative">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">
                                    <i class="bi bi-person-circle me-2"></i>{{ $result['student']->name }}
                                </h6>
                                <small class="opacity-75">{{ ucfirst($result['student']->school_level) }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success text-white">{{ count($perfectMatches) }} match{{ count($perfectMatches) > 1 ? 's' : '' }} parfait{{ count($perfectMatches) > 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-3">
                    <div class="row">
                        @foreach($perfectMatches as $match)
                            <div class="col-12 mb-3">
                                <div class="card border-success shadow-sm h-100" style="background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);">
                                    <div class="card-body p-3">
                                        <!-- Header tuteur -->
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold text-dark">{{ $match['tutor']->name }}</h6>
                                                <small class="text-muted">{{ $match['tutor']->email }}</small>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span class="badge bg-success fs-6">
                                                    100%
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Matières -->
                                        @if($match['matching_subjects']->count() > 0)
                                            <div class="mb-2">
                                                <small class="text-muted d-block mb-1">Matières:</small>
                                                @foreach($match['matching_subjects'] as $subject)
                                                    <span class="badge bg-info me-1 mb-1">{{ $subject->name }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <!-- Disponibilités -->
                                        @if($match['common_availabilities']->count() > 0)
                                            <div>
                                                <small class="text-muted d-block mb-1">Disponibilités:</small>
                                                @foreach($match['common_availabilities'] as $availability)
                                                    <div class="small mb-1">
                                                        <span class="badge bg-secondary me-1">{{ ucfirst($availability['day']) }}</span>
                                                        <span class="text-dark">{{ $availability['start_time'] }} - {{ $availability['end_time'] }}</span>
                                                        <span class="text-muted">({{ number_format($availability['duration'], 1) }}h)</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>

<!-- Message de succès si tous les étudiants ont des matchs parfaits -->
@if(count($results) > 0 && array_sum(array_column($results, 'perfect_matches')) > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-success border-0 shadow-sm" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                <div>
                    <h6 class="mb-1 text-success fw-bold">Matchmaking parfait réussi !</h6>
                    <small class="text-success">Tous les étudiants ont trouvé des tuteurs avec une compatibilité parfaite.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection 