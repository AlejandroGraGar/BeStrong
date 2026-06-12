<?php

use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrenamientoController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\EjercicioRutinaController;
use App\Http\Controllers\EntrenamientoEjercicioController;
use App\Http\Controllers\RutinaController;
use App\Models\Entrenamiento;
use App\Http\Controllers\AdminController;

Route::get('/', [EntrenamientoController::class, 'index'])->name('home')->middleware('auth');


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
Route::match(['get', 'post'], '/entrenamientos/start/{rutina}', [EntrenamientoController::class, 'startRutina'])->name('entrenamientos.start.rutina');


// Ejercicios
Route::get('/ejercicios', [EjercicioController::class, 'index'])->name('ejercicios.index');
Route::match(['get','post'], '/ejercicios/crear', [EjercicioController::class, 'create'])->name('ejercicios.create');
Route::match(['get','post'], '/ejercicios/editar/{id}', [EjercicioController::class, 'update'])->name('ejercicios.update');
Route::delete('/ejercicios/eliminar/{id}', [EjercicioController::class, 'delete'])->name('ejercicios.delete');
Route::get('/ejercicios/ver/{ejercicio}', [EjercicioController::class, 'show'])->name('ejercicios.show');
Route::match(['get', 'post'], '/ejercicios/show/{id}', [EjercicioController::class, 'show'])->name('ejercicios.show');

// Rutinas
Route::get('/rutinas', [RutinaController::class, 'index'])->name('rutinas.index');
Route::match(['get','post'], '/rutinas/crear', [RutinaController::class, 'create'])->name('rutinas.create');
Route::match(['get','post'], '/rutinas/editar/{id}', [RutinaController::class, 'update'])->name('rutinas.update');
Route::delete('/rutinas/eliminar/{id}', [RutinaController::class, 'delete'])->name('rutinas.destroy');
Route::get('/rutinas/ver/{id}', [RutinaController::class, 'show'])->name('rutinas.show');


//ejercicioRutina
Route::match(['get','post'], '/ejercicioRutina/{rutina}/crear', [EjercicioRutinaController::class, 'create'])->name('ejercicioRutina.create');
Route::delete('/ejercicioRutina/{rutina}/eliminar/{ejercicio}', [EjercicioRutinaController::class, 'delete'])->name('ejercicioRutina.delete');
Route::match(['get', 'put'], '/rutinas/{rutina}/edit-ejercicios', [EjercicioRutinaController::class, 'update'])->name('ejercicioRutina.update');

//Datos Usuario
use App\Http\Controllers\DatosUsuarioController;

Route::match(['get','post'], '/perfil', [DatosUsuarioController::class, 'create'])->name('datos_usuario.create');
Route::get('/datos-usuarios', [DatosUsuarioController::class, 'index'])->name('datos_usuarios.index');
Route::match(['get', 'post', 'put'], '/datos-usuarios/{id}', [DatosUsuarioController::class, 'update'])->name('datos_usuarios.update');

//Premium
Route::get('/premium', function () {
    return view('premium.index');
})->name('premium');
Route::get('/premium/pago', function () {
    return view('premium.pago');
})->name('premium.pago');


Route::view('/politica-privacidad', 'privacidad')
    ->name('privacidad');

Route::post('/admin/publicidad', [AdminController::class, 'updateAd'])
    ->middleware('auth')
    ->name('admin.ad.update');