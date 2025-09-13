<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TutorSchoolLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'school_level'
    ];

    /**
     * Le tuteur qui a ce niveau scolaire
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Obtenir le nom du niveau en français
     */
    public function getDisplayNameAttribute(): string
    {
        $levels = [
            'college' => 'Collège',
            'lycee' => 'Lycée',
            'terminale' => 'Terminale',
            'university' => 'Université'
        ];

        return $levels[$this->school_level] ?? ucfirst($this->school_level);
    }
} 