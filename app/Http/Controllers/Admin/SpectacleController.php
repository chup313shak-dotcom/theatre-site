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
        // Логика сохранения
        return redirect()->route('admin.spectacles.index')->with('success', 'Спектакль успешно добавлен');
    }

    public function edit(Spectacle $spectacle)
    {
        return view('admin.spectacles.edit', compact('spectacle'));
    }

    public function update(Request $request, Spectacle $spectacle)
    {
        // Логика обновления
        return redirect()->route('admin.spectacles.index')->with('success', 'Спектакль успешно обновлен');
    }

    public function destroy(Spectacle $spectacle)
    {
        $spectacle->delete();
        return redirect()->route('admin.spectacles.index')->with('success', 'Спектакль удален');
    }
}