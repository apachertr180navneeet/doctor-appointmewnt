<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Admin\{
    AdminAuthController,
    PageController,
    ContactController,
    NotificationController,
    AdminUserController,
    DepartmentController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Routes
Route::name('admin.')->prefix('admin')->group(function () {
    // Authentication Routes
    Route::get('/', [AdminAuthController::class, 'index']);
    Route::get('login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('login', [AdminAuthController::class, 'postLogin'])->name('login.post');
    Route::get('forget-password', [AdminAuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [AdminAuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [AdminAuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    // Admin Protected Routes
    Route::middleware(['admin'])->group(function () {
        // Dashboard & Profile Management
        Route::get('dashboard', [AdminAuthController::class, 'adminDashboard'])->name('dashboard');
        Route::get('change-password', [AdminAuthController::class, 'changePassword'])->name('change.password');
        Route::post('update-password', [AdminAuthController::class, 'updatePassword'])->name('update.password');
        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('profile', [AdminAuthController::class, 'adminProfile'])->name('profile');
        Route::post('profile', [AdminAuthController::class, 'updateAdminProfile'])->name('update.profile');

        // User Management Routes
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('all', [AdminUserController::class, 'getallUser'])->name('alluser');
            Route::post('status', [AdminUserController::class, 'userStatus'])->name('status');
            Route::delete('delete/{id}', [AdminUserController::class, 'destroy'])->name('destroy');
            Route::get('{id}', [AdminUserController::class, 'show'])->name('show');
        });

        // Contact Management Routes
        Route::prefix('contacts')->name('contacts.')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('index');
            Route::get('all', [ContactController::class, 'getallcontact'])->name('allcontact');
            Route::delete('delete/{id}', [ContactController::class, 'destroy'])->name('destroy');
        });

        // Page Management Routes
        Route::prefix('page')->name('page.')->group(function () {
            Route::get('create/{key}', [PageController::class, 'create'])->name('create');
            Route::put('update/{key}', [PageController::class, 'update'])->name('update');
        });

        // Notification Management Routes
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('index', [NotificationController::class, 'index'])->name('index');
            Route::get('clear', [NotificationController::class, 'clear'])->name('clear');
            Route::delete('delete/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        });

        // Department Route Routes
        Route::prefix('department')->name('department.')->controller(DepartmentController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('all', 'getallDepartment')->name('alldepartment');
            Route::post('store', 'store')->name('store');
            Route::post('status', 'status')->name('status');
            Route::post('delete', 'delete')->name('delete');
            Route::post('edit', 'edit')->name('edit');
            Route::post('update', 'update')->name('update');
        });
    });
});

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    // Add routes that require user authentication here
});

