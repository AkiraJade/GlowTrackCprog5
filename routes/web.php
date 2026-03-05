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

Route::get('/about', function () {
    return view('about');
})->name('about');

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

    // Cart Routes
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{cart}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

    // Checkout Routes
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

    // Orders Routes
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/cancel', [\App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');

    // Seller Application Routes (for customers)
    Route::get('/seller/application', [SellerApplicationController::class, 'create'])->name('seller.application.create');
    Route::post('/seller/application', [SellerApplicationController::class, 'store'])->name('seller.application.store');
    Route::get('/seller/application/status', [SellerApplicationController::class, 'status'])->name('seller.application.status');
    Route::get('/seller/application/{application}', [SellerApplicationController::class, 'show'])->name('seller.application.show');
});

// Optional: Dashboard route
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        // Redirect based on user role
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isSeller()) {
            return redirect()->route('seller.dashboard');
        } else {
            return view('dashboard');
        }
    })->name('dashboard');
});

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Features Route
Route::get('/features', function () {
    return view('features');
})->name('features');

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

// Seller Routes
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', function () {
        return view('seller.dashboard');
    })->name('dashboard');
    // Seller-specific application management removed here to avoid route conflicts
    // Public/customer-facing seller application routes are defined earlier (auth guarded)
    
    // Seller Product Management
    Route::get('/products', [ProductController::class, 'sellerIndex'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'sellerCreate'])->name('products.create');
    Route::post('/products', [ProductController::class, 'sellerStore'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'sellerEdit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'sellerUpdate'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'sellerDestroy'])->name('products.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Product Management
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products/{product}/approve', [AdminController::class, 'approveProduct'])->name('products.approve');
    Route::post('/products/{product}/reject', [AdminController::class, 'rejectProduct'])->name('products.reject');
    
    // Order Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/sales', [AdminController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/inventory', [AdminController::class, 'inventoryReport'])->name('reports.inventory');
    
    // Seller Application Management
    Route::get('/seller-applications', [SellerApplicationController::class, 'index'])->name('seller-applications');
    Route::get('/seller-applications/{application}', [SellerApplicationController::class, 'show'])->name('seller-applications.show');
    Route::put('/seller-applications/{application}/approve', [SellerApplicationController::class, 'approve'])->name('seller-applications.approve');
    Route::put('/seller-applications/{application}/reject', [SellerApplicationController::class, 'reject'])->name('seller-applications.reject');
});
