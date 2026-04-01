<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-center mb-6">Вход в личный кабинет</h1>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Пароль</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-sm text-gray-600">Запомнить меня</span>
                </label>
                <a href="#" class="text-sm text-red-600 hover:underline">Забыли пароль?</a>
            </div>
            
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
                Войти
            </button>
        </form>
        
        <p class="text-center text-gray-600 mt-4">
            Нет аккаунта? 
            <a href="{{ route('register') }}" class="text-red-600 hover:underline">Зарегистрироваться</a>
        </p>
    </div>
</div>
@endsection