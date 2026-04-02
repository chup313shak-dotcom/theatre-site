@extends('layouts.admin')

@section('title', 'Добавить артиста')
@section('header', 'Новый артист')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <form action="{{ route('admin.actors.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Имя (RU)</label>
                    <input type="text" name="name" required value="{{ old('name') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Имя (TAT)</label>
                    <input type="text" name="name_tatar" value="{{ old('name_tatar') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Категория (звание)</label>
                    <input type="text" name="category" value="{{ old('category') }}" placeholder="Напр: Народный артист РТ"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Фото</label>
                    <input type="file" name="photo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                </div>
            </div>

            <div class="mt-6 space-y-2">
                <label class="text-sm font-bold text-gray-700">Биография / Информация</label>
                <textarea name="biography" rows="6" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">{{ old('biography') }}</textarea>
            </div>

            <div class="mt-8 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.actors.index') }}" class="px-6 py-2 text-gray-600 hover:text-gray-800 transition">Отмена</a>
                <button type="submit" class="bg-red-600 text-white px-8 py-2 rounded-lg hover:bg-red-700 transition font-bold shadow-md">
                    Добавить в труппу
                </button>
            </div>
        </form>
    </div>
</div>
@endsection