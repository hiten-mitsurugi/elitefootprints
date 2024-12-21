<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    // Social Login Routes
    Route::get('login/{provider}', [GoogleLoginController::class, 'redirect'])->name('login.provider');
    Route::get('login/{provider}/callback', [GoogleLoginController::class, 'callback'])->name('login.provider.callback');

    // Public Routes
    Route::get('/', [FrontendController::class, 'index'])->name('myHome');
    Route::get('/about', [FrontendController::class, 'about'])->name('aboutUs');
    Route::inertia('/contact', 'Frontend/Contact')->name('contactUS');
});


// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('user', UserController::class);

  
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::resource('product', ProductController::class)->except('create');
  
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


});

// Customer routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [FrontendController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile Routes (These should be accessible to both Admin and Customer)

    
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/order/{orderId}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/order/item/{orderItemId}', [OrderController::class, 'destroy'])->name('order.item.destroy');
    Route::post('/order/pay/{orderItemId}', [OrderController::class, 'pay'])->name('order.pay');
    
    Route::post('/purchase', [OrderController::class, 'purchase'])->name('purchase');

    Route::get('/shops', [ShopController::class, 'shops'])->name('shops');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::match(['get', 'post'], '/checkout', [ShopController::class, 'checkout'])->name('checkout');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

});

   
    

// Single Logout Route (Common to both Admin and Customer)



require __DIR__ . '/auth.php';
