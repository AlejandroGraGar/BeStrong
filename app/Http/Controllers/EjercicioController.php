<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;

class EjercicioController extends Controller
{
    
    public function index()
    {
        $ejercicios = Ejercicio::all();
        $total_ejercicios = $ejercicios->count();
        return view('ejercicios.index', compact('ejercicios', 'total_ejercicios'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(Ejercicio $ejercicio)
    {
        //
    }

    
    public function edit(Ejercicio $ejercicio)
    {
        //
    }

    
    public function update(Request $request, Ejercicio $ejercicio)
    {
        //
    }

    
    public function destroy(Ejercicio $ejercicio)
    {
        //
    }
        

}
