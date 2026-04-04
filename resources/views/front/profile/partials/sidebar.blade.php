<!-- resources/views/front/profile/partials/sidebar.blade.php -->
<aside class="profile-sidebar card">
    <div class="profile-user-info text-center">
        <div class="profile-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <h3 class="profile-name">{{ Auth::user()->name }}</h3>
        <p class="profile-email">{{ Auth::user()->email }}</p>
    </div>
    
    <nav class="profile-nav">
        <a href="{{ route('profile') }}" 
           class="profile-nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> <span>Главная</span>
        </a>
        <a href="{{ route('profile.orders') }}" 
           class="profile-nav-link {{ request()->routeIs('profile.orders') || request()->routeIs('profile.order.details') ? 'active' : '' }}">
            <i class="fas fa-ticket-alt"></i> <span>Мои билеты</span>
        </a>
        <a href="{{ route('profile.favorites') }}" 
           class="profile-nav-link {{ request()->routeIs('profile.favorites') ? 'active' : '' }}">
            <i class="fas fa-heart"></i> <span>Избранное</span>
        </a>
        <a href="{{ route('profile.edit') }}" 
           class="profile-nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="fas fa-user-edit"></i> <span>Редактировать профиль</span>
        </a>
        
        <div class="nav-divider"></div>
        
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="profile-nav-link logout-btn-sidebar">
                <i class="fas fa-sign-out-alt"></i> <span>Выйти</span>
            </button>
        </form>
    </nav>
</aside>

<style>
.profile-sidebar { padding: 30px 0; border: none; }
.profile-user-info { padding: 0 30px 30px; border-bottom: 1px solid var(--gray-medium); margin-bottom: 20px; }
.profile-avatar { font-size: 5rem; color: var(--primary-color); margin-bottom: 15px; }
.profile-name { font-size: 1.25rem; color: var(--primary-dark); font-weight: 700; margin-bottom: 5px; }
.profile-email { font-size: 0.9rem; color: var(--text-muted); }
.profile-nav { display: flex; flex-direction: column; }
.profile-nav-link { display: flex; align-items: center; gap: 15px; padding: 12px 30px; color: var(--text-color); font-weight: 500; transition: var(--transition); border-left: 4px solid transparent; }
.profile-nav-link i { width: 20px; font-size: 1.1rem; color: var(--text-muted); }
.profile-nav-link:hover { background-color: var(--gray-light); color: var(--primary-color); }
.profile-nav-link.active { background-color: var(--primary-light); color: var(--primary-color); border-left-color: var(--primary-color); font-weight: 700; }
.profile-nav-link.active i { color: var(--primary-color); }
.nav-divider { height: 1px; background-color: var(--gray-medium); margin: 15px 0; }
.logout-btn-sidebar { width: 100%; border: none; background: none; cursor: pointer; text-align: left; font-family: inherit; font-size: inherit; }
.logout-btn-sidebar:hover { color: var(--error-color); }
.logout-btn-sidebar:hover i { color: var(--error-color); }
</style>
