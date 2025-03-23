<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\CarWashController;
use App\Http\Controllers\CarWashScheduleController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\DiplomaFillController;
use App\Http\Controllers\FilterServices;
use App\Http\Controllers\Services\ServiceController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\User\PhotoController;
use App\Http\Controllers\User\PurchasesHistory;
use App\Http\Controllers\User\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;


Route::get('/categories', [CategoryController::class, 'index']);

Route::put('/submit', [CartController::class, 'submit']);

Route::prefix('user')->group(function () {
    Route::post('/register', [RegisterController::class, 'store']);
    Route::put('/edit-user', [RegisterController::class, 'editUser'])->name('jwt.auth');
    Route::get('/', [IndexController::class, 'show'])->middleware('jwt.auth');
    Route::post('/upload-photo', [PhotoController::class, 'uploadPhoto'])->middleware('jwt.auth');
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::get('/history', [PurchasesHistory::class, 'index'])->middleware('jwt.auth');
Route::get('/filter-with-name', [FilterServices::class, 'filterServices']);

Route::group(['prefix' => 'car-washes'], function () {
    Route::get('/', [CarWashController::class, 'index']);
    Route::get('/services-by-id', [CarWashController::class, 'index']);
    Route::get('/schedule-by-id', [CarWashScheduleController::class, 'scheduleById']);

});

Route::get('/get-by-category', [CarWashController::class, 'getByCategory']);

Route::group(['prefix' => 'booking'], function ($router) {
    Route::get('/', [BookingController::class, 'index']);
    Route::get('/user-bookings', [BookingController::class, 'userBookings'])->middleware('jwt.auth');
    Route::post('/create', [BookingController::class, 'create'])->middleware('jwt.auth');
    Route::put('/confirm/{id}', [BookingController::class, 'bookingConfirm'])->middleware('jwt.auth');
    Route::put('/cancel/{id}', [BookingController::class, 'bookingCancel'])->middleware('jwt.auth');
    Route::put('edit', [BookingController::class, 'edit'])->middleware('jwt.auth');
});

Route::post('/create-order', [OrderController::class, 'createOrder']);

Route::get('/available-slots', [CarWashScheduleController::class, 'availableSlots'])->middleware('jwt.auth');
Route::post('/book-slot', [CarWashScheduleController::class, 'bookSlot'])->middleware('jwt.auth');


Route::prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'show'])->middleware('check.admin');
    Route::get('/get-washes', [AdminController::class, 'getWashes'])->middleware('check.admin', 'jwt.auth');
});


