<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use App\Models\Tutor;
use App\Models\Student;

class ExampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider toutes les tables
        $this->truncateTables();

        // Créer les matières
        $mathematiques = Subject::create(['name' => 'Mathématiques']);
        $physique = Subject::create(['name' => 'Physique']);
        $francais = Subject::create(['name' => 'Français']);

        // Créer Ahmed (Mathématiques, Lycée, Lundi 18h-20h + Mercredi 16h-20h + Samedi 10h-19h)
        $ahmed = Tutor::create([
            'name' => 'Ahmed',
            'email' => 'ahmed@example.com',
            'phone' => '0123456789',
            'experience_years' => 5,
            'hourly_rate' => 25.00,
            'bio' => 'Professeur de mathématiques expérimenté'
        ]);

        // Attacher les matières et niveaux à Ahmed
        $ahmed->subjects()->attach($mathematiques->id);
        DB::table('tutor_school_levels')->insert([
            'tutor_id' => $ahmed->id,
            'school_level' => 'lycee',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Créer les disponibilités d'Ahmed
        $ahmed->availabilities()->create([
            'day_of_week' => 'monday',
            'start_time' => '18:00:00',
            'end_time' => '20:00:00'
        ]);
        $ahmed->availabilities()->create([
            'day_of_week' => 'wednesday',
            'start_time' => '16:00:00',
            'end_time' => '20:00:00'
        ]);
        $ahmed->availabilities()->create([
            'day_of_week' => 'saturday',
            'start_time' => '10:00:00',
            'end_time' => '19:00:00'
        ]);

        // Créer Sarah (Physique, Collège & Lycée, Mercredi 14h-16h + Samedi 10h-22h)
        $sarah = Tutor::create([
            'name' => 'Sarah',
            'email' => 'sarah@example.com',
            'phone' => '0123456788',
            'experience_years' => 3,
            'hourly_rate' => 20.00,
            'bio' => 'Spécialiste en physique'
        ]);

        // Attacher les matières et niveaux à Sarah
        $sarah->subjects()->attach($physique->id);
        DB::table('tutor_school_levels')->insert([
            ['tutor_id' => $sarah->id, 'school_level' => 'college', 'created_at' => now(), 'updated_at' => now()],
            ['tutor_id' => $sarah->id, 'school_level' => 'lycee', 'created_at' => now(), 'updated_at' => now()]
        ]);

        // Créer les disponibilités de Sarah
        $sarah->availabilities()->create([
            'day_of_week' => 'wednesday',
            'start_time' => '14:00:00',
            'end_time' => '16:00:00'
        ]);
        $sarah->availabilities()->create([
            'day_of_week' => 'saturday',
            'start_time' => '10:00:00',
            'end_time' => '22:00:00'
        ]);

        // Créer Karim (Français, Terminale, Lundi 18h-20h)
        $karim = Tutor::create([
            'name' => 'Karim',
            'email' => 'karim@example.com',
            'phone' => '0123456787',
            'experience_years' => 4,
            'hourly_rate' => 22.00,
            'bio' => 'Professeur de français'
        ]);

        // Attacher les matières et niveaux à Karim
        $karim->subjects()->attach($francais->id);
        DB::table('tutor_school_levels')->insert([
            'tutor_id' => $karim->id,
            'school_level' => 'terminale',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Créer les disponibilités de Karim
        $karim->availabilities()->create([
            'day_of_week' => 'monday',
            'start_time' => '18:00:00',
            'end_time' => '20:00:00'
        ]);

        // Créer Ali (Mathématiques, Lycée, Lundi 18h-20h)
        $ali = Student::create([
            'name' => 'Ali',
            'email' => 'ali@example.com',
            'phone' => '0123456786',
            'school_level' => 'lycee',
            'notes' => 'Élève motivé'
        ]);

        // Attacher les matières à Ali
        $ali->subjects()->attach($mathematiques->id);

        // Créer les disponibilités d'Ali
        $ali->availabilities()->create([
            'day_of_week' => 'monday',
            'start_time' => '18:00:00',
            'end_time' => '20:00:00'
        ]);

        // Créer Yasmine (Physique, Collège, Mercredi 14h-16h)
        $yasmine = Student::create([
            'name' => 'Yasmine',
            'email' => 'yasmine@example.com',
            'phone' => '0123456785',
            'school_level' => 'college',
            'notes' => 'Élève sérieuse'
        ]);

        // Attacher les matières à Yasmine
        $yasmine->subjects()->attach($physique->id);

        // Créer les disponibilités de Yasmine
        $yasmine->availabilities()->create([
            'day_of_week' => 'wednesday',
            'start_time' => '14:00:00',
            'end_time' => '16:00:00'
        ]);


        // Créer emma (Physique, Collège, Mercredi 14h-16h)
        $emma = Student::create([
            'name' => 'Emmanuel',
            'email' => 'emma@example.com',
            'phone' => '0123456785',
            'school_level' => 'college',
            'notes' => 'Élève sérieuse'
        ]);

        // Attacher les matières à Yasmine
        $emma->subjects()->attach($physique->id);

        // Créer les disponibilités de Yasmine
        $emma->availabilities()->create([
            'day_of_week' => 'wednesday',
            'start_time' => '14:00:00',
            'end_time' => '16:00:00'
        ]);

        $this->command->info('Données d\'exemple créées avec succès !');
        $this->command->info('Tuteurs: Ahmed, Sarah, Karim');
        $this->command->info('Étudiants: Ali, Yasmine');
    }

    /**
     * Vider toutes les tables
     */
    private function truncateTables(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('availabilities')->truncate();
        DB::table('tutor_school_levels')->truncate();
        DB::table('tutor_subject')->truncate();
        DB::table('student_subject')->truncate();
        DB::table('tutors')->truncate();
        DB::table('students')->truncate();
        DB::table('subjects')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
} 