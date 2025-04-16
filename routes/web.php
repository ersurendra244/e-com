<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Admin\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/clear-cache', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('optimize');

    return "✅ Cache, Cache cleared successfully!";
});

Route::get('/', [HomeController::class, 'index'])->name('web.home');

Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('web.home.contact_us');
Route::post('/contact-us-save', [HomeController::class, 'contact_us_save'])->name('web.home.contact_us_save');

Route::get('/shop', [ProductController::class, 'shop'])->name('web.products.shop');
Route::post('/list', [ProductController::class, 'list'])->name('web.products.list');
Route::get('/product-details/{id}', [ProductController::class, 'details'])->name('web.products.details');
Route::post('/product-details/reviews_save', [ProductController::class, 'reviews_save'])->name('web.products.reviews.save');
Route::post('/get-sizes-by-color', [ProductController::class, 'getSizesByColor']);

Route::post('/add-to-cart', [ProductController::class, 'addToCart'])->name('web.products.addToCart');


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/signup/{type?}', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup_save', [AuthController::class, 'signup_save'])->name('signup_save');
Route::post('/loginCheck', [AuthController::class, 'loginCheck'])->name('loginCheck');



Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('get-user', [DashboardController::class, 'getUser'])->name('admin.dashboard.getUser');


// User Routes (Only Accessible by Authors)
Route::middleware(['auth', 'role:User'])->prefix('user')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'user_dashboard'])->name('user.dashboard');
    Route::get('edit-profile', [UserController::class, 'edit_profile'])->name('user.edit_profile');
    Route::post('update-profile', [UserController::class, 'update_profile'])->name('user.update_profile');
    Route::post('delete', [UserController::class, 'delete'])->name('user.users.delete');
    Route::get('saved-address', [UserController::class, 'saved_address'])->name('user.saved_address');
    Route::post('store-address', [UserController::class, 'store_address'])->name('user.store_address');
    Route::post('edit-address', [UserController::class, 'edit_address'])->name('user.edit_address');
    Route::post('update-password', [UserController::class, 'update_password'])->name('user.update_password');
    Route::get('reviews', [UserController::class, 'reviews'])->name('user.reviews');
    Route::post('reviews-list', [UserController::class, 'reviews_list'])->name('user.reviews_list');

});

require __DIR__ . '/admin.php';



