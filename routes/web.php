<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
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

Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
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

Route::get('/bookings', [BookingController::class, 'show'])->name('booking.show');
Route::get('/users', [UserController::class, 'index'])->name('users.index');



Route::get('/admin', function () {
    return view('admin');
});

require __DIR__.'/auth.php';
