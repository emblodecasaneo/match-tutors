@extends('layouts.app')

@section('title', 'Messages')
@section('subtitle', 'Communication tuteurs-étudiants')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Messages</h4>
                <small class="text-muted">Communication entre tuteurs et étudiants</small>
            </div>
            <button class="btn btn-primary">
                <i class="bi bi-plus"></i> Nouveau message
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-chat-dots fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Système de messages en développement</h5>
                <p class="text-muted">Cette fonctionnalité sera bientôt disponible</p>
            </div>
        </div>
    </div>
</div>
@endsection 