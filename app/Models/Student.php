<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'school_level',
        'notes'
    ];

    protected $casts = [
        'school_level' => 'string'
    ];

    /**
     * Relation avec les matières (many-to-many)
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'student_subject');
    }

    /**
     * Relation avec les disponibilités (polymorphique)
     */
    public function availabilities(): MorphMany
    {
        return $this->morphMany(Availability::class, 'available');
    }

    /**
     * Obtenir les tuteurs compatibles
     */
    public function getCompatibleTutors()
    {
        $tutors = Tutor::with(['subjects', 'availabilities'])->get();
        
        $compatibleTutors = [];
        
        foreach ($tutors as $tutor) {
            $score = $tutor->calculateCompatibilityScore($this);
            if ($score > 0) {
                $compatibleTutors[] = [
                    'tutor' => $tutor,
                    'score' => $score
                ];
            }
        }
        
        // Trier par score décroissant
        usort($compatibleTutors, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        return $compatibleTutors;
    }
}
