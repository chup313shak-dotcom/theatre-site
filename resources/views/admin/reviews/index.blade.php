@extends('layouts.admin')

@section('title', 'Отзывы')
@section('header', 'Модерация отзывов зрителей')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                    <th class="px-6 py-3">Зритель</th>
                    <th class="px-6 py-3">Спектакль</th>
                    <th class="px-6 py-3">Текст отзыва</th>
                    <th class="px-6 py-3">Оценка</th>
                    <th class="px-6 py-3">Статус</th>
                    <th class="px-6 py-3">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $review->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $review->created_at->format('d.m.Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">{{ $review->spectacle->title }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600 italic line-clamp-2">"{{ $review->content }}"</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex text-yellow-400">
                                @for($i=0; $i<5; $i++)
                                    <i class="fas fa-star {{ $i < $review->rating ? '' : 'opacity-20' }} text-xs"></i>
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($review->is_approved)
                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded text-xs">Одобрен</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-50 text-yellow-700 rounded text-xs">На модерации</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST">
                                    @csrf
                                    <button class="text-blue-600 hover:underline">
                                        {{ $review->is_approved ? 'Скрыть' : 'Одобрить' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Удалить отзыв?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">Отзывов пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection