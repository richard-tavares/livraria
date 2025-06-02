<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        Subject::create(['description' => 'Aventura']);
        Subject::create(['description' => 'Biografia']);
        Subject::create(['description' => 'Fantasia']);
        Subject::create(['description' => 'Ficção Científica']);
        Subject::create(['description' => 'Distopia']);
        Subject::create(['description' => 'Ação']);
        Subject::create(['description' => 'Terror']);
        Subject::create(['description' => 'Romance']);
    }
}
