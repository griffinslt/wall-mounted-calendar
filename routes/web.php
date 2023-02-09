<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tablet-view/{room}',[BookingController::class, 'create'])->name('booking.create');
Route::get('submit_issue/{room}/{issue}', [BookingController::class,'reportIssue'])->name('booking.submit-issue');

Route::get('/admin/bookings', [BookingController::class, 'show'])->name('bookings.show');
Route::delete('/admin/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/admin/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::delete('/admin/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');


Route::get('/admin', function () {
    return view('admin.admin');
});

require __DIR__.'/auth.php';
