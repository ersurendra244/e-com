<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


// Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Issues
Route::get('issues', [IssueController::class, 'index'])->name('issues');
Route::get('issues-data', [IssueController::class, 'getIssues'])->name('issues.data');
Route::get('issues-export', [IssueController::class, 'exportIssues'])->name('issues.export');

// Roles
Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles');
    Route::post('list', [RoleController::class, 'list'])->name('roles.list');
    Route::get('create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('delete/{id?}', [RoleController::class, 'delete'])->name('roles.delete');
    Route::post('permissions-update', [RoleController::class, 'permissions_update'])->name('roles.permissions_update');
    Route::post('permissions-bulk-update', [RoleController::class, 'permissions_bulk_update'])->name('roles.permissions_bulk_update');
});

// Permissions
Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('permissions');
    Route::post('list', [PermissionController::class, 'list'])->name('permissions.list');
    Route::post('store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::get('delete/{id?}', [PermissionController::class, 'delete'])->name('permissions.delete');
});

// Users
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::post('list', [UserController::class, 'list'])->name('users.list');
    Route::get('create', [UserController::class, 'create'])->name('users.create');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('save', [UserController::class, 'save'])->name('users.save');
    Route::get('delete/{id?}', [UserController::class, 'delete'])->name('users.delete');

    // Profile Routes (sab roles ke liye available)
    Route::get('edit-profile', [UserController::class, 'edit_profile'])->name('edit_profile');
    Route::post('update-profile', [UserController::class, 'update_profile'])->name('update_profile');
    Route::post('update-password', [UserController::class, 'update_password'])->name('update_password');
    Route::get('saved-address', [UserController::class, 'saved_address'])->name('saved_address');
    Route::get('edit-address', [UserController::class, 'edit_address'])->name('edit_address');
    Route::post('store-address', [UserController::class, 'store_address'])->name('store_address');
    Route::get('reviews', [UserController::class, 'reviews'])->name('reviews');
    Route::get('reviews-list', [UserController::class, 'reviews_list'])->name('reviews_list');
});

// Products
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products');
    Route::post('list', [ProductController::class, 'list'])->name('products.list');
    Route::get('create', [ProductController::class, 'create'])->name('products.create');
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::post('save', [ProductController::class, 'save'])->name('products.save');
    Route::get('delete/{id?}', [ProductController::class, 'delete'])->name('products.delete');
    Route::post('get-categories', [ProductController::class, 'get_categories'])->name('product.get_categories');
    Route::post('get-sub-categories', [ProductController::class, 'get_sub_categories'])->name('product.get_sub_categories');
    Route::post('get-form-fields', [ProductController::class, 'get_form_fields'])->name('product.get_form_fields');
    Route::post('variants-delete', [ProductController::class, 'variants_delete'])->name('product.variants_delete');
    Route::post('variants-image-delete', [ProductController::class, 'variants_image_delete'])->name('product.variants_image_delete');
    Route::get('variants/{product_id}', [ProductController::class, 'variants'])->name('products.variants');
    Route::get('variants-manage/{product_id}/{id?}', [ProductController::class, 'variants_manage'])->name('products.variants_manage');
    Route::post('variants-save/{id?}', [ProductController::class, 'variants_save'])->name('products.variants_save');
    Route::get('reviews/{id}', [ProductController::class, 'reviews'])->name('products.reviews');
    Route::post('reviews-list', [ProductController::class, 'reviews_list'])->name('products.reviews_list');
});

// Files
Route::prefix('files')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('files');
    Route::post('list', [FileController::class, 'list'])->name('files.list');
    Route::get('create', [FileController::class, 'create'])->name('files.create');
    Route::get('edit/{id}', [FileController::class, 'edit'])->name('files.edit');
    Route::post('update/{id}', [FileController::class, 'update'])->name('files.update');
    Route::post('save', [FileController::class, 'save'])->name('files.save');
    Route::get('delete/{id?}', [FileController::class, 'delete'])->name('files.delete');
    Route::post('share', [FileController::class, 'share'])->name('files.share');
    Route::get('reviews/{id}', [FileController::class, 'reviews'])->name('files.reviews');
});

