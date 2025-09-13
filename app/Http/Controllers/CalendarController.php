<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Models\Student;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function index()
    {
        // Récupérer toutes les disponibilités
        $tutorAvailabilities = Availability::where('available_type', Tutor::class)
            ->with('available')
            ->get()
            ->groupBy('day_of_week');

        $studentAvailabilities = Availability::where('available_type', Student::class)
            ->with('available')
            ->get()
            ->groupBy('day_of_week');

        // Statistiques du calendrier
        $stats = [
            'total_tutor_slots' => Availability::where('available_type', Tutor::class)->count(),
            'total_student_slots' => Availability::where('available_type', Student::class)->count(),
            'most_popular_day' => $this->getMostPopularDay(),
            'busiest_hour' => $this->getBusiestHour(),
        ];

        return view('calendar.index', compact('tutorAvailabilities', 'studentAvailabilities', 'stats'));
    }

    public function availability()
    {
        // Vue détaillée des disponibilités
        $availabilities = Availability::with(['available'])
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->groupBy('available_type');

        return view('calendar.availability', compact('availabilities'));
    }

    private function getMostPopularDay()
    {
        return Availability::select('day_of_week', DB::raw('count(*) as count'))
            ->groupBy('day_of_week')
            ->orderBy('count', 'desc')
            ->first();
    }

    private function getBusiestHour()
    {
        return Availability::select(DB::raw('HOUR(start_time) as hour'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('HOUR(start_time)'))
            ->orderBy('count', 'desc')
            ->first();
    }
}
