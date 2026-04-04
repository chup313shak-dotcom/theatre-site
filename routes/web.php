<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\SpectacleController;
use App\Http\Controllers\Front\ShowController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\Front\ActorController;
use App\Http\Controllers\Front\NewsController;
use Illuminate\Support\Facades\Auth;

// ============ АУТЕНТИФИКАЦИЯ ============
// Маршруты для гостей
Route::middleware('guest')->group(function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::get('register', function () {
        return view('auth.register');
    })->name('register');
});

// Маршруты для авторизованных пользователей
Route::post('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout')->middleware('auth');

// Обработка аутентификации (временные маршруты)
Route::post('login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }
    
    return back()->withErrors([
        'email' => 'Неверные учетные данные.',
    ]);
})->name('login.attempt');

Route::post('register', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
    ]);
    
    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'user',
    ]);
    
    Auth::login($user);
    
    return redirect('/');
})->name('register.attempt');

// ============ ПУБЛИЧНЫЕ МАРШРУТЫ ============
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');
Route::get('/spectacles', [SpectacleController::class, 'index'])->name('spectacles.index');
Route::get('/spectacles/{id}', [SpectacleController::class, 'show'])->name('spectacles.show');
Route::post('/spectacles/{id}/review', [SpectacleController::class, 'addReview'])->name('spectacles.review');
Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');
Route::get('/actors/{id}', [ActorController::class, 'show'])->name('actors.show');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// API маршруты
Route::prefix('api')->group(function () {
    Route::get('/shows/{id}/seats', [ShowController::class, 'getSeats']);
    Route::post('/shows/{id}/reserve', [ShowController::class, 'reserveSeats'])->middleware('auth');
});

// Маршруты для авторизованных пользователей
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout/{orderId}', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{orderId}/payment', [OrderController::class, 'processPayment'])->name('checkout.payment');
    Route::get('/order/success/{orderId}', [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/cancel/{orderId}', [OrderController::class, 'cancel'])->name('order.cancel');
    // Просмотр и скачивание билетов
    Route::get('/order/view-ticket/{ticketId}', [App\Http\Controllers\Front\OrderController::class, 'viewTicket'])->name('order.view.ticket');
    Route::get('/order/download-ticket/{ticketId}', [App\Http\Controllers\Front\OrderController::class, 'downloadTicket'])->name('order.download.ticket');
    Route::post('/order/extend/{orderId}', [App\Http\Controllers\Front\ShowController::class, 'extendReservation'])
        ->name('order.extend');
    
    // Профиль
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/order/{orderId}', [ProfileController::class, 'orderDetails'])->name('profile.order.details');
    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::post('/profile/favorites/{spectacleId}', [ProfileController::class, 'toggleFavorite'])->name('profile.favorites.toggle');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/download-ticket/{ticketId}', [ProfileController::class, 'downloadTicket'])->name('profile.download.ticket');
});

// ============ АДМИН ПАНЕЛЬ ============
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Спектакли
    Route::resource('spectacles', App\Http\Controllers\Admin\SpectacleController::class);
    
    // Артисты
    Route::resource('actors', App\Http\Controllers\Admin\ActorController::class);
    
    // Новости
    Route::resource('news', App\Http\Controllers\Admin\NewsController::class);
    
    // Афиша (Показы)
    Route::resource('shows', App\Http\Controllers\Admin\ShowController::class);
    
    // Заказы
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    
    // Отзывы
    Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/toggle', [App\Http\Controllers\Admin\ReviewController::class, 'toggleStatus'])->name('reviews.toggle');
    Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Пользователи
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});