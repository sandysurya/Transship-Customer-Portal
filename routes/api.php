<?php

use App\Http\Controllers\CheckSessionController;
use App\Http\Controllers\EditUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ShipmentAdminController;
use App\Http\Controllers\UserAdminController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::any('/shipment/userdashboard', ShipmentController::class)->name('shipment-userdashboard');
Route::post('/users/register', RegisterController::class)->name('register');
Route::post('/users/login', LoginController::class)->name('login');
Route::post('/users/logout', LogoutController::class)->name('logout');
Route::post('/users/checkSession', CheckSessionController::class)->name('check-session');
Route::any('/users/edit', EditUserController::class)->name('edit-user');
Route::any('/shipment/add', ShipmentController::class)->name('shipment');
Route::any('/shipment/list', ShipmentController::class)->name('shipment-list');

//Admin
Route::any('/shipment/dashboard', ShipmentAdminController::class)->name('shipment-dashboard');
Route::any('/shipment/listall', ShipmentAdminController::class)->name('shipment-listall');
Route::any('/customers/listall', UserAdminController::class)->name('customers-listall');
Route::any('/users/listall', UserAdminController::class)->name('users-listall');
Route::any('/customers/add', UserAdminController::class)->name('customers-add');
Route::any('/customers/doc', UserAdminController::class)->name('customers-doc');
Route::any('/customers/edit', UserAdminController::class)->name('customers-edit');
Route::any('/users/edits', UserAdminController::class)->name('users-edits');
Route::any('/users/add', UserAdminController::class)->name('users-add');
Route::any('/shipment/tracking', ShipmentAdminController::class)->name('shipment-tracking');



Route::middleware(['auth:api'])->group(function () {
    //
});
