@extends('layouts.admin')

@section('title', 'Добавить показ')
@section('header', 'Новое событие в афише')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <form action="{{ route('admin.shows.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-6">
                <!-- Спектакль -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Выберите спектакль</label>
                    <select name="spectacle_id" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        <option value="">-- Выберите из списка --</option>
                        @foreach($spectacles as $spectacle)
                            <option value="{{ $spectacle->id }}">{{ $spectacle->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Дата и время -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Дата и время начала</label>
                    <input type="datetime-local" name="start_time" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                </div>

                <!-- Место -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Место проведения</label>
                    <input type="text" name="venue" value="Основная сцена" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                </div>

                <!-- Статус -->
                <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                           class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <label for="is_active" class="text-sm font-bold text-gray-700 cursor-pointer">Активен (доступен для покупки)</label>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.shows.index') }}" class="px-6 py-2 text-gray-600 hover:text-gray-800 transition">Отмена</a>
                <button type="submit" class="bg-red-600 text-white px-8 py-2 rounded-lg hover:bg-red-700 transition font-bold shadow-md">
                    Добавить в афишу
                </button>
            </div>
        </form>
    </div>
</div>
@endsection