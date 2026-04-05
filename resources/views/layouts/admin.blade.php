<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Админ-панель | @yield('title', 'Театр имени Аяза Гилязова')</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="admin-body">
    <div class="admin-wrapper" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside class="admin-sidebar" :class="sidebarOpen ? 'open' : 'closed'">
            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="sidebar-logo">
                    <img src="{{ asset('images/logo.svg') }}" alt="Театр им. Гилязова" style="height: 35px; filter: brightness(0) invert(1);">
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Дашборд</span>
                </a>
                
                <a href="{{ route('admin.spectacles.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.spectacles.*') ? 'active' : '' }}">
                    <i class="fas fa-theater-masks"></i>
                    <span>Спектакли</span>
                </a>
                
                <a href="{{ route('admin.shows.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.shows.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Афиша</span>
                </a>
                
                <a href="{{ route('admin.actors.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.actors.*') ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i>
                    <span>Артисты</span>
                </a>
                
                <a href="{{ route('admin.news.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Новости</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Заказы</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span>Отзывы</span>
                </a>

                <div class="sidebar-divider"></div>

                <a href="{{ route('admin.users.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Пользователи</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="sidebar-link logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Выйти</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Content Area -->
        <div class="admin-main" :class="sidebarOpen ? 'expanded' : 'collapsed'">
            
            <!-- Topbar -->
            <header class="admin-topbar">
                <button @click="sidebarOpen = !sidebarOpen" class="toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="topbar-right">
                    <a href="{{ route('home') }}" class="back-to-site">
                        <i class="fas fa-external-link-alt"></i>
                        <span>На сайт</span>
                    </a>
                    <div class="user-profile-sm">
                        <div class="user-info-text">
                            <p class="user-name-sm">{{ Auth::user()->name }}</p>
                            <p class="user-role-sm">Администратор</p>
                        </div>
                        <div class="user-avatar-sm">
                            {{ mb_substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <div class="content-header">
                    <h2 class="content-title">@yield('header')</h2>
                </div>

                <div class="content-body">
                    @yield('content')
                </div>
            </main>
            
            <footer class="admin-footer">
                &copy; {{ date('Y') }} Театр имени Аяза Гилязова. Панель управления.
            </footer>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
