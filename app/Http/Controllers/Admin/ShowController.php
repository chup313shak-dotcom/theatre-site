<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Show;
use App\Models\Spectacle;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    private function getDefaultHallSchema()
    {
        return [
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
    }

    private function getDefaultPrices()
    {
        return [
            'vip' => ['rows' => ['from' => 1, 'to' => 3], 'price' => 1500],
            'standard' => ['rows' => ['from' => 4, 'to' => 7], 'price' => 1000],
            'economy' => ['rows' => ['from' => 8, 'to' => 10], 'price' => 600],
            'default' => ['price' => 500]
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'spectacle_id' => 'required|exists:spectacles,id',
            'start_time' => 'required|date',
            'location' => 'nullable|string|max:255',
        ]);

        $spectacle = Spectacle::findOrFail($request->spectacle_id);
        $startTime = Carbon::parse($request->start_time);
        
        Show::create([
            'spectacle_id' => $request->spectacle_id,
            'start_time' => $startTime,
            'end_time' => $startTime->copy()->addMinutes($spectacle->duration),
            'hall_schema' => $this->getDefaultHallSchema(),
            'prices' => $this->getDefaultPrices(),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.shows.index')->with('success', 'Показ добавлен в афишу');
    }

    public function edit(Show $show)
    {
        $spectacles = Spectacle::all();
        return view('admin.shows.edit', compact('show', 'spectacles'));
    }

    public function update(Request $request, Show $show)
    {
        $request->validate([
            'spectacle_id' => 'required|exists:spectacles,id',
            'start_time' => 'required|date',
            'location' => 'nullable|string|max:255',
        ]);

        $spectacle = Spectacle::findOrFail($request->spectacle_id);
        $startTime = Carbon::parse($request->start_time);

        $show->update([
            'spectacle_id' => $request->spectacle_id,
            'start_time' => $startTime,
            'end_time' => $startTime->copy()->addMinutes($spectacle->duration),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.shows.index')->with('success', 'Информация о показе обновлена');
    }

    public function destroy(Show $show)
    {
        $show->delete();
        return redirect()->route('admin.shows.index')->with('success', 'Показ удален из афиши');
    }
}
