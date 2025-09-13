<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchoolLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_level'
    ];

    /**
     * Les tuteurs qui enseignent ce niveau
     */
    public function tutors(): BelongsToMany
    {
        return $this->belongsToMany(
            Tutor::class, 
            'tutor_school_levels',
            'school_level',
            'tutor_id'
        );
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
