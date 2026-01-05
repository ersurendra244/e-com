<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormFieldController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\SubCategoryController;


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
    Route::get('delete/{id?}', [RoleController::class, 'delete'])->name('admin.roles.delete');
    Route::post('permissions-update', [RoleController::class, 'permissions_update'])->name('admin.roles.permissions_update');
    Route::post('permissions-bulk-update', [RoleController::class, 'permissions_bulk_update'])->name('admin.roles.permissions_bulk_update');
});
// Permissions
Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('admin.permissions');
    Route::post('list', [PermissionController::class, 'list'])->name('admin.permissions.list');
    Route::post('store', [PermissionController::class, 'store'])->name('admin.permissions.store');
    Route::get('create', [PermissionController::class, 'create'])->name('admin.permissions.create');
    Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
    Route::post('update/{id}', [PermissionController::class, 'update'])->name('admin.permissions.update');
    Route::get('delete/{id?}', [PermissionController::class, 'delete'])->name('admin.permissions.delete');

});
// Users
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.users');
    Route::post('list', [UserController::class, 'list'])->name('admin.users.list');
    Route::get('create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('update/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::post('save', [UserController::class, 'save'])->name('admin.users.save');
    Route::get('delete/{id?}', [UserController::class, 'delete'])->name('admin.users.delete');
});
// Products
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('admin.products');
    Route::post('list', [ProductController::class, 'list'])->name('admin.products.list');
    Route::get('create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::post('update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::post('save', [ProductController::class, 'save'])->name('admin.products.save');
    Route::get('delete/{id?}', [ProductController::class, 'delete'])->name('admin.products.delete');
    Route::post('get-categories', [ProductController::class, 'get_categories'])->name('admin.product.get_categories');
    Route::post('get-sub-categories', [ProductController::class, 'get_sub_categories'])->name('admin.product.get_sub_categories');
    Route::post('get-form-fields', [ProductController::class, 'get_form_fields'])->name('admin.product.get_form_fields');
    Route::post('variants-delete', [ProductController::class, 'variants_delete'])->name('admin.product.variants_delete');
    Route::post('variants-image-delete', [ProductController::class, 'variants_image_delete'])->name('admin.product.variants_image_delete');


    Route::get('variants/{product_id}', [ProductController::class, 'variants'])->name('admin.products.variants');
    Route::get('variants-manage/{product_id}/{id?}', [ProductController::class, 'variants_manage'])->name('admin.products.variants_manage');
    Route::post('variants-save/{id?}', [ProductController::class, 'variants_save'])->name('admin.products.variants_save');
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
    Route::get('delete/{id?}', [FileController::class, 'delete'])->name('admin.files.delete');
    Route::post('share', [FileController::class, 'share'])->name('admin.files.share');
    Route::get('reviews/{id}', [FileController::class, 'reviews'])->name('admin.files.reviews');

});
// settings
Route::prefix('settings')->group(function () {
    Route::get('site-settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('update/{id}', [SettingController::class, 'update'])->name('admin.settings.update');
});

Route::prefix('file-manager')->group(function () {
    Route::get('{parent_id?}', [FileManagerController::class, 'index'])->name('admin.file_manager');
    Route::post('create', [FileManagerController::class, 'create'])->name('admin.file_manager.create');
    Route::get('edit/{id}', [FileManagerController::class, 'edit'])->name('admin.file_manager.edit');
    Route::get('view/{id}', [FileManagerController::class, 'view'])->name('admin.file_manager.view');
    Route::post('file-save/{id}', [FileManagerController::class, 'saveContent'])->name('admin.file_manager.file_save');
    Route::post('rename', [FileManagerController::class, 'rename'])->name('admin.file_manager.rename');
    Route::get('delete/{id?}', [FileManagerController::class, 'delete'])->name('admin.file_manager.delete');

});

// masters
Route::prefix('masters')->group(function () {

    Route::prefix('menus')->group(function () {
        Route::get('/', [MasterController::class, 'menu'])->name('admin.masters.menu');
        Route::post('edit', [MasterController::class, 'menu_edit'])->name('admin.masters.menu_edit');
        Route::post('save', [MasterController::class, 'menu_save'])->name('admin.masters.menu_save');
        Route::get('delete/{id?}', [MasterController::class, 'menu_delete'])->name('admin.masters.menu_delete');
    });

    Route::prefix('brands')->group(function () {
        Route::get('/', [MasterController::class, 'brand'])->name('admin.masters.brand');
        Route::post('edit', [MasterController::class, 'brand_edit'])->name('admin.masters.brand_edit');
        Route::post('save', [MasterController::class, 'brand_save'])->name('admin.masters.brand_save');
        Route::get('delete/{id?}', [MasterController::class, 'brand_delete'])->name('admin.masters.brand_delete');
    });

    Route::prefix('form-fields')->group(function () {
        Route::get('/', [FormFieldController::class, 'index'])->name('admin.form_fields');
        Route::post('list', [FormFieldController::class, 'list'])->name('admin.form_fields.list');
        Route::post('store', [FormFieldController::class, 'store'])->name('admin.form_fields.store');
        Route::post('edit', [FormFieldController::class, 'edit'])->name('admin.form_fields.edit');
        Route::get('delete/{id?}', [FormFieldController::class, 'delete'])->name('admin.form_fields.delete');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.categories');
        Route::post('list', [CategoryController::class, 'list'])->name('admin.categories.list');
        Route::post('store', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::get('edit/{slug?}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::post('update/{slug?}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::get('delete/{slug?}', [CategoryController::class, 'delete'])->name('admin.categories.delete');
    });

    Route::prefix('subcategories')->group(function () {
        Route::get('/', [SubCategoryController::class, 'index'])->name('admin.subcategory');
        Route::post('list', [SubCategoryController::class, 'list'])->name('admin.subcategory.list');
        Route::post('store', [SubCategoryController::class, 'store'])->name('admin.subcategory.store');
        Route::get('create', [SubCategoryController::class, 'create'])->name('admin.subcategory.create');
        Route::get('edit/{slug}', [SubCategoryController::class, 'edit'])->name('admin.subcategory.edit');
        Route::post('update/{slug}', [SubCategoryController::class, 'update'])->name('admin.subcategory.update');
        Route::get('delete/{slug?}', [SubCategoryController::class, 'delete'])->name('admin.subcategory.delete');
        Route::get('items/{slug?}', [SubCategoryController::class, 'items'])->name('admin.subcategory.items');
        Route::get('form-fields/{slug}', [SubCategoryController::class, 'form_fields'])->name('admin.subcategory.form_fields');
        Route::post('form-fields-save', [SubCategoryController::class, 'form_fields_save'])->name('admin.subcategory.form_fields_save');
        Route::get('form_view/{slug}', [SubCategoryController::class, 'form_view'])->name('admin.subcategory.form_view');

    });

    Route::prefix('pages')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('admin.pages');
        Route::post('list', [PageController::class, 'list'])->name('admin.pages.list');
        Route::post('store', [PageController::class, 'store'])->name('admin.pages.store');
        Route::get('create', [PageController::class, 'create'])->name('admin.pages.create');
        Route::get('edit/{slug}', [PageController::class, 'edit'])->name('admin.pages.edit');
        Route::post('update/{slug}', [PageController::class, 'update'])->name('admin.pages.update');
        Route::get('delete/{slug?}', [PageController::class, 'delete'])->name('admin.pages.delete');
    });
});

