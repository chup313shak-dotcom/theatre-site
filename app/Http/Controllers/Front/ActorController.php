<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Actor;

class ActorController extends Controller
{
    public function index()
    {
        $actors = Actor::orderBy('category')->paginate(12);
        
        $categories = [
            'Народный артист' => Actor::where('category', 'Народный артист')->get(),
            'Заслуженный артист' => Actor::where('category', 'Заслуженный артист')->get(),
            'Артист' => Actor::where('category', 'Артист')->get()
        ];
        
        return view('front.actors.index', compact('actors', 'categories'));
    }
    
    public function show($id)
    {
        $actor = Actor::with('spectacles')->findOrFail($id);
        $currentSeasonRoles = $actor->getCurrentSeasonRoles();
        
        return view('front.actors.show', compact('actor', 'currentSeasonRoles'));
    }
}