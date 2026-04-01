<!-- resources/views/front/profile/partials/sidebar.blade.php -->
<div class="bg-white rounded-lg shadow-md p-4">
    <div class="text-center mb-4">
        <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-3 flex items-center justify-center">
            <i class="fas fa-user text-4xl text-gray-500"></i>
        </div>
        <h3 class="font-bold text-lg">{{ Auth::user()->name }}</h3>
        <p class="text-gray-600 text-sm">{{ Auth::user()->email }}</p>
    </div>
    
    <nav class="space-y-2">
        <a href="{{ route('profile') }}" 
           class="block px-4 py-2 hover:bg-gray-100 rounded-lg transition">
            <i class="fas fa-tachometer-alt mr-2"></i> Главная
        </a>
        <a href="{{ route('profile.orders') }}" 
           class="block px-4 py-2 hover:bg-gray-100 rounded-lg transition">
            <i class="fas fa-ticket-alt mr-2"></i> Мои билеты
        </a>
        <a href="{{ route('profile.favorites') }}" 
           class="block px-4 py-2 hover:bg-gray-100 rounded-lg transition">
            <i class="fas fa-heart mr-2"></i> Избранное
        </a>
        <a href="{{ route('profile.edit') }}" 
           class="block px-4 py-2 hover:bg-gray-100 rounded-lg transition">
            <i class="fas fa-user-edit mr-2"></i> Редактировать профиль
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 rounded-lg transition text-red-600">
                <i class="fas fa-sign-out-alt mr-2"></i> Выйти
            </button>
        </form>
    </nav>
</div>