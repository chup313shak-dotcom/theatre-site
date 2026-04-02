@extends('layouts.admin')

@section('title', 'Добавить спектакль')
@section('header', 'Новый спектакль')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <form action="{{ route('admin.spectacles.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Название -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Название (RU)</label>
                    <input type="text" name="title" required value="{{ old('title') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Название (TAT)</label>
                    <input type="text" name="title_tatar" value="{{ old('title_tatar') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                </div>

                <!-- Режиссер и Длительность -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Режиссер</label>
                    <input type="text" name="director" required value="{{ old('director') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Длительность (мин)</label>
                    <input type="number" name="duration" required value="{{ old('duration') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                </div>

                <!-- Жанр и Возрастной ценз -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Жанр</label>
                    <input type="text" name="genre" value="{{ old('genre') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Возрастной ценз</label>
                    <select name="age_limit" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        <option value="0+">0+</option>
                        <option value="6+">6+</option>
                        <option value="12+">12+</option>
                        <option value="16+">16+</option>
                        <option value="18+">18+</option>
                    </select>
                </div>
            </div>

            <!-- Описание -->
            <div class="mt-6 space-y-2">
                <label class="text-sm font-bold text-gray-700">Описание</label>
                <textarea name="description" rows="5" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">{{ old('description') }}</textarea>
            </div>

            <!-- Постер -->
            <div class="mt-6 space-y-2">
                <label class="text-sm font-bold text-gray-700">Постер (изображение)</label>
                <input type="file" name="poster" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
            </div>

            <div class="mt-8 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.spectacles.index') }}" class="px-6 py-2 text-gray-600 hover:text-gray-800 transition">Отмена</a>
                <button type="submit" class="bg-red-600 text-white px-8 py-2 rounded-lg hover:bg-red-700 transition font-bold shadow-md">
                    Сохранить спектакль
                </button>
            </div>
        </form>
    </div>
</div>
@endsection