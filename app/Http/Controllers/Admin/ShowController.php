<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Show;
use App\Models\Spectacle;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function index()
    {
        $shows = Show::with('spectacle')->latest()->paginate(10);
        return view('admin.shows.index', compact('shows'));
    }

    public function create()
    {
        $spectacles = Spectacle::all();
        return view('admin.shows.create', compact('spectacles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'spectacle_id' => 'required|exists:spectacles,id',
            'start_time' => 'required|date',
            'venue' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $spectacle = Spectacle::find($request->spectacle_id);
        $validated['end_time'] = \Carbon\Carbon::parse($request->start_time)->addMinutes($spectacle->duration);

        // Добавляем дефолтную схему зала и цены, если они не указаны (так как это обязательные поля)
        $validated['hall_schema'] = [
            'rows' => [
                ['row' => '1', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 20))],
                ['row' => '2', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 20))],
                ['row' => '3', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 18))],
                ['row' => '4', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 18))],
                ['row' => '5', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 16))],
                ['row' => '6', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 16))],
                ['row' => '7', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 14))],
                ['row' => '8', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 14))],
                ['row' => '9', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 12))],
                ['row' => '10', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 12))],
            ]
        ];

        $validated['prices'] = [
            'vip' => ['rows' => ['from' => 1, 'to' => 3], 'price' => 1500],
            'standard' => ['rows' => ['from' => 4, 'to' => 7], 'price' => 1000],
            'economy' => ['rows' => ['from' => 8, 'to' => 10], 'price' => 600],
            'default' => ['price' => 500]
        ];

        Show::create($validated);

        return redirect()->route('admin.shows.index')->with('success', 'Показ добавлен в афишу');
    }

    public function edit(Show $show)
    {
        $spectacles = Spectacle::all();
        return view('admin.shows.edit', compact('show', 'spectacles'));
    }

    public function update(Request $request, Show $show)
    {
        $validated = $request->validate([
            'spectacle_id' => 'required|exists:spectacles,id',
            'start_time' => 'required|date',
            'venue' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $spectacle = Spectacle::find($request->spectacle_id);
        $validated['end_time'] = \Carbon\Carbon::parse($request->start_time)->addMinutes($spectacle->duration);

        $show->update($validated);

        return redirect()->route('admin.shows.index')->with('success', 'Информация о показе обновлена');
    }

    public function destroy(Show $show)
    {
        $show->delete();
        return redirect()->route('admin.shows.index')->with('success', 'Показ удален из афиши');
    }
}