<?php

use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusculoController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\EntrenamientoController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\RutinaController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

require __DIR__.'/auth.php';


// Entrenamientos
Route::prefix('entrenamientos')->group(function () {
    Route::get('/', [EntrenamientoController::class, 'index'])->name('entrenamientos.index');
    Route::match(['get','post'], '/crear', [EntrenamientoController::class, 'create'])->name('entrenamientos.create');
    Route::match(['get','post'], '/editar/{id}', [EntrenamientoController::class, 'update'])->name('entrenamientos.update');
    Route::delete('/eliminar/{id}', [EntrenamientoController::class, 'delete'])->name('entrenamientos.delete');
    Route::get('/ver/{id}', [EntrenamientoController::class, 'show'])->name('entrenamientos.show');
});

// Musculos
Route::prefix('musculos')->group(function () {
    Route::get('/', [MusculoController::class, 'index'])->name('musculos.index');
    Route::match(['get','post'], '/crear', [MusculoController::class, 'create'])->name('musculos.create');
    Route::match(['get','post'], '/editar/{id}', [MusculoController::class, 'update'])->name('musculos.update');
    Route::delete('/eliminar/{id}', [MusculoController::class, 'delete'])->name('musculos.delete');
    Route::get('/ver/{id}', [MusculoController::class, 'show'])->name('musculos.show');
});

// Ejercicios
Route::prefix('ejercicios')->group(function () {
    Route::get('/', [EjercicioController::class, 'index'])->name('ejercicios.index');
    Route::match(['get','post'], '/crear', [EjercicioController::class, 'create'])->name('ejercicios.create');
    Route::match(['get','post'], '/editar/{id}', [EjercicioController::class, 'update'])->name('ejercicios.update');
    Route::delete('/eliminar/{id}', [EjercicioController::class, 'delete'])->name('ejercicios.delete');
    Route::get('/ver/{id}', [EjercicioController::class, 'show'])->name('ejercicios.show');
});
Route::get('/import-exercises', [ExerciseController::class, 'import']);

//Rutinas
Route::prefix('rutinas')->group(function () {
    Route::get('/', [RutinaController::class, 'index'])->name('rutinas.index');
    Route::match(['get','post'], '/crear', [RutinaController::class, 'create'])->name('rutinas.create');
    Route::match(['get','post'], '/editar/{id}', [RutinaController::class, 'update'])->name('rutinas.update');
    Route::delete('/eliminar/{id}', [RutinaController::class, 'delete'])->name('rutinas.delete');
    Route::get('/ver/{id}', [RutinaController::class, 'show'])->name('rutinas.show');
});
Route::get('/import-exercises', [ExerciseController::class, 'import']);
