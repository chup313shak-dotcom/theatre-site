@extends('layouts.admin')

@section('title', 'Артисты')
@section('header', 'Управление труппой')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="font-bold text-gray-800">Список артистов</h3>
        <a href="{{ route('admin.actors.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center text-sm">
            <i class="fas fa-plus mr-2"></i> Добавить артиста
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                    <th class="px-6 py-3">Фото</th>
                    <th class="px-6 py-3">Имя</th>
                    <th class="px-6 py-3">Категория</th>
                    <th class="px-6 py-3">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($actors as $actor)
                    <tr class="hover:bg-gray-50/50 transition group">
                        <td class="px-6 py-4">
                            <img src="{{ $actor->photo ?? '/images/default-actor.jpg' }}" 
                                 class="w-10 h-10 object-cover rounded-full shadow-sm" 
                                 alt="{{ $actor->name }}">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $actor->name }}</div>
                            <div class="text-xs text-gray-500">{{ $actor->name_tatar }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="px-2 py-1 bg-purple-50 text-purple-700 rounded text-xs">
                                {{ $actor->category ?? 'Артист' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.actors.edit', $actor->id) }}" class="text-blue-600 hover:text-blue-800 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.actors.destroy', $actor->id) }}" method="POST" onsubmit="return confirm('Вы уверены?')">
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
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">Артистов пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($actors->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $actors->links() }}
        </div>
    @endif
</div>
@endsection