<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');    // Clear config cache
    Artisan::call('cache:clear');     // Clear application cache
    Artisan::call('route:clear');     // Clear route cache
    Artisan::call('view:clear');      // Clear compiled views
    Artisan::call('optimize:clear');  // Clear all compiled caches (optional, recommended)
    return "✅ All caches cleared successfully!";
});

// Route::get('/test-mail', function () {

//     Mail::to('surendra.kumar.10961@gmail.com')->send(
//         new WelcomeUserMail([
//             'name' => 'Surendra Kumar',
//             'email' => 'surendra.kumar.10961@gmail.com'
//         ])
//     );

//     return 'Mail Sent';
// });


Route::get('/', [HomeController::class, 'index'])->name('web.home');

Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('web.home.contact_us');
Route::post('/contact-us-save', [HomeController::class, 'contact_us_save'])->name('web.home.contact_us_save');

Route::get('/shop/{slug?}', [ProductController::class, 'shop'])->name('web.products.shop');
Route::post('/list', [ProductController::class, 'list'])->name('web.products.list');
Route::get('/product-details/{id}', [ProductController::class, 'details'])->name('web.products.details');
Route::post('/product-details/reviews_save', [ProductController::class, 'reviews_save'])->name('web.products.reviews.save');
Route::post('/get-sizes-by-color', [ProductController::class, 'getSizesByColor']);

Route::post('/add-to-cart', [ProductController::class, 'addToCart'])->name('web.products.addToCart');


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/verify-email/{id}', [AuthController::class, 'verifyEmail'])->middleware('signed')->name('verifyEmail');
Route::get('/signup/{type?}', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup_save', [AuthController::class, 'signup_save'])->name('signup_save');
Route::post('/loginCheck', [AuthController::class, 'loginCheck'])->name('loginCheck');



Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('get-user', [DashboardController::class, 'getUser'])->name('admin.dashboard.getUser');

Route::get('/pages/{slug}', [HomeController::class, 'pages'])->name('web.home.pages');

/*
|--------------------------------------------------------------------------
| Dynamic Role-Based Panel Routes
|--------------------------------------------------------------------------
| Routes SIRF EK BAAR define hain → routes/panel.php me.
|
| URL Structure:  /{role}/dashboard, /{role}/users, etc.
| Example:
|   /admin/dashboard   → name: admin.dashboard
|   /vendor/dashboard  → name: vendor.dashboard
|   /user/dashboard    → name: user.dashboard
|
| Middleware:
|   auth       → Login check
|   check.role → URL {role} ko user ke actual role se match karta hai
|
| Naya Role Add karna ho? Sirf roles table me add karo — yahan kuch nahi badlega!
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'check.role'])
    ->prefix('{role}')
    // ->name('{role}.')
    ->group(function () {
        require __DIR__ . '/panel.php';
    });
