<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\CarWashController;
use App\Http\Controllers\CarWashScheduleController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\DiplomaFillController;
use App\Http\Controllers\FilterServices;
use App\Http\Controllers\Mail\EmailController;
use App\Http\Controllers\Services\ServiceController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\User\PhotoController;
use App\Http\Controllers\User\PurchasesHistory;
use App\Http\Controllers\User\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::prefix('user')->group(function () {
    Route::post('/register', [RegisterController::class, 'store']);
    Route::put('/edit-user', [RegisterController::class, 'editUser'])->name('jwt.auth');
    Route::get('/', [IndexController::class, 'show'])->middleware('jwt.auth');
    Route::post('/upload-photo', [PhotoController::class, 'uploadPhoto'])->middleware('jwt.auth');
    Route::post('/send-welcome-email', [EmailController::class, 'sendWelcomeEmail']);
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});


Route::group(['prefix' => 'car-washes'], function () {
    Route::get('/', [CarWashController::class, 'index']);
    Route::get('/services', [CarWashController::class, 'services']);
    Route::get('/services-by-id', [CarWashController::class, 'index']);
    Route::get('/schedule-by-id', [CarWashScheduleController::class, 'scheduleById']);
    Route::get('/filter-with-name', [FilterServices::class, 'filterServices']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/get-by-category', [CarWashController::class, 'getByCategory']);
    Route::get('/available-slots', [CarWashScheduleController::class, 'availableSlots'])->middleware('jwt.auth');
    Route::post('/book-slot', [CarWashScheduleController::class, 'bookSlot'])->middleware('jwt.auth');
    Route::get('/history', [PurchasesHistory::class, 'index'])->middleware('jwt.auth');
});

Route::group(['prefix' => 'booking'], function ($router) {
    Route::get('/', [BookingController::class, 'index']);
    Route::get('/user-bookings', [BookingController::class, 'userBookings'])->middleware('jwt.auth');
    Route::post('/create', [BookingController::class, 'create'])->middleware('jwt.auth');
    Route::put('/confirm/{id}', [BookingController::class, 'bookingConfirm'])->middleware('jwt.auth');
    Route::put('/cancel/{id}', [BookingController::class, 'bookingCancel'])->middleware('jwt.auth');
    Route::put('/edit', [BookingController::class, 'edit'])->middleware('jwt.auth');
    Route::post('/create-order', [OrderController::class, 'createOrder']);
});

Route::prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'show'])->middleware('check.admin');
    Route::get('/get-washes', [AdminController::class, 'getWashes'])->middleware('check.admin', 'jwt.auth');
    Route::post('/send-promotions', [MailController::class, 'sendPromotions'])->middleware('check.admin', 'jwt.auth');
    Route::get('/export-clients', [ExportController::class, 'exportClients'])->middleware('check.admin', 'jwt.auth');
});

Route::prefix('employee')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/create', [EmployeeController::class, 'create'])->middleware('check.admin', 'jwt.auth');
    Route::put('/update/{id}', [EmployeeController::class, 'update'])->middleware('check.admin', 'jwt.auth');
    Route::delete('/delete/{id}', [EmployeeController::class, 'delete'])->middleware('check.admin', 'jwt.auth');
});




