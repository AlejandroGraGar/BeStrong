<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Ejercicio;

class EjercicioSeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::get('https://wger.de/api/v2/exercise-translation/?language=4');

        if ($response->successful()) {
            $data = $response->json();
            $exercises = $data['results']; 

            foreach ($exercises as $item) {
                Ejercicio::create(
                    ['nombre' => $item['name']],
                    ['descripcion' => $item['description'] ?? ''],
                    [   'video_url'   => null], 
                    
                );
            }
        }
    }
}