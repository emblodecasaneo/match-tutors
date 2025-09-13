<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Les tuteurs qui enseignent cette matière
     */
    public function tutors(): BelongsToMany
    {
        return $this->belongsToMany(Tutor::class, 'tutor_subject');
    }

    /**
     * Les étudiants qui demandent cette matière
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_subject')
                    ->withPivot('priority')
                    ->withTimestamps();
    }
}
