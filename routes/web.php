<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Route::get('dashboard', [LoginController::class, 'dashboard']); 
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('custom-login', [LoginController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [LoginController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [LoginController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [LoginController::class, 'signOut'])->name('signout');

Route::get('user',[UserController::class,'index'])->name('user.index');
Route::post('/update-status/{id}', [UserController::class, 'updateStatus'])->name('update.status');
Route::post('/filter-user', [UserController::class, 'filterdata'])->name('filter-user');

Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');
Route::get('notifications/{id}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
Route::put('notifications/{id}', [NotificationController::class, 'update'])->name('notifications.update');
Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
Route::post('/update-notification/{id}', [NotificationController::class, 'updateStatus'])->name('update.notification.status');