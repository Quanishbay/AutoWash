<?php


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
use App\Http\Controllers\User\PurchasesHistory;
use App\Http\Controllers\User\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;


Route::apiResource('/services', ServiceController::class)->middleware('jwt.auth');
Route::get('/categories', [CategoryController::class, 'index']);

Route::post('/services', [ServiceController::class, 'store'])->middleware('jwt.auth');
Route::get('/services', [ServiceController::class, 'index'])->middleware('jwt.auth');
Route::put('/services/{service}', [ServiceController::class, 'update'])->middleware('jwt.auth');
Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->middleware('jwt.auth');


Route::apiResource('/carts', CartController::class)->middleware('jwt.auth');

Route::put('/submit', [CartController::class, 'submit']);

Route::prefix('user')->group(function () {
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/', [IndexController::class, 'show'])->middleware('check.admin');
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::get('/history/{user}', [PurchasesHistory::class, 'index'])->middleware('jwt.auth');
Route::get('/filter-with-name', [FilterServices::class, 'filterServices']);

Route::get('/car-washes', [CarWashController::class, 'index']);
Route::get('/get-by-category', [CarWashController::class, 'getByCategory']);

Route::group(['prefix' => 'booking'], function ($router) {
    Route::get('/', [BookingController::class, 'index']);
    Route::get('/user-bookings', [BookingController::class, 'userBookings'])->middleware('jwt.auth');
    Route::post('/create', [BookingController::class, 'create'])->middleware('jwt.auth');
    Route::put('/confirm/{id}', [BookingController::class, 'bookingConfirm'])->middleware('jwt.auth');
    Route::put('/cancel/{id}', [BookingController::class, 'bookingCancel'])->middleware('jwt.auth');
});

Route::post('/create-order', [OrderController::class, 'createOrder']);

Route::get('/car-washes/schedule', [CarWashScheduleController::class, 'scheduleById']);
Route::get('/available-slots/{id}', [CarWashScheduleController::class, 'availableSlots']);
Route::post('/book-slot', [CarWashScheduleController::class, 'bookSlot'])->middleware('jwt.auth');


Route::prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'show'])->middleware('check.admin');
});

