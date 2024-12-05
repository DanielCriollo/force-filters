<?php

namespace Database\Seeders;

use App\Models\Step;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            Step::create([
                'step_name' => 'Solicitar identificación',
                'step_type' => 'input',
                'prompt' => 'Por favor, ingresa tu número de identificación',
            ]);
        
            Step::create([
                'step_name' => 'Verificación de Identificación',
                'step_type' => 'action',
                'prompt' => 'Estamos verificando tu información...',
            ]);
        }
    }
}
