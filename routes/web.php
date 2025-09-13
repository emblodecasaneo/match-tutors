<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MatchmakingController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SettingsController;

// Dashboard
Route::get('/', [MatchmakingController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [MatchmakingController::class, 'index'])->name('dashboard');

// Ressources principales
Route::resource('tutors', TutorController::class);
Route::resource('students', StudentController::class);
Route::resource('subjects', SubjectController::class);

// Matchmaking
Route::get('/matchmaking/example', [MatchmakingController::class, 'runExampleMatchmaking'])->name('matchmaking.example');

// Rapports
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/statistics', [ReportController::class, 'statistics'])->name('reports.statistics');
Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

// Calendrier
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::get('/calendar/availability', [CalendarController::class, 'availability'])->name('calendar.availability');

// Messages
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

// Paramètres
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
Route::get('/settings/export', [SettingsController::class, 'export'])->name('settings.export');
Route::post('/settings/import', [SettingsController::class, 'import'])->name('settings.import');
