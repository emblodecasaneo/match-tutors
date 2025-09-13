<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    public function index()
    {
        $tutors = Tutor::with('subjects')->get();
        return view('tutors.index', compact('tutors'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('tutors.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tutors',
            'phone' => 'nullable|string',
            'experience_years' => 'required|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
            'school_levels' => 'required|array',
            'school_levels.*' => 'in:college,lycee,terminale,university'
        ]);

        $tutor = Tutor::create($request->only([
            'name', 'email', 'phone', 'experience_years', 'hourly_rate', 'bio'
        ]));

        $tutor->subjects()->sync($request->subjects);

        // Insérer les niveaux scolaires
        $schoolLevels = [];
        foreach ($request->school_levels as $level) {
            $schoolLevels[] = [
                'tutor_id' => $tutor->id,
                'school_level' => $level,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        DB::table('tutor_school_levels')->insert($schoolLevels);

        return redirect()->route('tutors.index')->with('success', 'Tuteur créé avec succès');
    }

    public function show(Tutor $tutor)
    {
        $tutor->load('subjects');
        return view('tutors.show', compact('tutor'));
    }

    public function edit(Tutor $tutor)
    {
        $subjects = Subject::all();
        $tutor->load('subjects');
        return view('tutors.edit', compact('tutor', 'subjects'));
    }

    public function update(Request $request, Tutor $tutor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tutors,email,' . $tutor->id,
            'phone' => 'nullable|string',
            'experience_years' => 'required|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
            'school_levels' => 'required|array',
            'school_levels.*' => 'in:college,lycee,terminale,university'
        ]);

        $tutor->update($request->only([
            'name', 'email', 'phone', 'experience_years', 'hourly_rate', 'bio'
        ]));

        $tutor->subjects()->sync($request->subjects);

        // Mettre à jour les niveaux scolaires
        DB::table('tutor_school_levels')->where('tutor_id', $tutor->id)->delete();
        $schoolLevels = [];
        foreach ($request->school_levels as $level) {
            $schoolLevels[] = [
                'tutor_id' => $tutor->id,
                'school_level' => $level,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        DB::table('tutor_school_levels')->insert($schoolLevels);

        return redirect()->route('tutors.index')->with('success', 'Tuteur mis à jour avec succès');
    }

    public function destroy(Tutor $tutor)
    {
        $tutor->delete();
        return redirect()->route('tutors.index')->with('success', 'Tuteur supprimé avec succès');
    }
}
