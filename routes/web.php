<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Admin\{
    AdminAuthController,
    PageController,
    ContactController,
    NotificationController,
    AdminUserController,
    DepartmentController,
    EducationController,
    RoleController,
    DoctorController,
    AppointmentController
};

use App\Http\Controllers\Doctor\{
    AuthController,
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
    Route::get('register', [AdminAuthController::class, 'registration'])->name('register');
    Route::post('register', [AdminAuthController::class, 'postRegistration'])->name('register.post');
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


        // Education Route Routes
        Route::prefix('education')->name('education.')->controller(EducationController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('all', 'getallList')->name('alllist');
            Route::post('store', 'store')->name('store');
            Route::post('status', 'status')->name('status');
            Route::post('delete', 'delete')->name('delete');
            Route::post('edit', 'edit')->name('edit');
            Route::post('update', 'update')->name('update');
        });

        // role Route Routes
        Route::prefix('role')->name('role.')->controller(RoleController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('all', 'getallList')->name('alllist');
            Route::post('store', 'store')->name('store');
            Route::post('status', 'status')->name('status');
            Route::post('delete', 'delete')->name('delete');
            Route::post('edit', 'edit')->name('edit');
            Route::post('update', 'update')->name('update');
        });

         // doctor Route Routes
         Route::prefix('doctor')->name('doctor.')->controller(DoctorController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('all', 'getallList')->name('alllist');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::post('status', 'status')->name('status');
            Route::post('delete', 'delete')->name('delete');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update', 'update')->name('update');
            Route::post('update', 'update')->name('update');
            Route::get('show/{id}', 'show')->name('show');
        });

        // Appointment Route Routes
        Route::prefix('appointment')->name('appointment.')->controller(AppointmentController::class)->group(function () {
            Route::get('/{id}', 'index')->name('index');
            Route::get('create/{id}', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::post('delete', 'delete')->name('delete');
            Route::get('show/{id}', 'show')->name('show');
            Route::post('check', 'check')->name('check');
            Route::post('update/time', 'updateTime')->name('update.time');
        });
    });
});




// Doctor Routes
Route::name('doctor.')->prefix('doctor')->group(function () {

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'postRegistration'])->name('register.post');
    Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');


    // Authenticated User Routes
    Route::middleware(['auth'])->group(function () {
        // Add routes that require user authentication here
        Route::get('dashboard', [AuthController::class, 'doctorDashoard'])->name('dashboard');
        Route::get('change-password', [AuthController::class, 'changePassword'])->name('change.password');
        Route::post('update-password', [AuthController::class, 'updatePassword'])->name('update.password');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('profile', [AuthController::class, 'adminProfile'])->name('profile');
        Route::post('profile', [AuthController::class, 'updateAdminProfile'])->name('update.profile');
    });
});