// Settings
Route::prefix('settings')->group(function () {
    Route::get('site-settings', [SettingController::class, 'index'])->name('settings');
    Route::post('update/{id}', [SettingController::class, 'update'])->name('settings.update');
});

// File Manager
Route::prefix('file-manager')->group(function () {
    Route::get('{parent_id?}', [FileManagerController::class, 'index'])->name('file_manager');
    Route::post('create', [FileManagerController::class, 'create'])->name('file_manager.create');
    Route::get('edit/{id}', [FileManagerController::class, 'edit'])->name('file_manager.edit');
    Route::get('view/{id}', [FileManagerController::class, 'view'])->name('file_manager.view');
    Route::post('file-save/{id}', [FileManagerController::class, 'saveContent'])->name('file_manager.file_save');
    Route::post('rename', [FileManagerController::class, 'rename'])->name('file_manager.rename');
    Route::get('delete/{id?}', [FileManagerController::class, 'delete'])->name('file_manager.delete');
});

// Masters
Route::prefix('masters')->group(function () {

    Route::prefix('menus')->group(function () {
        Route::get('/', [MasterController::class, 'menu'])->name('masters.menu');
        Route::post('edit', [MasterController::class, 'menu_edit'])->name('masters.menu_edit');
        Route::post('save', [MasterController::class, 'menu_save'])->name('masters.menu_save');
        Route::get('delete/{id?}', [MasterController::class, 'menu_delete'])->name('masters.menu_delete');
    });

    Route::prefix('brands')->group(function () {
        Route::get('/', [MasterController::class, 'brand'])->name('masters.brand');
        Route::post('edit', [MasterController::class, 'brand_edit'])->name('masters.brand_edit');
        Route::post('save', [MasterController::class, 'brand_save'])->name('masters.brand_save');
        Route::get('delete/{id?}', [MasterController::class, 'brand_delete'])->name('masters.brand_delete');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::post('list', [CategoryController::class, 'list'])->name('categories.list');
        Route::post('store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('create', [CategoryController::class, 'create'])->name('categories.create');
        Route::get('edit/{id?}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('update/{id?}', [CategoryController::class, 'update'])->name('categories.update');
        Route::get('delete/{id?}', [CategoryController::class, 'delete'])->name('categories.delete');
    });

    Route::prefix('subcategories')->group(function () {
        Route::get('/', [SubCategoryController::class, 'index'])->name('subcategory');
        Route::post('list', [SubCategoryController::class, 'list'])->name('subcategory.list');
        Route::post('store', [SubCategoryController::class, 'store'])->name('subcategory.store');
        Route::get('create', [SubCategoryController::class, 'create'])->name('subcategory.create');
        Route::get('edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
        Route::post('update/{id}', [SubCategoryController::class, 'update'])->name('subcategory.update');
        Route::get('delete/{id?}', [SubCategoryController::class, 'delete'])->name('subcategory.delete');
        Route::get('{id}/form-fields', [SubCategoryController::class, 'form_fields'])->name('subcategory.form_fields');
        Route::post('form-fields-save', [SubCategoryController::class, 'form_fields_save'])->name('subcategory.form_fields_save');
        Route::get('{id}/form_view', [SubCategoryController::class, 'form_view'])->name('subcategory.form_view');
        Route::post('form-fields-edit/{id?}', [SubCategoryController::class, 'form_fields_edit'])->name('sub_categories.form_fields_edit');
        Route::get('form-fields-delete/{id?}', [SubCategoryController::class, 'form_fields_delete'])->name('subcategory.form_fields_delete');
    });

    Route::prefix('pages')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('pages');
        Route::post('list', [PageController::class, 'list'])->name('pages.list');
        Route::post('store', [PageController::class, 'store'])->name('pages.store');
        Route::get('create', [PageController::class, 'create'])->name('pages.create');
        Route::get('edit/{id}', [PageController::class, 'edit'])->name('pages.edit');
        Route::post('update/{id}', [PageController::class, 'update'])->name('pages.update');
        Route::get('delete/{id?}', [PageController::class, 'delete'])->name('pages.delete');
    });
});
