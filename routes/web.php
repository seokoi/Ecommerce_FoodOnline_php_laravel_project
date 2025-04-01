<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

// Food routes
Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
Route::get('/foods/{food}', [FoodController::class, 'show'])->name('foods.show');

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    // User management routes
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/{id}/permissions/edit', [AdminController::class, 'editPermissions'])->name('admin.users.permissions.edit');
    Route::put('/admin/users/{id}/permissions', [AdminController::class, 'updatePermissions'])->name('admin.users.permissions.update');
    // Order management routes
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::post('/admin/orders/{order}/update', [OrderController::class, 'adminUpdate'])->name('admin.orders.update');
    Route::delete('/admin/orders/{order}', [OrderController::class, 'adminDestroy'])->name('admin.orders.destroy');

    // Food management routes
    Route::get('/admin/foods', [FoodController::class, 'adminIndex'])->name('admin.foods.index');
    Route::get('/admin/foods/create', [FoodController::class, 'create'])->name('admin.foods.create');
    Route::post('/admin/foods', [FoodController::class, 'store'])->name('admin.foods.store');
    Route::get('/admin/foods/{food}/edit', [FoodController::class, 'edit'])->name('admin.foods.edit');
    Route::put('/admin/foods/{food}', [FoodController::class, 'update'])->name('admin.foods.update');
    Route::delete('/admin/foods/{food}', [FoodController::class, 'destroy'])->name('admin.foods.destroy');

    // Statistics route
    Route::get('/manager/statistics', [ManagerController::class, 'showStatistics'])->name('manager.statistics');
});

// User routes requiring specific permissions
Route::middleware(['auth', 'permission:manage food'])->group(function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index'); // Hiển thị danh sách danh mục
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create'); // Hiển thị form tạo danh mục
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store'); // Lưu danh mục mới
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit'); // Hiển thị form sửa danh mục
    Route::post('categories/{category}', [CategoryController::class, 'update'])->name('categories.update'); // Cập nhật danh mục
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy'); // Xóa danh mục
});

    Route::get('/admin/foods', [FoodController::class, 'adminIndex'])->name('admin.foods.index');
    Route::get('/admin/foods/create', [FoodController::class, 'create'])->name('admin.foods.create');
    Route::post('/admin/foods', [FoodController::class, 'store'])->name('admin.foods.store');
    Route::get('/admin/foods/{food}/edit', [FoodController::class, 'edit'])->name('admin.foods.edit');
    Route::put('/admin/foods/{food}', [FoodController::class, 'update'])->name('admin.foods.update');
    Route::delete('/admin/foods/{food}', [FoodController::class, 'destroy'])->name('admin.foods.destroy');
});


Route::middleware(['auth', 'permission:manage orders'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::post('/admin/orders/{order}/update', [OrderController::class, 'adminUpdate'])->name('admin.orders.update');
    Route::delete('/admin/orders/{order}', [OrderController::class, 'adminDestroy'])->name('admin.orders.destroy');
    Route::patch('admin/orders/{order}/update', [OrderController::class, 'adminUpdate'])->name('admin.orders.update');
});

Route::middleware(['auth', 'permission:view reports'])->group(function () {
    Route::get('/manager/statistics', [ManagerController::class, 'showStatistics'])->name('manager.statistics');
});

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/api/provinces', [UserController::class, 'getProvinces'])->name('api.provinces');
    Route::get('/api/districts/{provinceId}', [UserController::class, 'getDistricts'])->name('api.districts');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{foodId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{cartItemId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkoutSelected'])->name('cart.checkoutSelected');

    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('orders/track/{orderId}', [OrderController::class, 'trackOrder'])->name('orders.track');

    // Checkout routes
    Route::get('/checkout/immediate', [CartController::class, 'immediatePurchase'])->name('checkout.immediate');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // Success route
    Route::get('/orders/success', [OrderController::class, 'success'])->name('orders.success');
});