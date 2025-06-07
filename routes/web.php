<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\RegisterRoleController;
use App\Http\Controllers\RegisterAddressController;

Route::get('/guest/welcome', [GuestController::class, 'indexHome'])->name('guest.welcome');
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard/dashboard');
    }
    return redirect('/guest/welcome');
});

Route::get('/guest/about', [GuestController::class, 'indexAbout'])->name('guest.about');
Route::get('/guest/locations', [GuestController::class, 'indexLocation'])->name('guest.locations.index');
Route::post('/guest/locations/search', [GuestController::class, 'searchLocation'])->name('guest.locations.search');
Route::get('/guest/events', [GuestController::class, 'indexEvents'])->name('guest.events');
Route::get('/guest/donations', [GuestController::class, 'indexDonations'])->name('guest.donations');
Route::get('/guest/our-partner', [GuestController::class, 'indexPartner'])->name('guest.partner');

// Registration Routes
Route::get('/register', [RegisterUserController::class, 'index'])->name('register');
Route::post('/register', [RegisterUserController::class, 'register'])->name('register');
Route::get('/register/role', [RegisterRoleController::class, 'index'])->name('register.role');
Route::post('/register/role', [RegisterRoleController::class, 'registerRole'])->name('register.role');
Route::get('/register/address', [RegisterAddressController::class, 'index'])->name('register.address');
Route::post('/register/address', [RegisterAddressController::class, 'registerAddress'])->name('register.address');
Route::get('/register/cities/{province}', [RegisterAddressController::class, 'getCities'])->name('getCities');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');
});
