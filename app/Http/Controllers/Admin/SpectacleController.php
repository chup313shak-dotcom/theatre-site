<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spectacle;
use Illuminate\Http\Request;

class SpectacleController extends Controller
{
    public function index()
    {
        $spectacles = Spectacle::latest()->paginate(10);
        return view('admin.spectacles.index', compact('spectacles'));
    }

    public function create()
    {
        return view('admin.spectacles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_tatar' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'director' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'genre' => 'nullable|string|max:255',
            'age_limit' => 'required|string|max:10',
            'poster' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $validated['poster'] = '/storage/' . $path;
        }

        Spectacle::create($validated);

        return redirect()->route('admin.spectacles.index')->with('success', 'Спектакль успешно добавлен');
    }

    public function edit(Spectacle $spectacle)
    {
        return view('admin.spectacles.edit', compact('spectacle'));
    }

    public function update(Request $request, Spectacle $spectacle)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_tatar' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'director' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'genre' => 'nullable|string|max:255',
            'age_limit' => 'required|string|max:10',
            'poster' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            // Удаляем старый постер
            if ($spectacle->poster && str_contains($spectacle->poster, '/storage/')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $spectacle->poster));
            }
            $path = $request->file('poster')->store('posters', 'public');
            $validated['poster'] = '/storage/' . $path;
        }

        $spectacle->update($validated);

        return redirect()->route('admin.spectacles.index')->with('success', 'Спектакль успешно обновлен');
    }

    public function destroy(Spectacle $spectacle)
    {
        $spectacle->delete();
        return redirect()->route('admin.spectacles.index')->with('success', 'Спектакль удален');
    }
}