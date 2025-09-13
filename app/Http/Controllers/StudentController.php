<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('subjects')->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('students.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'phone' => 'nullable|string',
            'school_level' => 'required|in:college,lycee,terminale,university',
            'notes' => 'nullable|string',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        $student = Student::create($request->only([
            'name', 'email', 'phone', 'school_level', 'notes'
        ]));

        $student->subjects()->sync($request->subjects);

        return redirect()->route('students.index')->with('success', 'Étudiant créé avec succès');
    }

    public function show(Student $student)
    {
        $student->load('subjects');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $subjects = Subject::all();
        $student->load('subjects');
        return view('students.edit', compact('student', 'subjects'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string',
            'school_level' => 'required|in:college,lycee,terminale,university',
            'notes' => 'nullable|string',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        $student->update($request->only([
            'name', 'email', 'phone', 'school_level', 'notes'
        ]));

        $student->subjects()->sync($request->subjects);

        return redirect()->route('students.index')->with('success', 'Étudiant mis à jour avec succès');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Étudiant supprimé avec succès');
    }
}
