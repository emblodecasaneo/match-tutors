<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

class Tutor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'experience_years',
        'hourly_rate',
        'bio'
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'experience_years' => 'integer'
    ];

    /**
     * Relation avec les matières (many-to-many)
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'tutor_subject');
    }

    /**
     * Relation avec les disponibilités (polymorphique)
     */
    public function availabilities(): MorphMany
    {
        return $this->morphMany(Availability::class, 'available');
    }

    /**
     * Vérifier si le tuteur enseigne une matière
     */
    public function teachesSubject($subjectId): bool
    {
        return $this->subjects()->where('subject_id', $subjectId)->exists();
    }

    /**
     * Vérifier si le tuteur enseigne un niveau scolaire
     */
    public function teachesLevel($level): bool
    {
        return DB::table('tutor_school_levels')
                  ->where('tutor_id', $this->id)
                  ->where('school_level', $level)
                  ->exists();
    }

    /**
     * Obtenir les niveaux scolaires enseignés
     */
    public function getSchoolLevelsAttribute()
    {
        return DB::table('tutor_school_levels')
                  ->where('tutor_id', $this->id)
                  ->pluck('school_level')
                  ->toArray();
    }

    /**
     * Calculer le score de compatibilité avec un étudiant
     */
    public function calculateCompatibilityScore(Student $student): int
    {
        $score = 0;

        // Vérifier les matières communes (40 points)
        $commonSubjects = $this->subjects()->whereIn('subject_id', $student->subjects()->pluck('subject_id'))->count();
        $score += min($commonSubjects * 20, 40);

        // Vérifier le niveau scolaire (30 points)
        if ($this->teachesLevel($student->school_level)) {
            $score += 30;
        }

        // Vérifier les disponibilités communes (30 points)
        $commonAvailabilities = $this->getCommonAvailabilities($student);
        if ($commonAvailabilities > 0) {
            $score += min($commonAvailabilities * 10, 30);
        }

        return $score;
    }

    /**
     * Obtenir les disponibilités communes avec un étudiant
     */
    private function getCommonAvailabilities(Student $student): int
    {
        $tutorAvailabilities = $this->availabilities()->get();
        $studentAvailabilities = $student->availabilities()->get();

        $commonCount = 0;

        foreach ($tutorAvailabilities as $tutorAvail) {
            foreach ($studentAvailabilities as $studentAvail) {
                if ($tutorAvail->day_of_week === $studentAvail->day_of_week &&
                    $tutorAvail->start_time <= $studentAvail->end_time &&
                    $tutorAvail->end_time >= $studentAvail->start_time) {
                    $commonCount++;
                }
            }
        }

        return $commonCount;
    }
}
