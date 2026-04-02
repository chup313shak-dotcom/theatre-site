<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Театр имени Аяза Гилязова')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        .transition-all { transition: all 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-gradient-to-r from-red-900 to-red-800 text-white sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <i class="fas fa-theater-masks text-3xl"></i>
                    <div>
                        <h1 class="text-xl font-bold">Театр имени</h1>
                        <p class="text-sm opacity-90">Аяза Гилязова</p>
                    </div>
                </a>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('spectacles.index') }}" class="hover:text-red-300 transition">Афиша</a>
                    <a href="{{ route('actors.index') }}" class="hover:text-red-300 transition">Группа</a>
                    <a href="{{ route('news.index') }}" class="hover:text-red-300 transition">Новости</a>
                    <a href="/about" class="hover:text-red-300 transition">О театре</a>
                    <a href="/contacts" class="hover:text-red-300 transition">Контакты</a>
                </nav>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 hover:text-red-300">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 text-gray-800">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-red-50 text-red-700 font-bold border-b border-gray-100">
                                        <i class="fas fa-user-shield mr-2"></i> Админ-панель
                                    </a>
                                @endif
                                <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Личный кабинет
                                </a>
                                <a href="{{ route('profile.orders') }}" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-ticket-alt mr-2"></i> Мои билеты
                                </a>
                                <a href="{{ route('profile.favorites') }}" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-heart mr-2"></i> Избранное
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Выйти
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-red-300 transition">
                            <i class="fas fa-sign-in-alt mr-1"></i> Вход
                        </a>
                        <a href="{{ route('register') }}" class="bg-red-600 px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            Регистрация
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="min-h-screen py-8">
        @if(session('success'))
            <div class="container mx-auto px-4 mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container mx-auto px-4 mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">Театр имени Аяза Гилязова</h3>
                    <p class="text-sm text-gray-400">Ведущий театр республики, хранитель культурных традиций.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-3">Контакты</h4>
                    <p class="text-sm text-gray-400"><i class="fas fa-map-marker-alt mr-2"></i> г. Казань, ул. Театральная, 1</p>
                    <p class="text-sm text-gray-400 mt-2"><i class="fas fa-phone mr-2"></i> +7 (843) 123-45-67</p>
                    <p class="text-sm text-gray-400 mt-2"><i class="fas fa-envelope mr-2"></i> info@theatre.ru</p>
                </div>
                <div>
                    <h4 class="font-bold mb-3">Режим работы</h4>
                    <p class="text-sm text-gray-400">Касса: 10:00 - 19:00</p>
                    <p class="text-sm text-gray-400">Спектакли: 18:30</p>
                    <p class="text-sm text-gray-400">Выходной: понедельник</p>
                </div>
                <div>
                    <h4 class="font-bold mb-3">Мы в соцсетях</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-vk text-2xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-telegram text-2xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube text-2xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Театр имени Аяза Гилязова. Все права защищены.</p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>