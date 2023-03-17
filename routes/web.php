<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\TabletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Models\Room;
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


//admin pages
Route::get('/admin', [BookingController::class, 'admin'])->name('name');
Route::get('/admin/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('/admin/rooms/{room}/bookings', [BookingController::class, 'indexForRoom'])->name('bookings.index-for-room');
Route::get('/admin/users/{user}/bookings', [BookingController::class, 'indexForUser'])->name('bookings.index-for-user');
Route::get('/admin/bookings/create/{building}', [BookingController::class, 'create'])->name('bookings.admin.create');
Route::get('/admin/bookings/choose-building', [BookingController::class, 'chooseBuilding'])->name('bookings.admin.chooseBuilding');
Route::post('/admin/bookings/', [BookingController::class, 'store'])->name('admin.bookings.store');
Route::get('/admin/bookings/search-by-filter', [BookingController::class, 'searchByFilter'])->name('admin.search-by-filter');


Route::get('/bookings/{booking}', [BookingController::class, 'edit'])->name('bookings.edit');
Route::post('/admin/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
Route::delete('/admin/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/admin/users/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/admin/users/{user}', [UserController::class, 'update'])->name('users.update');

Route::get('/admin/users/remove-role/{user}/{role}', [UserController::class, 'removeRoleFromUser'])->name('users.removeRoleFromUser');
Route::get('/admin/users/add-role/{user}/{role}', [UserController::class, 'addRoleToUser'])->name('users.addRoleToUser');


Route::post('/admin/rooms/', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/admin/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/admin/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::get('/admin/rooms/{room}', [RoomController::class, 'edit'])->name('rooms.edit');
Route::post('/admin/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');

Route::get('/admin/rooms/add-facility/{room}/{facility}', [RoomController::class, 'addFacilityToRoom'])->name('rooms.add-facility');
Route::get('/admin/rooms/remove-facility/{room}/{facility}', [RoomController::class, 'removeFacilityFromRoom'])->name('rooms.remove-facility');
Route::delete('/admin/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');


Route::get('/admin/permissions', [RoleAndPermissionController::class, 'index'])->name('permissions.index');
Route::get('/admin/permissions/remove-permission-from-role/{role}/{permission}', [RoleAndPermissionController::class, 'removePermissionFromRole'])->name('permissions.remove-permission-from-role');
Route::get('/admin/permissions/role/{role}', [RoleAndPermissionController::class, 'editRole'])->name('permissions.edit-role');
Route::post('/admin/permissions/role/{role}', [RoleAndPermissionController::class, 'updateRole'])->name('permissions.update-role');
Route::post('/admin/permissions/', [RoleAndPermissionController::class, 'store'])->name('permissions.store-role');


Route::get('/admin/permissions/permission/{permission}', [RoleAndPermissionController::class, 'editPermission'])->name('permissions.edit-permission');
Route::post('/admin/permissions/permission/{permission}', [RoleAndPermissionController::class, 'updatePermission'])->name('permissions.update-permission');
Route::get('/admin/permissions/edit-role-permissions/{permission}', [RoleAndPermissionController::class, 'editRolePermissions'])->name('permissions.edit-role-permissions');
Route::get('/admin/permissions/add-permission-to-role/{permission}/{role}', [RoleAndPermissionController::class, 'addPermissionToRole'])->name('permissions.add-permission-to-role');
Route::get('/admin/permissions/create', [RoleAndPermissionController::class, 'create'])->name('admin.create-role');

Route::delete('/admin/permissions/remove-permission/{permission}', [RoleAndPermissionController::class, 'removePermission'])->name('permissions.remove-permission');
Route::delete('/admin/permissions/delete-role/{role}', [RoleAndPermissionController::class, 'removeRole'])->name('permissions.remove-role');


Route::get('/bookings', [BookingController::class, 'indexUserLoggedIn'])->name('index-for-logged-in-user');
Route::get('/bookings/choose-building', [BookingController::class, 'chooseBuildingNormal'])->name('bookings.chooseBuilding');
Route::get('/bookings/create/{building}', [BookingController::class, 'createNormal'])->name('bookings.create');

Route::get('/tablet-view/{room}/',[TabletController::class, 'show'])->name('tablet-view');
Route::get('submit_issue/{room}/{issue}', [TabletController::class,'report'])->name('booking.submit-issue');
Route::get('/tablet-setup', [TabletController::class, 'setup'])->name('tablet-setup');
Route::get('/tablet-setup/set-cookie', [TabletController::class, 'setCookie'])->name('set-cookie');
Route::get('/cookie/get', [TabletController::class, 'getCookie'])->name('get-cookie');

require __DIR__.'/auth.php';
