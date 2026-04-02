@extends('layouts.admin')

@section('title', 'Афиша')
@section('header', 'Управление афишей')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="font-bold text-gray-800">Расписание показов</h3>
        <a href="{{ route('admin.shows.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center text-sm">
            <i class="fas fa-plus mr-2"></i> Добавить показ
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                    <th class="px-6 py-3">Дата и время</th>
                    <th class="px-6 py-3">Спектакль</th>
                    <th class="px-6 py-3">Место</th>
                    <th class="px-6 py-3">Статус</th>
                    <th class="px-6 py-3">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($shows as $show)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $show->start_time->format('d.m.Y') }}</div>
                            <div class="text-xs text-red-600 font-bold">{{ $show->start_time->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $show->spectacle->title }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $show->venue ?? 'Основная сцена' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($show->start_time->isPast())
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Завершен</span>
                            @elseif($show->is_active)
                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded text-xs">Активен</span>
                            @else
                                <span class="px-2 py-1 bg-red-50 text-red-700 rounded text-xs">Приостановлен</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.shows.edit', $show->id) }}" class="text-blue-600 hover:text-blue-800 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.shows.destroy', $show->id) }}" method="POST" onsubmit="return confirm('Вы уверены?')">
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
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">Показов не запланировано</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($shows->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $shows->links() }}
        </div>
    @endif
</div>
@endsection