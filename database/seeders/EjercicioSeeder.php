<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Ejercicio;

class EjercicioSeeder extends Seeder
{
    public function run(): void
    {
        set_time_limit(0);

        $images = [];
        $urlImages = 'https://wger.de/api/v2/exerciseimage/';

        while ($urlImages) {
            $response = Http::get($urlImages);
            if (!$response->successful()) break;

            $data = $response->json();
            foreach ($data['results'] as $img) {
                if ($img['is_main']) {
                    $images[$img['exercise']] = $img['image'];
                }
            }
            $urlImages = $data['next'];
        }

        $urlExercises = 'https://wger.de/api/v2/exercise-translation/';

        while ($urlExercises) {
            $response = Http::get($urlExercises);
            if (!$response->successful()) break;

            $data = $response->json();
            foreach ($data['results'] as $item) {
                if ($item['language'] == 4) {
                $exerciseId = $item['exercise'];
                $imagen = $images[$exerciseId] ?? null;

                Ejercicio::updateOrCreate(
                    ['nombre' => $item['name']],
                    [
                        'descripcion' => $item['description'] ?? null,
                        'imagen'      => $imagen,
                    ]
                );
            }
            }
            $urlExercises = $data['next'];
        }
    }
}