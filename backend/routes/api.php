<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CityController;

use App\Http\Controllers\Api\Admin\AdminDashboardController;
use App\Http\Controllers\Api\Admin\AdminProductController;
use App\Http\Controllers\Api\Admin\AdminOrderController;
use App\Http\Controllers\Api\Admin\AdminSellerController;
use App\Http\Controllers\Api\Admin\AdminUserController;

use App\Http\Controllers\Api\Seller\SellerDashboardController;
use App\Http\Controllers\Api\Seller\SellerProductController;
use App\Http\Controllers\Api\Seller\SellerOrderController;

use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureIsSeller;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Products
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/featured', [ProductController::class, 'featured']);
Route::get('/products/flash-deals', [ProductController::class, 'flashDeals']);
Route::get('/products/suggestions', [ProductController::class, 'searchSuggestions']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

// Sellers
Route::get('/sellers', [SellerController::class, 'index']);
Route::get('/sellers/{slug}', [SellerController::class, 'show']);
Route::get('/sellers/{slug}/products', [SellerController::class, 'products']);

// Banners, Cities, Coupons
Route::get('/banners', [BannerController::class, 'index']);
Route::get('/cities', [CityController::class, 'index']);
Route::post('/coupons/validate', [CouponController::class, 'validateCoupon']);

// Product Reviews
Route::get('/products/{id}/reviews', [ReviewController::class, 'indexForProduct']);

// Cart (guest & auth)
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/items', [CartController::class, 'addItem']);
Route::put('/cart/items/{id}', [CartController::class, 'updateItem']);
Route::delete('/cart/items/{id}', [CartController::class, 'removeItem']);
Route::delete('/cart', [CartController::class, 'clearCart']);

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'destroy']);

    // Addresses
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::put('/addresses/{id}', [AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);
    Route::put('/addresses/{id}/default', [AddressController::class, 'setDefault']);

    // Orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);

    // Reviews
    Route::post('/products/{id}/reviews', [ReviewController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', EnsureIsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/stats', [AdminDashboardController::class, 'stats']);

    Route::get('/products', [AdminProductController::class, 'index']);
    Route::put('/products/{id}/toggle-active', [AdminProductController::class, 'toggleActive']);
    Route::put('/products/{id}/toggle-featured', [AdminProductController::class, 'toggleFeatured']);
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy']);

    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);

    Route::get('/sellers', [AdminSellerController::class, 'index']);
    Route::put('/sellers/{id}/toggle-verify', [AdminSellerController::class, 'toggleVerify']);

    Route::get('/users', [AdminUserController::class, 'index']);
    Route::put('/users/{id}/role', [AdminUserController::class, 'updateRole']);
});

/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', EnsureIsSeller::class])->prefix('seller')->group(function () {
    Route::get('/stats', [SellerDashboardController::class, 'stats']);

    Route::get('/products', [SellerProductController::class, 'index']);
    Route::post('/products', [SellerProductController::class, 'store']);
    Route::put('/products/{id}', [SellerProductController::class, 'update']);
    Route::delete('/products/{id}', [SellerProductController::class, 'destroy']);

    Route::get('/orders', [SellerOrderController::class, 'index']);
});
