<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\RegisterRoleController;
use App\Http\Controllers\RegisterAddressController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VolunteerDashboardController;
use App\Http\Controllers\DonaturDashboardController;


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
        Route::get('/location', [DashboardController::class, 'location'])->name('location');
        Route::get('/report', [DashboardController::class, 'report'])->name('report');
        Route::get('/manage', [DashboardController::class, 'manage'])->name('manage');
        Route::get('/manage/manage-user', [DashboardController::class, 'manageUser'])->name('manage.user');
        Route::get('/manage/manage-event', [DashboardController::class, 'manageEvent'])->name('manage.event');
        // User: volunteer, donatur, partner
        Route::get('/manage/manage-user/volunteer', [AdminController::class, 'manageVolunteer'])->name('manage.user.volunteer');
        Route::get('/manage/manage-user/donatur', [AdminController::class, 'manageDonatur'])->name('manage.user.donatur');
        Route::get('/manage/manage-user/partner', [AdminController::class, 'managePartner'])->name('manage.user.partner');

        // Event: volunteer, donation
        Route::get('/manage/manage-event/volunteer', [AdminController::class, 'manageEventVolunteer'])->name('manage.event.volunteer');
        Route::get('/manage/manage-event/donation', [AdminController::class, 'manageEventDonation'])->name('manage.event.donation');

        Route::delete('/manage/manage-user/volunteer/{id}', [AdminController::class, 'deleteVolunteer'])->name('manage.user.volunteer.delete');
        Route::delete('/manage/manage-user/donatur/{id}', [AdminController::class, 'deleteDonatur'])->name('manage.user.donatur.delete');
        Route::delete('/manage/manage-user/partner/{id}', [AdminController::class, 'deleteVolunteer'])->name('manage.user.partner.delete');

        Route::post('/manage/manage-event/volunteer', [AdminController::class, 'storeEventVolunteer'])->name('manage.event.volunteer.store');
        Route::delete('/manage/manage-event/volunteer/{id}', [AdminController::class, 'deleteEventVolunteer'])->name('manage.event.volunteer.delete');
        Route::post('/manage/manage-event/donation', [AdminController::class, 'storeEventDonation'])->name('manage.event.donation.store');
        Route::delete('/manage/manage-event/donation/{id}', [AdminController::class, 'deleteEventDonation'])->name('manage.event.donation.delete');

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