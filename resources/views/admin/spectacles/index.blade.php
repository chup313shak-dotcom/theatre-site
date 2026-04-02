@extends('layouts.admin')

@section('title', 'Спектакли')
@section('header', 'Управление спектаклями')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="font-bold text-gray-800">Список всех спектаклей</h3>
        <a href="{{ route('admin.spectacles.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center text-sm">
            <i class="fas fa-plus mr-2"></i> Добавить спектакль
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                    <th class="px-6 py-3">Постер</th>
                    <th class="px-6 py-3">Название</th>
                    <th class="px-6 py-3">Режиссер</th>
                    <th class="px-6 py-3">Длительность</th>
                    <th class="px-6 py-3">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($spectacles as $spectacle)
                    <tr class="hover:bg-gray-50/50 transition group">
                        <td class="px-6 py-4">
                            <img src="{{ $spectacle->poster ?? '/images/default-poster.jpg' }}" 
                                 class="w-12 h-16 object-cover rounded shadow-sm group-hover:shadow-md transition" 
                                 alt="{{ $spectacle->title }}">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $spectacle->title }}</div>
                            <div class="text-xs text-gray-500 line-clamp-1">{{ $spectacle->genre ?? 'Драма' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $spectacle->director }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ floor($spectacle->duration / 60) }}ч {{ $spectacle->duration % 60 }}мин
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.spectacles.edit', $spectacle->id) }}" class="text-blue-600 hover:text-blue-800 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.spectacles.destroy', $spectacle->id) }}" method="POST" onsubmit="return confirm('Вы уверены?')">
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
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">Спектаклей пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($spectacles->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $spectacles->links() }}
        </div>
    @endif
</div>
@endsection