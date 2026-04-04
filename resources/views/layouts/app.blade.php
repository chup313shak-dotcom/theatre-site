<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Театр имени Аяза Гилязова')</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container header-container">
            <div class="header-content">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-theater-masks"></i>
                    <div class="logo-text">
                        <h1 class="logo-title">Театр имени</h1>
                        <p class="logo-subtitle">Аяза Гилязова</p>
                    </div>
                </a>
                
                <!-- Navigation -->
                <nav class="main-nav">
                    <a href="{{ route('spectacles.index') }}" class="nav-link">Афиша</a>
                    <a href="{{ route('actors.index') }}" class="nav-link">Группа</a>
                    <a href="{{ route('news.index') }}" class="nav-link">Новости</a>
                    <a href="/about" class="nav-link">О театре</a>
                    <a href="/contacts" class="nav-link">Контакты</a>
                </nav>
                
                <!-- User Menu -->
                <div class="user-menu">
                    @auth
                        <div class="dropdown" x-data="{ open: false }">
                            <button @click="open = !open" class="dropdown-toggle">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak 
                                 class="dropdown-menu">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item admin-link">
                                        <i class="fas fa-user-shield"></i> Админ-панель
                                    </a>
                                @endif
                                <a href="{{ route('profile') }}" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt"></i> Личный кабинет
                                </a>
                                <a href="{{ route('profile.orders') }}" class="dropdown-item">
                                    <i class="fas fa-ticket-alt"></i> Мои билеты
                                </a>
                                <a href="{{ route('profile.favorites') }}" class="dropdown-item">
                                    <i class="fas fa-heart"></i> Избранное
                                </a>
                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-btn">
                                        <i class="fas fa-sign-out-alt"></i> Выйти
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="auth-links">
                            <a href="{{ route('login') }}" class="nav-link login-link">
                                <i class="fas fa-sign-in-alt"></i> Вход
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary register-btn">
                                Регистрация
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="site-content">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container">
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="main-footer">
        <div class="container footer-container">
            <div class="footer-grid">
                <div class="footer-info">
                    <h3 class="footer-title">Татарский драматический театр имени Аяза Гилязова</h3>
                    <p class="footer-desc">Ведущий театр республики, хранитель культурных традиций.</p>
                </div>
                <div class="footer-contacts">
                    <h4 class="footer-subtitle">Контакты</h4>
                    <p><i class="fas fa-map-marker-alt"></i>Набережные Челны, ЗЯБ, Низаметдинова, 29</p>
                    <p><i class="fas fa-phone"></i> +7 (843) 123-45-67</p>
                    <p><i class="fas fa-envelope"></i> info@theatre.ru</p>
                </div>
                <div class="footer-hours">
                    <h4 class="footer-subtitle">Режим работы</h4>
                    <p>Касса: 10:00 - 19:00</p>
                    <p>Без выходных</p>
                </div>
                <div class="footer-social">
                    <h4 class="footer-subtitle">Мы в соцсетях</h4>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-vk"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-telegram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Театр имени Аяза Гилязова. Все права защищены.</p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>