@extends('layouts.admin')

@section('title', 'Новости')
@section('header', 'Управление новостями')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="font-bold text-gray-800">Список новостей</h3>
        <a href="{{ route('admin.news.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center text-sm">
            <i class="fas fa-plus mr-2"></i> Добавить новость
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                    <th class="px-6 py-3">Изображение</th>
                    <th class="px-6 py-3">Заголовок</th>
                    <th class="px-6 py-3">Дата публикации</th>
                    <th class="px-6 py-3">Статус</th>
                    <th class="px-6 py-3">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($news as $item)
                    <tr class="hover:bg-gray-50/50 transition group">
                        <td class="px-6 py-4">
                            <img src="{{ $item->image ?? '/images/default-news.jpg' }}" 
                                 class="w-16 h-10 object-cover rounded shadow-sm" 
                                 alt="{{ $item->title }}">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900 line-clamp-1">{{ $item->title }}</div>
                            <div class="text-xs text-gray-500 line-clamp-1">{{ Str::limit(strip_tags($item->content), 50) }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->published_at ? $item->published_at->format('d.m.Y') : 'Не указана' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($item->is_published)
                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded text-xs">Опубликовано</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-50 text-yellow-700 rounded text-xs">Черновик</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Вы уверены?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">Новостей пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($news->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $news->links() }}
        </div>
    @endif
</div>
@endsection