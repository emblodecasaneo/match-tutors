@extends('layouts.app')

@section('title', 'Paramètres')
@section('subtitle', 'Configuration du système')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Paramètres</h4>
                <small class="text-muted">Configuration du système de matchmaking</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-gear me-2"></i>Configuration du Matchmaking
                </h6>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Score minimum pour un match</label>
                        <input type="number" class="form-control" value="50" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Priorité des matières</label>
                        <select class="form-select">
                            <option>Égale pour toutes</option>
                            <option>Mathématiques prioritaire</option>
                            <option>Français prioritaire</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-download me-2"></i>Export/Import
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('settings.export') }}" class="btn btn-success">
                        <i class="bi bi-download me-2"></i>Exporter les données
                    </a>
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="bi bi-upload me-2"></i>Importer des données
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 