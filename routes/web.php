<?php

use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusculoController;
use App\Http\Controllers\EntrenamientoController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\EjercicioRutinaController;
use App\Http\Controllers\EntrenamientoEjercicioController;
use App\Http\Controllers\RutinaController;
use App\Models\Entrenamiento;

Route::get('/', [EntrenamientoController::class, 'index'])
    ->name('home')
    ->middleware('auth');

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
Route::get('/entrenamientos', [EntrenamientoController::class, 'index'])->name('entrenamientos.index');
Route::match(['get','post'], '/entrenamientos/crear', [EntrenamientoController::class, 'create'])->name('entrenamientos.create');
Route::match(['get','post'], '/entrenamientos/editar/{id}', [EntrenamientoController::class, 'update'])->name('entrenamientos.update');
Route::delete('/entrenamientos/eliminar/{id}', [EntrenamientoController::class, 'delete'])->name('entrenamientos.delete');
Route::get('/entrenamientos/ver/{id}', [EntrenamientoController::class, 'show'])->name('entrenamientos.show');


// Musculos
Route::get('/musculos', [MusculoController::class, 'index'])->name('musculos.index');
Route::match(['get','post'], '/musculos/crear', [MusculoController::class, 'create'])->name('musculos.create');
Route::match(['get','post'], '/musculos/editar/{id}', [MusculoController::class, 'update'])->name('musculos.update');
Route::delete('/musculos/eliminar/{id}', [MusculoController::class, 'delete'])->name('musculos.delete');
Route::get('/musculos/ver/{id}', [MusculoController::class, 'show'])->name('musculos.show');


// Ejercicios
Route::get('/ejercicios', [EjercicioController::class, 'index'])->name('ejercicios.index');
Route::match(['get','post'], '/ejercicios/crear', [EjercicioController::class, 'create'])->name('ejercicios.create');
Route::match(['get','post'], '/ejercicios/editar/{id}', [EjercicioController::class, 'update'])->name('ejercicios.update');
Route::delete('/ejercicios/eliminar/{id}', [EjercicioController::class, 'delete'])->name('ejercicios.delete');
Route::get('/ejercicios/ver/{id}', [EjercicioController::class, 'show'])->name('ejercicios.show');


// Rutinas
Route::get('/rutinas', [RutinaController::class, 'index'])->name('rutinas.index');
Route::match(['get','post'], '/rutinas/crear', [RutinaController::class, 'create'])->name('rutinas.create');
Route::match(['get','post'], '/rutinas/editar/{id}', [RutinaController::class, 'update'])->name('rutinas.update');
Route::delete('/rutinas/eliminar/{id}', [RutinaController::class, 'delete'])->name('rutinas.destroy');
Route::get('/rutinas/ver/{id}', [RutinaController::class, 'show'])->name('rutinas.show');

//entrenamientoEjercicio
Route::get('/entrenamientosEjercicio', [EntrenamientoEjercicioController::class, 'index'])->name('entrenamientosEjercicio.index');
Route::match(['get','post'], '/entrenamientosEjercicio/crear', [EntrenamientoEjercicioController::class, 'create'])->name('entrenamientosEjercicio.create');
Route::match(['get','post'], '/entrenamientosEjercicio/editar/{id}', [EntrenamientoEjercicioController::class, 'update'])->name('entrenamientosEjercicio.update');
Route::delete('/entrenamientosEjercicio/eliminar/{id}', [EntrenamientoEjercicioController::class, 'delete'])->name('entrenamientosEjercicio.delete');
Route::get('/entrenamientosEjercicio/ver/{id}', [EntrenamientoEjercicioController::class, 'show'])->name('entrenamientosEjercicio.show');

//ejercicioRutina
Route::match(['get','post'], '/ejercicioRutina/{rutina}/crear', [EjercicioRutinaController::class, 'create'])->name('ejercicioRutina.create');
Route::delete('/ejercicioRutina/{rutina}/eliminar/{ejercicio}', [EjercicioRutinaController::class, 'delete'])->name('ejercicioRutina.delete');
Route::match(['get', 'put'], '/rutinas/{rutina}/edit-ejercicios', [EjercicioRutinaController::class, 'edit'])->name('ejercicioRutina.update');
