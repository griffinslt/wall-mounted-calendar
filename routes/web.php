<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleAndPermissionController;
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

Route::get('/admin/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('/admin/rooms/{room}/bookings', [BookingController::class, 'indexForRoom'])->name('bookings.index-for-room');
Route::get('/admin/users/{user}/bookings', [BookingController::class, 'indexForUser'])->name('bookings.index-for-user');


Route::get('/admin/bookings/{booking}', [BookingController::class, 'edit'])->name('bookings.edit');
Route::post('/admin/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
Route::delete('/admin/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/admin/users/{user}', [UserController::class, 'edit'])->name('users.edit');

Route::get('/admin/users/remove-role/{user}/{role}', [UserController::class, 'removeRoleFromUser'])->name('users.removeRoleFromUser');
Route::get('/admin/users/add-role/{user}/{role}', [UserController::class, 'addRoleToUser'])->name('users.addRoleToUser');



Route::get('/admin/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/admin/rooms/{room}', [RoomController::class, 'edit'])->name('rooms.edit');
Route::post('/admin/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::get('/admin/rooms/add-facility/{room}/{facility}', [RoomController::class, 'addFacilityToRoom'])->name('rooms.add-facility');
Route::get('/admin/rooms/remove-facility/{room}/{facility}', [RoomController::class, 'removeFacilityFromRoom'])->name('rooms.remove-facility');
Route::delete('/admin/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');


Route::get('/admin/permissions', [RoleAndPermissionController::class, 'index'])->name('permissions.index');
Route::get('/admin/permissions/remove-permission-from-role/{role}/{permission}', [RoleAndPermissionController::class, 'removePermissionFromRole'])->name('permissions.remove-permission-from-role');


Route::get('/admin', function () {
    return view('admin.admin');
});

require __DIR__.'/auth.php';
