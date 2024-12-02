<?php

use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\DiamondController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlansController;
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

Route::get("/", function () {
    return view('website.index');
})->name('home');
Route::get('/privacy-policy', function () {
    return view('website.privacy');
})->name('website.privacy');
Route::get('terms-of-service', function () {
    return view('website.terms');
})->name('website.terms');

Route::prefix("admin")->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('login');
    Route::get('registration', [LoginController::class, 'registration'])->name('register-user');
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        // Route::get('dashboard', [LoginController::class, 'dashboard']); 
        Route::post('custom-login', [LoginController::class, 'customLogin'])->name('login.custom');
        Route::post('custom-registration', [LoginController::class, 'customRegistration'])->name('register.custom');
        Route::get('signout', [LoginController::class, 'signOut'])->name('signout');

        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::post('/update-status/{id}', [UserController::class, 'updateStatus'])->name('update.status');
        Route::post('/filter-user', [UserController::class, 'filterdata'])->name('filter-user');

        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');
        Route::get('notifications/{id}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
        Route::put('notifications/{id}', [NotificationController::class, 'update'])->name('notifications.update');
        Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::post('/update-notification/{id}', [NotificationController::class, 'updateStatus'])->name('update.notification.status');



        //Plans and pricing
        Route::get('plans', [PlansController::class, 'index'])->name('plans.index');
        Route::post('plans', [PlansController::class, 'store'])->name('plans.store');
        Route::get('plans/{id}/edit', [PlansController::class, 'edit'])->name('plans.edit');
        Route::put('plans/{id}', [PlansController::class, 'update'])->name('plans.update');
        Route::delete('plans/{id}', [PlansController::class, 'destroy'])->name('plans.destroy');
        Route::post('/update-plans/{id}', [PlansController::class, 'updateStatus'])->name('update.plans.status');


        //Diamonds
        Route::get('diamonds', [DiamondController::class, 'index'])->name('diamonds.index');
        Route::post('diamonds', [DiamondController::class, 'store'])->name('diamonds.store');
        Route::get('diamonds/{id}/edit', [DiamondController::class, 'edit'])->name('diamonds.edit');
        Route::put('diamonds/{id}', [DiamondController::class, 'update'])->name('diamonds.update');
        Route::delete('diamonds/{id}', [DiamondController::class, 'destroy'])->name('diamonds.destroy');
        Route::post('/update-diamonds/{id}', [DiamondController::class, 'updateStatus'])->name('update.diamonds.status');



        Route::get('chat', [MessageController::class, 'showChatRoom']);
    });
    // Route::post('/update-plan/{id}', [UserController::class, 'updatePlan'])->name('update.plan.status');
});
