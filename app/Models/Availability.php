<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'available_type',
        'available_id',
        'day_of_week',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i'
    ];

    /**
     * Relation polymorphe avec les tuteurs et étudiants
     */
    public function available(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Obtenir le nom du jour en français
     */
    public function getDayNameAttribute(): string
    {
        $days = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi',
            'sunday' => 'Dimanche'
        ];

        return $days[$this->day_of_week] ?? $this->day_of_week;
    }

    /**
     * Obtenir la durée du créneau en heures
     */
    public function getDurationAttribute(): float
    {
        $start = strtotime($this->start_time);
        $end = strtotime($this->end_time);
        return ($end - $start) / 3600;
    }
}
