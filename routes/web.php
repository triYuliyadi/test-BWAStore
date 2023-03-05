<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\Admin\ProductGalleryAdminController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name ('home');

Route::get('/categories', [CategoryController::class, 'index'])->name ('categories');
Route::get('/categories/{id}', [CategoryController::class, 'detail'])->name ('categories-detail');

Route::get('/details/{id}', [DetailController::class, 'index'])->name ('detail');
Route::post('/details/{id}', [DetailController::class, 'add'])->name ('detail-add');

Route::get('/success', [CartController::class, 'success'])->name ('success');

// Checkout
Route::post('/checkout/callback', [CheckoutController::class, 'callback'])
    ->name ('midtrans-callback');

Route::get('/register/success', [RegisteredUserController::class, 'success'])->name ('register-success');


Route::middleware('auth')->group(function(){
    Route::get('/cart', [CartController::class, 'index'])->name ('cart');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name ('cart-delete');
    
    Route::post('/checkout', [CheckoutController::class, 'process'])
        ->name ('checkout');

        // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name ('dashboard');
    Route::get('/dashboard/product', [DashboardProductController::class, 'index'])
        ->name ('dashboard-product');
    Route::get('/dashboard/product/create', [DashboardProductController::class, 'create'])
        ->name ('dashboard-product-create');
    Route::post('/dashboard/product', [DashboardProductController::class, 'store'])
        ->name ('dashboard-product-store');
    Route::get('/dashboard/product/{id}', [DashboardProductController::class, 'details'])
        ->name ('dashboard-product-details');
    Route::post('/dashboard/product/{id}', [DashboardProductController::class, 'update'])
        ->name ('dashboard-product-update');
    
    Route::post('/dashboard/product/gallery/upload', [DashboardProductController::class, 'uploadGallery'])
        ->name ('dashboard-product-gallery-upload');
    Route::get('/dashboard/product/gallery/delete/{id}', [DashboardProductController::class, 'deleteGallery'])
        ->name ('dashboard-product-gallery-delete');

    // Transaction
    Route::get('/dashboard/transactions', [DashboardTransactionController::class, 'index'])
        ->name ('dashboard-transactions');
    Route::get('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'details'])
        ->name ('dashboard-transactions-details');
    Route::post('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'update'])
        ->name ('dashboard-transactions-update');

    // Setting & account
    Route::get('/dashboard/setting', [DashboardSettingController::class, 'store'])
        ->name ('dashboard-setting-store');
    Route::get('/dashboard/account', [DashboardSettingController::class, 'account'])
        ->name ('dashboard-setting-account');
        // update untuk fungsi diatas
    Route::post('/dashboard/account/{redirect}', [DashboardSettingController::class, 'update'])
        ->name ('dashboard-setting-redirect');

});

    // menggunakan prefix untuk admin
    Route::prefix('admin')
    ->middleware(['auth','admin'])
    ->namespace('App\Http\Controllers\Admin')
    ->group(function(){
        Route::get('/', [DashboardAdminController::class, 'index'])
            ->name('admin-dashboard');
        Route::resource('category', CategoryAdminController::class);
        Route::resource('user', UserAdminController::class);
        Route::resource('product', ProductAdminController::class);
        Route::resource('product-gallery', ProductGalleryAdminController::class);
    });


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

// Sentry Errorr
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});