<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Админ-панель | @yield('title', 'Театр имени Аяза Гилязова')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        .transition-all { transition: all 0.3s ease; }
        .sidebar-link.active { background-color: rgba(255, 255, 255, 0.1); border-left: 4px solid #ef4444; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside class="bg-gradient-to-b from-red-950 to-red-900 text-white w-64 fixed inset-y-0 left-0 z-50 transition-all duration-300 transform"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="p-6">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 mb-8">
                    <i class="fas fa-theater-masks text-3xl text-red-400"></i>
                    <div>
                        <h1 class="text-lg font-bold">Театр имени</h1>
                        <p class="text-xs opacity-70 italic">Админ-панель</p>
                    </div>
                </a>
                
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line w-6"></i>
                        <span>Дашборд</span>
                    </a>
                    
                    <a href="{{ route('admin.spectacles.index') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.spectacles.*') ? 'active' : '' }}">
                        <i class="fas fa-theater-masks w-6"></i>
                        <span>Спектакли</span>
                    </a>
                    
                    <a href="{{ route('admin.shows.index') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.shows.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt w-6"></i>
                        <span>Афиша</span>
                    </a>
                    
                    <a href="{{ route('admin.actors.index') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.actors.*') ? 'active' : '' }}">
                        <i class="fas fa-user-friends w-6"></i>
                        <span>Артисты</span>
                    </a>
                    
                    <a href="{{ route('admin.news.index') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper w-6"></i>
                        <span>Новости</span>
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fas fa-ticket-alt w-6"></i>
                        <span>Заказы</span>
                    </a>

                    <a href="{{ route('admin.reviews.index') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <i class="fas fa-star w-6"></i>
                        <span>Отзывы</span>
                    </a>

                    <div class="pt-4 mt-4 border-t border-white/10">
                        <a href="{{ route('admin.users.index') }}" 
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users w-6"></i>
                            <span>Пользователи</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-500/20 text-red-300 transition">
                                <i class="fas fa-sign-out-alt w-6"></i>
                                <span>Выйти</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Content Area -->
        <div class="flex-1 flex flex-col transition-all duration-300"
             :class="sidebarOpen ? 'ml-64' : 'ml-0'">
            
            <!-- Topbar -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 sticky top-0 z-40">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-red-600 transition">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-red-600 transition flex items-center">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        На сайт
                    </a>
                    <div class="h-8 w-px bg-gray-200"></div>
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Администратор</p>
                        </div>
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold">
                            {{ mb_substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Успех!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Ошибка!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('header')</h2>
                </div>

                @yield('content')
            </main>
            
            <footer class="mt-auto py-4 px-6 bg-white border-t text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Театр имени Аяза Гилязова. Панель управления.
            </footer>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>