<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Tutor;
use App\Models\Subject;
use App\Services\MatchmakingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MatchmakingController extends Controller
{
    protected $matchmakingService;

    public function __construct(MatchmakingService $matchmakingService)
    {
        $this->matchmakingService = $matchmakingService;
    }

    public function index()
    {
        // Récupérer les données
        $students = Student::with(['subjects', 'availabilities'])->get();
        $tutors = Tutor::with(['subjects', 'availabilities'])->get();
        $subjects = Subject::all();

        // Calculer les statistiques
        $stats = [
            'tutors' => $tutors->count(),
            'students' => $students->count(),
            'subjects' => $subjects->count(),
            'total_matches' => $this->calculateTotalMatches(),
            'perfect_matches' => $this->calculatePerfectMatches(),
            'match_rate' => $this->calculateMatchRate(),
        ];

        return view('dashboard', compact('stats', 'students', 'tutors', 'subjects'));
    }

    public function runExampleMatchmaking()
    {
        $students = Student::with(['subjects', 'availabilities'])->get();
        $results = [];

        foreach ($students as $student) {
            $matches = $this->matchmakingService->findMatchesForStudent($student);
            $results[] = [
                'student' => $student,
                'matches' => $matches,
                'total_matches' => count($matches),
                'perfect_matches' => collect($matches)->where('compatibility_score', 100)->count()
            ];
        }

        return view('matchmaking.results', compact('results'));
    }

    private function calculateTotalMatches()
    {
        $students = Student::with(['subjects', 'availabilities'])->get();
        $totalMatches = 0;

        foreach ($students as $student) {
            $matches = $this->matchmakingService->findMatchesForStudent($student);
            $totalMatches += count($matches);
        }

        return $totalMatches;
    }

    private function calculatePerfectMatches()
    {
        $students = Student::with(['subjects', 'availabilities'])->get();
        $perfectMatches = 0;

        foreach ($students as $student) {
            $matches = $this->matchmakingService->findMatchesForStudent($student);
            $perfectMatches += collect($matches)->where('compatibility_score', 100)->count();
        }

        return $perfectMatches;
    }

    private function calculateMatchRate()
    {
        $totalStudents = Student::count();
        if ($totalStudents === 0) return 0;
        
        $studentsWithMatches = 0;
        $students = Student::with(['subjects', 'availabilities'])->get();
        
        foreach ($students as $student) {
            $matches = $this->matchmakingService->findMatchesForStudent($student);
            if (count($matches) > 0) {
                $studentsWithMatches++;
            }
        }
        
        return round(($studentsWithMatches / $totalStudents) * 100, 2);
    }

    private function createExampleData()
    {
        // Créer les matières
        $mathematiques = Subject::firstOrCreate(['name' => 'Mathématiques']);
        $physique = Subject::firstOrCreate(['name' => 'Physique']);
        $francais = Subject::firstOrCreate(['name' => 'Français']);

        // Créer les tuteurs
        $ahmed = Tutor::firstOrCreate([
            'email' => 'ahmed@example.com'
        ], [
            'name' => 'Ahmed',
            'phone' => '0123456789',
            'experience_years' => 5,
            'hourly_rate' => 25.00,
            'bio' => 'Professeur de mathématiques expérimenté'
        ]);

        $sarah = Tutor::firstOrCreate([
            'email' => 'sarah@example.com'
        ], [
            'name' => 'Sarah',
            'phone' => '0123456788',
            'experience_years' => 3,
            'hourly_rate' => 20.00,
            'bio' => 'Spécialiste en physique'
        ]);

        $karim = Tutor::firstOrCreate([
            'email' => 'karim@example.com'
        ], [
            'name' => 'Karim',
            'phone' => '0123456787',
            'experience_years' => 4,
            'hourly_rate' => 22.00,
            'bio' => 'Professeur de français'
        ]);

        // Attacher les matières aux tuteurs
        $ahmed->subjects()->syncWithoutDetaching([$mathematiques->id]);
        $sarah->subjects()->syncWithoutDetaching([$physique->id]);
        $karim->subjects()->syncWithoutDetaching([$francais->id]);

        // Attacher les niveaux scolaires aux tuteurs directement dans la table pivot
        DB::table('tutor_school_levels')->insertOrIgnore([
            ['tutor_id' => $ahmed->id, 'school_level' => 'lycee', 'created_at' => now(), 'updated_at' => now()],
            ['tutor_id' => $sarah->id, 'school_level' => 'college', 'created_at' => now(), 'updated_at' => now()],
            ['tutor_id' => $sarah->id, 'school_level' => 'lycee', 'created_at' => now(), 'updated_at' => now()],
            ['tutor_id' => $karim->id, 'school_level' => 'terminale', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Créer les disponibilités pour Ahmed
        $ahmed->availabilities()->firstOrCreate([
            'day_of_week' => 'monday',
            'start_time' => '18:00',
            'end_time' => '20:00'
        ]);
        $ahmed->availabilities()->firstOrCreate([
            'day_of_week' => 'wednesday',
            'start_time' => '16:00',
            'end_time' => '20:00'
        ]);
        $ahmed->availabilities()->firstOrCreate([
            'day_of_week' => 'saturday',
            'start_time' => '10:00',
            'end_time' => '19:00'
        ]);

        // Créer les disponibilités pour Sarah
        $sarah->availabilities()->firstOrCreate([
            'day_of_week' => 'wednesday',
            'start_time' => '14:00',
            'end_time' => '16:00'
        ]);
        $sarah->availabilities()->firstOrCreate([
            'day_of_week' => 'saturday',
            'start_time' => '10:00',
            'end_time' => '22:00'
        ]);

        // Créer les disponibilités pour Karim
        $karim->availabilities()->firstOrCreate([
            'day_of_week' => 'monday',
            'start_time' => '18:00',
            'end_time' => '20:00'
        ]);

        // Créer les étudiants
        $ali = Student::firstOrCreate([
            'email' => 'ali@example.com'
        ], [
            'name' => 'Ali',
            'phone' => '0123456786',
            'school_level' => 'lycee',
            'notes' => 'Élève motivé'
        ]);

        $yasmine = Student::firstOrCreate([
            'email' => 'yasmine@example.com'
        ], [
            'name' => 'Yasmine',
            'phone' => '0123456785',
            'school_level' => 'college',
            'notes' => 'Élève sérieuse'
        ]);

        // Attacher les matières aux étudiants
        $ali->subjects()->syncWithoutDetaching([$mathematiques->id]);
        $yasmine->subjects()->syncWithoutDetaching([$physique->id]);

        // Créer les disponibilités pour Ali
        $ali->availabilities()->firstOrCreate([
            'day_of_week' => 'monday',
            'start_time' => '18:00',
            'end_time' => '20:00'
        ]);

        // Créer les disponibilités pour Yasmine
        $yasmine->availabilities()->firstOrCreate([
            'day_of_week' => 'wednesday',
            'start_time' => '14:00',
            'end_time' => '16:00'
        ]);
    }
}
