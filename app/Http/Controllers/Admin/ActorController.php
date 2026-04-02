<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActorController extends Controller
{
    public function index()
    {
        $actors = Actor::latest()->paginate(10);
        return view('admin.actors.index', compact('actors'));
    }

    public function create()
    {
        return view('admin.actors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_tatar' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('actors', 'public');
            $validated['photo'] = '/storage/' . $path;
        }

        Actor::create($validated);

        return redirect()->route('admin.actors.index')->with('success', 'Артист успешно добавлен');
    }

    public function edit(Actor $actor)
    {
        return view('admin.actors.edit', compact('actor'));
    }

    public function update(Request $request, Actor $actor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_tatar' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Удаляем старое фото, если оно не дефолтное
            if ($actor->photo && str_contains($actor->photo, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $actor->photo));
            }
            $path = $request->file('photo')->store('actors', 'public');
            $validated['photo'] = '/storage/' . $path;
        }

        $actor->update($validated);

        return redirect()->route('admin.actors.index')->with('success', 'Информация об артисте обновлена');
    }

    public function destroy(Actor $actor)
    {
        if ($actor->photo && str_contains($actor->photo, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $actor->photo));
        }
        $actor->delete();
        return redirect()->route('admin.actors.index')->with('success', 'Артист удален из базы');
    }
}