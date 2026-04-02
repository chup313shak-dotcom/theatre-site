<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_tatar' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['published_at'] = $validated['published_at'] ?? now();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'Новость опубликована');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_tatar' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            if ($news->image && str_contains($news->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $news->image));
            }
            $path = $request->file('image')->store('news', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'Новость обновлена');
    }

    public function destroy(News $news)
    {
        if ($news->image && str_contains($news->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $news->image));
        }
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Новость удалена');
    }
}