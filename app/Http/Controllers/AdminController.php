<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class AdminController extends Controller
{
    public function updateAd(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')->store('anuncios', 'public');

        Setting::set('ad_image', $path);

        return back()->with('success', 'Publicidad actualizada');
    }
}