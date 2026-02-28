<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\SellerApplicationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Support Routes
    Route::get('/support/contact', [SupportController::class, 'contact'])->name('support.contact');
    Route::post('/support/submit', [SupportController::class, 'submit'])->name('support.submit');
    Route::get('/support/knowledge', [SupportController::class, 'knowledge'])->name('support.knowledge');
    Route::get('/support/forum', [ForumController::class, 'index'])->name('support.forum');

    // Forum Routes
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::get('/forum/{discussion}', [ForumController::class, 'show'])->name('forum.discussion');
    Route::get('/forum/{discussion}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::put('/forum/{discussion}', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{discussion}', [ForumController::class, 'destroy'])->name('forum.destroy');
    Route::post('/forum/{discussion}/reply', [ForumController::class, 'reply'])->name('forum.reply');
    Route::post('/forum/replies/{replyId}/reply', [ForumController::class, 'replyToReply'])->name('forum.reply-to-reply');
    Route::delete('/forum/replies/{reply}', [ForumController::class, 'deleteReply'])->name('forum.delete-reply');

    // Loyalty Program Routes
    Route::get('/loyalty', [LoyaltyController::class, 'index'])->name('loyalty.index');
    Route::post('/loyalty/redeem', [LoyaltyController::class, 'redeem'])->name('loyalty.redeem');
});

// Optional: Dashboard route
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/my-products', [ProductController::class, 'myProducts'])->name('products.my');
    
    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Seller Application Routes
Route::middleware('auth')->prefix('seller')->name('seller.')->group(function () {
    Route::get('/application', [SellerApplicationController::class, 'create'])->name('application.create');
    Route::post('/application', [SellerApplicationController::class, 'store'])->name('application.store');
    Route::get('/application/status', [SellerApplicationController::class, 'status'])->name('application.status');
    Route::get('/application/{application}', [SellerApplicationController::class, 'show'])->name('application.show');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Seller Application Management
    Route::get('/seller-applications', [SellerApplicationController::class, 'index'])->name('seller-applications');
    Route::get('/seller-applications/{application}', [SellerApplicationController::class, 'show'])->name('seller-applications.show');
    Route::put('/seller-applications/{application}/approve', [SellerApplicationController::class, 'approve'])->name('seller-applications.approve');
    Route::put('/seller-applications/{application}/reject', [SellerApplicationController::class, 'reject'])->name('seller-applications.reject');
});
