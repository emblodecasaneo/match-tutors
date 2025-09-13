<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class MatchmakingService
{
    /**
     * Trouver les matchs pour tous les étudiants
     */
    public function findMatchesForAllStudents(): array
    {
        $students = Student::with(['subjects', 'availabilities'])->get();
        $results = [];

        foreach ($students as $student) {
            $matches = $this->findMatchesForStudent($student);
            $results[] = [
                'student' => $student,
                'matches' => $matches,
                'best_match' => !empty($matches) ? $matches[0] : null,
                'total_matches' => count($matches),
                'perfect_matches' => collect($matches)->where('compatibility_score', 100)->count()
            ];
        }

        return $results;
    }

    /**
     * Trouver les matchs pour un étudiant spécifique
     */
    public function findMatchesForStudent(Student $student): array
    {
        $tutors = Tutor::with(['subjects', 'availabilities'])->get();
        $matches = [];

        foreach ($tutors as $tutor) {
            $score = $this->calculateCompatibilityScore($student, $tutor);
            if ($score > 0) {
                $matches[] = [
                    'tutor' => $tutor,
                    'compatibility_score' => $score,
                    'common_availabilities' => $this->getCommonAvailabilities($student, $tutor),
                    'matching_subjects' => $this->getMatchingSubjects($student, $tutor)
                ];
            }
        }

        // Trier par score de compatibilité décroissant
        usort($matches, function($a, $b) {
            return $b['compatibility_score'] <=> $a['compatibility_score'];
        });

        return $matches;
    }

    /**
     * Calculer le score de compatibilité (0-100)
     */
    private function calculateCompatibilityScore(Student $student, Tutor $tutor): int
    {
        $score = 0;

        // 1. Vérifier les matières communes (40 points max)
        $commonSubjects = $this->getMatchingSubjects($student, $tutor);
        if ($commonSubjects->count() > 0) {
            $score += 40;
        }

        // 2. Vérifier le niveau scolaire (30 points)
        if ($this->tutorSupportsLevel($tutor, $student->school_level)) {
            $score += 30;
        }

        // 3. Vérifier les disponibilités communes (30 points)
        $commonAvailabilities = $this->getCommonAvailabilities($student, $tutor);
        if ($commonAvailabilities->count() > 0) {
            $score += 30;
        }

        return $score;
    }

    /**
     * Obtenir les matières communes
     */
    private function getMatchingSubjects(Student $student, Tutor $tutor): Collection
    {
        $studentSubjectIds = $student->subjects->pluck('id');
        $tutorSubjectIds = $tutor->subjects->pluck('id');
        
        $commonSubjectIds = $studentSubjectIds->intersect($tutorSubjectIds);
        
        return $tutor->subjects->whereIn('id', $commonSubjectIds);
    }

    /**
     * Vérifier si le tuteur supporte le niveau scolaire
     */
    private function tutorSupportsLevel(Tutor $tutor, string $level): bool
    {
        return DB::table('tutor_school_levels')
            ->where('tutor_id', $tutor->id)
            ->where('school_level', $level)
            ->exists();
    }

    /**
     * Obtenir les disponibilités communes
     */
    private function getCommonAvailabilities(Student $student, Tutor $tutor): Collection
    {
        $studentAvailabilities = $student->availabilities;
        $tutorAvailabilities = $tutor->availabilities;
        
        $commonAvailabilities = collect();
        
        foreach ($studentAvailabilities as $studentAvail) {
            foreach ($tutorAvailabilities as $tutorAvail) {
                if ($studentAvail->day_of_week === $tutorAvail->day_of_week) {
                    // Vérifier si les créneaux se chevauchent
                    if ($this->timeOverlaps($studentAvail, $tutorAvail)) {
                        $commonAvailabilities->push([
                            'day' => $studentAvail->day_of_week,
                            'start_time' => max($studentAvail->start_time, $tutorAvail->start_time),
                            'end_time' => min($studentAvail->end_time, $tutorAvail->end_time),
                            'duration' => $this->calculateDuration(
                                max($studentAvail->start_time, $tutorAvail->start_time),
                                min($studentAvail->end_time, $tutorAvail->end_time)
                            )
                        ]);
                    }
                }
            }
        }
        
        return $commonAvailabilities;
    }

    /**
     * Vérifier si deux créneaux se chevauchent
     */
    private function timeOverlaps($avail1, $avail2): bool
    {
        $start1 = $avail1->start_time;
        $end1 = $avail1->end_time;
        $start2 = $avail2->start_time;
        $end2 = $avail2->end_time;
        
        return $start1 < $end2 && $start2 < $end1;
    }

    /**
     * Calculer la durée en heures
     */
    private function calculateDuration($start, $end): float
    {
        // Convertir en string si ce sont des objets Time
        $startStr = is_object($start) ? $start->format('H:i:s') : $start;
        $endStr = is_object($end) ? $end->format('H:i:s') : $end;
        
        // Extraire les heures et minutes
        list($startHour, $startMin) = explode(':', $startStr);
        list($endHour, $endMin) = explode(':', $endStr);
        
        $startMinutes = ($startHour * 60) + $startMin;
        $endMinutes = ($endHour * 60) + $endMin;
        
        return ($endMinutes - $startMinutes) / 60; // Convertir en heures
    }

    /**
     * Obtenir les raisons du match
     */
    private function getMatchReasons(Student $student, Tutor $tutor): array
    {
        $reasons = [];

        // Matières communes
        $studentSubjects = $student->subjects->pluck('name')->toArray();
        $tutorSubjects = $tutor->subjects->pluck('name')->toArray();
        $commonSubjects = array_intersect($studentSubjects, $tutorSubjects);
        
        if (count($commonSubjects) > 0) {
            $reasons[] = 'Matières communes: ' . implode(', ', $commonSubjects);
        }

        // Niveau scolaire
        if ($this->tutorSupportsLevel($tutor, $student->school_level)) {
            $reasons[] = 'Niveau scolaire compatible: ' . ucfirst($student->school_level);
        }

        // Disponibilités communes
        $commonAvailabilities = $this->getCommonAvailabilities($student, $tutor);
        if ($commonAvailabilities->count() > 0) {
            $reasons[] = 'Disponibilités communes: ' . $commonAvailabilities->count() . ' créneau(x)';
        }

        return $reasons;
    }
} 