<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Models\Student;
use App\Models\Subject;
use App\Services\MatchmakingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    protected $matchmakingService;

    public function __construct(MatchmakingService $matchmakingService)
    {
        $this->matchmakingService = $matchmakingService;
    }

    public function index()
    {
        $stats = [
            'total_tutors' => Tutor::count(),
            'total_students' => Student::count(),
            'total_subjects' => Subject::count(),
            'total_matches' => $this->calculateTotalMatches(),
            'perfect_matches' => $this->calculatePerfectMatches(),
            'match_rate' => $this->calculateMatchRate(),
        ];

        return view('reports.index', compact('stats'));
    }

    public function statistics()
    {
        $subjectStats = Subject::withCount(['tutors', 'students'])->get();
        $levelStats = $this->getLevelStatistics();
        $availabilityStats = $this->getAvailabilityStatistics();

        return view('reports.statistics', compact('subjectStats', 'levelStats', 'availabilityStats'));
    }

    public function export()
    {
        // Logique d'export CSV/Excel
        return response()->download($this->generateExportFile());
    }

    private function calculateTotalMatches()
    {
        $results = $this->matchmakingService->findMatchesForAllStudents();
        return collect($results)->sum('total_matches');
    }

    private function calculatePerfectMatches()
    {
        $results = $this->matchmakingService->findMatchesForAllStudents();
        return collect($results)->sum('perfect_matches');
    }

    private function calculateMatchRate()
    {
        $totalStudents = Student::count();
        if ($totalStudents === 0) return 0;
        
        $studentsWithMatches = Student::whereHas('subjects', function($query) {
            $query->whereHas('tutors');
        })->count();
        
        return round(($studentsWithMatches / $totalStudents) * 100, 2);
    }

    private function getLevelStatistics()
    {
        return [
            'tutors_by_level' => DB::table('tutor_school_levels')
                ->select('school_level', DB::raw('count(*) as count'))
                ->groupBy('school_level')
                ->get(),
            'students_by_level' => Student::select('school_level', DB::raw('count(*) as count'))
                ->groupBy('school_level')
                ->get()
        ];
    }

    private function getAvailabilityStatistics()
    {
        return DB::table('availabilities')
            ->select('day_of_week', DB::raw('count(*) as count'))
            ->groupBy('day_of_week')
            ->orderBy('count', 'desc')
            ->get();
    }

    private function generateExportFile()
    {
        // Logique pour générer un fichier d'export
        // Retourner le chemin du fichier généré
    }
} 