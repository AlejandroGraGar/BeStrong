<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Ejercicio; 

class EjercicioSeeder extends Seeder
{
    public function run()
    {

        $response = Http::get('https://wger.de/api/v2/exercise/?language=2&limit=50');
        
        if ($response->successful()) {
            $ejercicios = $response->json()['results'];

            foreach ($ejercicios as $ej) {
                $videoResponse = Http::get("https://wger.de/api/v2/video/?exercise=" . $ej['id']);
                $videoUrl = null;

                if ($videoResponse->successful() && count($videoResponse->json()['results']) > 0) {
                    $videoUrl = $videoResponse->json()['results'][0]['video'];
                }

                Ejercicio::create([
                    'nombre'      => $ej['name'],
                    'descripcion' => strip_tags($ej['description']), 
                    'video_url'   => $videoUrl, 
                ]);
            }
        }
    }
}