<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'matchmaking_weights' => [
                'subjects' => 40,
                'school_level' => 30,
                'availability' => 30
            ],
            'min_match_score' => 50,
            'max_matches_per_student' => 5,
            'email_notifications' => true,
            'auto_matchmaking' => false
        ];

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'subjects_weight' => 'required|integer|min:0|max:100',
            'school_level_weight' => 'required|integer|min:0|max:100',
            'availability_weight' => 'required|integer|min:0|max:100',
            'min_match_score' => 'required|integer|min:0|max:100',
            'max_matches_per_student' => 'required|integer|min:1|max:20',
            'email_notifications' => 'boolean',
            'auto_matchmaking' => 'boolean'
        ]);

        // Sauvegarder les paramètres (dans un fichier config ou base de données)
        $settings = [
            'matchmaking_weights' => [
                'subjects' => $request->subjects_weight,
                'school_level' => $request->school_level_weight,
                'availability' => $request->availability_weight
            ],
            'min_match_score' => $request->min_match_score,
            'max_matches_per_student' => $request->max_matches_per_student,
            'email_notifications' => $request->has('email_notifications'),
            'auto_matchmaking' => $request->has('auto_matchmaking')
        ];

        // Ici vous pouvez sauvegarder dans un fichier JSON ou une table settings
        file_put_contents(storage_path('app/settings.json'), json_encode($settings));

        return redirect()->route('settings.index')->with('success', 'Paramètres mis à jour avec succès');
    }
} 