<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Exercise;

class ImportExercises extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exercises:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa ejercicios desde ExerciseDB a la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('GET https://zylalabs.com/api/7229/base+de+datos+de+ejercicios+de+fitness+api/11408/ejercicio+de+lista+por+parte+del+cuerpo?bodyPart=cardio');

        $data = $response->json();
        dd($response->json());

        foreach ($data as $item) {

            Exercise::updateOrCreate(
                ['external_id' => $item['id']],
                [
                    'name' => $item['name'],
                    'body_part' => $item['bodyPart'] ?? null,
                    'target' => $item['target'] ?? null,
                    'equipment' => $item['equipment'] ?? null,
                    'gif_url' => $item['gifUrl'] ?? null,
                ]
            );
        }

        $this->info('Importación completada');
    }

}
