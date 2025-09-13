@extends('layouts.app')

@section('title', 'Matchmaking - Studena')

@section('content')
<div class="stats">
    <div class="stat-card">
        <h3>{{ $stats['total_students'] }}</h3>
        <p>👨‍🎓 Étudiants</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['total_tutors'] }}</h3>
        <p>👨‍🏫 Tuteurs</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['total_matches'] }}</h3>
        <p>🎯 Matchs totaux</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['perfect_matches'] }}</h3>
        <p>⭐ Matchs parfaits</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['match_rate'] }}%</h3>
        <p>📊 Taux de match</p>
    </div>
</div>

<div class="card">
    <h2>🚀 Actions Rapides</h2>
    <button class="button" onclick="runExampleMatchmaking()">🚀 Exécuter l'exemple du document</button>
    <button class="button secondary" onclick="findAllMatches()">🔍 Trouver tous les matchs</button>
    <button class="button" onclick="showStats()">📊 Statistiques détaillées</button>
</div>

<div id="results"></div>

<div class="grid">
    <div>
        <h2>👨‍🎓 Étudiants</h2>
        @forelse($students as $student)
            <div class="card">
                <h3>{{ $student->name }}</h3>
                <p><strong>📧 Email:</strong> {{ $student->email }}</p>
                <p><strong>📱 Téléphone:</strong> {{ $student->phone ?? 'Non renseigné' }}</p>
                <p><strong>🎓 Niveau:</strong> 
                    <span class="badge badge-primary">{{ ucfirst($student->school_level) }}</span>
                </p>
                <p><strong>📚 Matières:</strong> 
                    @forelse($student->subjects as $subject)
                        <span class="badge badge-success">{{ $subject->name }}</span>
                    @empty
                        <span class="badge badge-warning">Aucune matière</span>
                    @endforelse
                </p>
                <p><strong>⏰ Disponibilités:</strong> {{ $student->availabilities->count() }} créneaux</p>
                @if($student->notes)
                    <p><strong>📝 Notes:</strong> {{ $student->notes }}</p>
                @endif
                <button class="button" onclick="findMatchesForStudent({{ $student->id }})">
                    🎯 Trouver des matchs
                </button>
            </div>
        @empty
            <div class="card">
                <p>❌ Aucun étudiant trouvé</p>
                <a href="{{ route('students.create') }}" class="button">➕ Ajouter un étudiant</a>
            </div>
        @endforelse
    </div>

    <div>
        <h2>👨‍🏫 Tuteurs</h2>
        @forelse($tutors as $tutor)
            <div class="card">
                <h3>{{ $tutor->name }}</h3>
                <p><strong>📧 Email:</strong> {{ $tutor->email }}</p>
                <p><strong>📱 Téléphone:</strong> {{ $tutor->phone ?? 'Non renseigné' }}</p>
                <p><strong>⭐ Expérience:</strong> {{ $tutor->experience_years }} ans</p>
                <p><strong>💰 Tarif:</strong> {{ $tutor->hourly_rate }}€/h</p>
                <p><strong>📚 Matières:</strong> 
                    @forelse($tutor->subjects as $subject)
                        <span class="badge badge-success">{{ $subject->name }}</span>
                    @empty
                        <span class="badge badge-warning">Aucune matière</span>
                    @endforelse
                </p>
                <p><strong>🎓 Niveaux:</strong> 
                    @forelse($tutor->schoolLevels as $level)
                        <span class="badge badge-primary">{{ ucfirst($level->school_level) }}</span>
                    @empty
                        <span class="badge badge-warning">Aucun niveau</span>
                    @endforelse
                </p>
                <p><strong>⏰ Disponibilités:</strong> {{ $tutor->availabilities->count() }} créneaux</p>
                @if($tutor->bio)
                    <p><strong>📝 Bio:</strong> {{ $tutor->bio }}</p>
                @endif
            </div>
        @empty
            <div class="card">
                <p>❌ Aucun tuteur trouvé</p>
                <a href="{{ route('tutors.create') }}" class="button">➕ Ajouter un tuteur</a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function runExampleMatchmaking() {
        showLoading();
        try {
            const data = await fetchData('/matchmaking/example');
            displayResults(data);
        } catch (error) {
            console.error('Erreur:', error);
            document.getElementById('results').innerHTML = `
                <div class="alert alert-error">
                    ❌ Erreur lors de l'exécution du matchmaking: ${error.message}
                </div>
            `;
        }
    }

    async function findAllMatches() {
        showLoading();
        try {
            const data = await fetchData('/matchmaking/all');
            displayResults(data);
        } catch (error) {
            console.error('Erreur:', error);
            document.getElementById('results').innerHTML = `
                <div class="alert alert-error">
                    ❌ Erreur lors de la recherche de matchs: ${error.message}
                </div>
            `;
        }
    }

    async function findMatchesForStudent(studentId) {
        showLoading();
        try {
            const data = await fetchData(`/matchmaking/student/${studentId}`);
            displayResults(data);
        } catch (error) {
            console.error('Erreur:', error);
            document.getElementById('results').innerHTML = `
                <div class="alert alert-error">
                    ❌ Erreur lors de la recherche de matchs pour cet étudiant: ${error.message}
                </div>
            `;
        }
    }

    async function showStats() {
        showLoading();
        try {
            const data = await fetchData('/matchmaking/stats');
            document.getElementById('results').innerHTML = `
                <div class="card">
                    <h2>📊 Statistiques Détaillées</h2>
                    <div class="stats">
                        <div class="stat-card">
                            <h3>${data.total_students}</h3>
                            <p>👨‍🎓 Total étudiants</p>
                        </div>
                        <div class="stat-card">
                            <h3>${data.total_tutors}</h3>
                            <p>👨‍🏫 Total tuteurs</p>
                        </div>
                        <div class="stat-card">
                            <h3>${data.total_matches}</h3>
                            <p>🎯 Total matchs</p>
                        </div>
                        <div class="stat-card">
                            <h3>${data.perfect_matches}</h3>
                            <p>⭐ Matchs parfaits</p>
                        </div>
                        <div class="stat-card">
                            <h3>${data.match_rate}%</h3>
                            <p>📊 Taux de match</p>
                        </div>
                    </div>
                </div>
            `;
        } catch (error) {
            console.error('Erreur:', error);
            document.getElementById('results').innerHTML = `
                <div class="alert alert-error">
                    ❌ Erreur lors du chargement des statistiques: ${error.message}
                </div>
            `;
        }
    }
</script>
@endsection 