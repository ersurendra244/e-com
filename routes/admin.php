<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;

// Admin Routes (Only Accessible by Admins)
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

// Author Routes (Only Accessible by Authors)
Route::middleware(['auth', 'role:Author'])->prefix('author')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'author_dashboard'])->name('author.dashboard');
});

// Roles
Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('admin.roles');
    Route::post('list', [RoleController::class, 'list'])->name('admin.roles.list');
    Route::get('create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('store', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('edit/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::post('update/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::post('delete', [RoleController::class, 'delete'])->name('admin.roles.delete');
});
// Permissions
Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('admin.permissions');
    Route::post('list', [PermissionController::class, 'list'])->name('admin.permissions.list');
    Route::post('store', [PermissionController::class, 'store'])->name('admin.permissions.store');
    Route::get('create', [PermissionController::class, 'create'])->name('admin.permissions.create');
    Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
    Route::post('update/{id}', [PermissionController::class, 'update'])->name('admin.permissions.update');
    Route::post('delete', [PermissionController::class, 'delete'])->name('admin.permissions.delete');
});
// Users
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.users');
    Route::post('list', [UserController::class, 'list'])->name('admin.users.list');
    Route::get('create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('update/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::post('save', [UserController::class, 'save'])->name('admin.users.save');
    Route::post('delete', [UserController::class, 'delete'])->name('admin.users.delete');
});
// Products
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('admin.products');
    Route::post('list', [ProductController::class, 'list'])->name('admin.products.list');
    Route::get('create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::post('update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::post('save', [ProductController::class, 'save'])->name('admin.products.save');
    Route::post('delete', [ProductController::class, 'delete'])->name('admin.products.delete');

    Route::get('variants/{product_id}', [ProductController::class, 'variants'])->name('admin.products.variants');
    Route::get('variants_manage/{product_id}/{id?}', [ProductController::class, 'variants_manage'])->name('admin.products.variants_manage');
    Route::post('variants_save/{id?}', [ProductController::class, 'variants_save'])->name('admin.products.variants_save');

    Route::get('reviews/{id}', [ProductController::class, 'reviews'])->name('admin.products.reviews');
    Route::post('reviews-list', [ProductController::class, 'reviews_list'])->name('admin.products.reviews_list');
});
// Files
Route::prefix('files')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('admin.files');
    Route::post('list', [FileController::class, 'list'])->name('admin.files.list');
    Route::get('create', [FileController::class, 'create'])->name('admin.files.create');
    Route::get('edit/{id}', [FileController::class, 'edit'])->name('admin.files.edit');
    Route::post('update/{id}', [FileController::class, 'update'])->name('admin.files.update');
    Route::post('save', [FileController::class, 'save'])->name('admin.files.save');
    Route::post('delete', [FileController::class, 'delete'])->name('admin.files.delete');
    Route::post('share', [FileController::class, 'share'])->name('admin.files.share');
    Route::get('reviews/{id}', [FileController::class, 'reviews'])->name('admin.files.reviews');

});
// categories
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('admin.categories');
    Route::post('list', [CategoryController::class, 'list'])->name('admin.categories.list');
    Route::post('store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::post('update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::post('delete', [CategoryController::class, 'delete'])->name('admin.categories.delete');
});
// settings
Route::prefix('settings')->group(function () {
    Route::get('site-settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('update/{id}', [SettingController::class, 'update'])->name('admin.settings.update');
});

// masters
Route::prefix('masters')->group(function () {
    Route::get('menu', [MasterController::class, 'menu'])->name('admin.masters.menu');
    Route::post('menu-edit', [MasterController::class, 'menu_edit'])->name('admin.masters.menu_edit');
    Route::post('menu-save', [MasterController::class, 'menu_save'])->name('admin.masters.menu_save');
    Route::post('menu-delete', [MasterController::class, 'menu_delete'])->name('admin.masters.menu_delete');
});
