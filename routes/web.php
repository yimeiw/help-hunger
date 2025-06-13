<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\RegisterRoleController;
use App\Http\Controllers\RegisterAddressController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VolunteerDashboardController;
use App\Http\Controllers\DonaturDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\ManageEventController;


Route::get('/', function () {
    return redirect()->route('guest.welcome'); // Selalu redirect ke guest.welcome
})->name('home');

// Guest Routes
Route::prefix('guest')->name('guest.')->group(function () { // Mengelompokkan rute guest
    Route::get('/welcome', [GuestController::class, 'indexHome'])->name('welcome');
    Route::get('/about', [GuestController::class, 'indexAbout'])->name('about');
    Route::get('/locations', [GuestController::class, 'indexLocation'])->name('locations.index');
    Route::post('/locations/search', [GuestController::class, 'searchLocation'])->name('locations.search');
    Route::get('/events', [GuestController::class, 'indexEvents'])->name('events');
    Route::get('/donations', [GuestController::class, 'indexDonations'])->name('donations');
    Route::get('/our-partner', [GuestController::class, 'indexPartner'])->name('partner');
});

// Registration Routes
Route::group([], function () { // Mengelompokkan rute registrasi
    Route::get('/register', [RegisterUserController::class, 'index'])->name('register');
    Route::post('/register', [RegisterUserController::class, 'register']); // Nama rute 'register' sudah cukup untuk GET
    Route::get('/register/role', [RegisterRoleController::class, 'index'])->name('register.role');
    Route::post('/register/role', [RegisterRoleController::class, 'registerRole']);
    Route::get('/register/address', [RegisterAddressController::class, 'index'])->name('register.address');
    Route::post('/register/address', [RegisterAddressController::class, 'registerAddress']);
    Route::get('/register/cities/{provinceId}', [RegisterAddressController::class, 'getCities'])->name('getCities');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Rute dashboard umum, mungkin akan mengarahkan ke dashboard spesifik peran
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //reports
    Route::get('/report', [DashboardController::class, 'showReports'])->name('report');

    // Admin
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/location', [AdminDashboardController::class, 'manageLocation'])->name('location');
        Route::get('/report', [AdminDashboardController::class, 'report'])->name('report');
        Route::get('/manage-user', [AdminDashboardController::class, 'manageUser'])->name('manage-user');
        Route::get('/manage-event', [AdminDashboardController::class, 'manageEvent'])->name('manage-event');
        
        Route::prefix('manage')->name('manage.')->group(function () {

            Route::prefix('user')->name('user.')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('admin.manage.user.volunteer');
                })->name('user');

                Route::get('/volunteer', [AdminDashboardController::class, 'manageVolunteer'])->name('volunteer');
                Route::get('/donatur', [AdminDashboardController::class, 'manageDonatur'])->name('donatur');
                Route::get('/partner', [AdminDashboardController::class, 'managePartner'])->name('partner');
    
                Route::delete('/volunteer/{id}', [AdminDashboardController::class, 'deleteVolunteer'])->name('volunteer.delete');
                Route::delete('/donatur/{id}', [AdminDashboardController::class, 'deleteDonatur'])->name('donatur.delete');
                Route::delete('/partner/{id}', [AdminDashboardController::class, 'deletePartner'])->name('partner.delete');

            });

            Route::prefix('event')->name('event.')->group(function () {
                Route::get('/volunteer/add', function () {
                    return view('admin.manage.event.addVolunteer');
                })->name('volunteer.add');

                Route::get('/donatur/add', function () {
                    return view('admin.manage.event.addDonation');
                })->name('donation.add');

                Route::get('/volunteer', [AdminDashboardController::class, 'manageEventVolunteer'])->name('volunteer');
                Route::post('/volunteer', [AdminDashboardController::class, 'storeEventVolunteer'])->name('volunteer.store');
                Route::delete('/volunteer/{id}', [AdminDashboardController::class, 'deleteEventVolunteer'])->name('volunteer.delete');

                Route::get('/donation', [AdminDashboardController::class, 'manageEventDonation'])->name('donation');
                Route::post('/donation', [AdminDashboardController::class, 'storeEventDonation'])->name('donation.store');
                Route::delete('/donation/{id}', [AdminDashboardController::class, 'deleteEventDonation'])->name('donation.delete');
            });
        });

        Route::prefix('location')->name('location.')->group(function () {
            Route::post('/search', [AdminDashboardController::class, 'searchLocation'])->name('search');
        });
    });

    // Volunteer ini yang diubah
    Route::prefix('volunteer')->name('volunteer.')->middleware('role:volunteer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'volunteer'])->name('dashboard');
        Route::get('/about', [VolunteerDashboardController::class, 'about'])->name('about.show');
        Route::get('/events', [VolunteerDashboardController::class, 'events'])->name('events.show'); 
        Route::get('/events/register', [VolunteerDashboardController::class, 'eventsRegister'])->name('events.create');
        Route::get('/events/register/landing', [VolunteerDashboardController::class, 'eventsRegisterLanding'])->name('events.landing');
        Route::post('/events/register/store', [VolunteerDashboardController::class, 'eventsRegisterStore'])->name('events.store');
        Route::get('/locations', [VolunteerDashboardController::class, 'locations'])->name('locations.show');
        Route::post('/locations/search', [VolunteerDashboardController::class, 'searchLocations'])->name('locations.search');
        Route::get('/details', [VolunteerDashboardController::class, 'details'])->name('details.show');
        Route::get('/our-partner', [VolunteerDashboardController::class, 'partner'])->name('partner.show');


    });

    // Donatur
    Route::prefix('donatur')->name('donatur.')->middleware('role:donatur')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'donatur'])->name('dashboard'); 
        Route::get('/donations', [VolunteerDashboardController::class, 'events'])->name('donations.show'); 
    });
});