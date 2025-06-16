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
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\RegisterPartnerController;
use App\Http\Controllers\LoginPartnerController; 
use App\Http\Controllers\PartnerController; 
use App\Http\Controllers\Rule;

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

Route::prefix('partner')->name('partner.')->group(function () { // <-- Tambah titik (.) di name()
    // Login Routes
    Route::get('/login', [LoginPartnerController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginPartnerController::class, 'login'])->name('login.attempt');
    Route::post('/partner/logout', [LoginPartnerController::class, 'logout'])->name('logout');

    // Registration Routes for Partner
    // Perhatikan: Anda sudah di dalam prefix 'partner', jadi '/register/partner' akan menjadi '/partner/register/partner'.
    // Cukup gunakan '/register' di sini.
    Route::get('/register', [RegisterPartnerController::class, 'create'])->name('register'); // Asumsi method 'create' untuk menampilkan form
    Route::post('/register', [RegisterPartnerController::class, 'store'])->name('register.store'); // Asumsi method 'store' untuk memproses registrasi

    // Dashboard Route for Partner
    // Pastikan ini dilindungi oleh middleware 'auth:partner'
    Route::middleware('auth:partner')->group(function () {
        // Karena sudah di prefix 'partner', cukup '/dashboard'
        Route::get('/dashboard', [PartnerController::class, 'index'])->name('dashboard');
        Route::get('/about', [PartnerController::class, 'about'])->name('about.show');
        Route::get('/locations', [PartnerController::class, 'locations'])->name('locations.show');
        Route::post('/locations/search', [PartnerController::class, 'searchLocation'])->name('locations.search');

        // Program
        Route::get('/program', [PartnerController::class, 'program'])->name('program.show');

        Route::get('/program/volunteer/add', [PartnerController::class, 'createVolunteerEvent'])->name('program.volunteer.add');
        Route::post('/program/volunteer/store', [PartnerController::class, 'storeVolunteerEvent'])->name('program.volunteer.store');
        Route::get('/program/volunteer/{event}', [PartnerController::class, 'showVolunteerEvent'])->name('program.volunteer.show');
        Route::delete('/program/volunteer/{event}', [PartnerController::class, 'deleteVolunteerEvent'])->name('program.volunteer.delete');

        // Rute untuk Event Donasi
        Route::get('/program/donation/add', [PartnerController::class, 'createDonationEvent'])->name('program.donation.add');
        Route::post('/program/donation/store', [PartnerController::class, 'storeDonationEvent'])->name('program.donation.store');
        Route::get('/program/donation/{event}', [PartnerController::class, 'showDonationEvent'])->name('program.donation.show');
        Route::delete('/program/donation/{event}', [PartnerController::class, 'deleteDonationEvent'])->name('program.donation.delete');

        // API Route for fetching cities
        Route::get('/get-cities/{provinceId}', [PartnerController::class, 'getCitiesByProvince'])->name('get.cities');



        Route::get('/report', [PartnerController::class, 'report'])->name('report.show');
        Route::get('/notifications', [PartnerController::class, 'notifications'])->name('notifications.show');
        Route::get('/profile', [PartnerController::class, 'profile'])->name('profile.show');
        Route::post('/partner/profile', [PartnerController::class, 'update'])->name('profile.update');
    });

});


// Registration Routes
Route::group([], function () { // Mengelompokkan rute registrasi
    Route::get('/register', [RegisterUserController::class, 'index'])->name('register');
    Route::post('/register', [RegisterUserController::class, 'register']);
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
    Route::get('/certificate/download/{eventType}/{eventId}', [CertificateController::class, 'downloadCertificate'])->name('certifications.download');

    // Admin
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/location', [AdminDashboardController::class, 'manageLocation'])->name('location');
        Route::get('/report', [AdminDashboardController::class, 'report'])->name('report');
        Route::get('/manage-user', [AdminDashboardController::class, 'manageUser'])->name('manage-user');
        Route::get('/manage-event', [AdminDashboardController::class, 'manageEvent'])->name('manage-event');
        
        Route::get('/dashboard', [AdminDashboardController::class, 'manageEventsApproval'])->name('dashboard');
        Route::post('/events-approval/{type}/{id}/approve', [AdminDashboardController::class, 'approveEvent'])->name('approve.event');
        Route::post('/events-approval/{type}/{id}/decline', [AdminDashboardController::class, 'declineEvent'])->name('decline.event');

        Route::get('/notification', [AdminDashboardController::class, 'showNotifications'])->name('notification');
        Route::post('/notification/{id}/mark-read', [AdminDashboardController::class, 'markNotificationAsRead'])->name('notification.mark-read');

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
                
                Route::get('/volunteer', [AdminDashboardController::class, 'manageEventVolunteer'])->name('volunteer');
                Route::get('/donatur', [AdminDashboardController::class, 'manageEventDonation'])->name('donation');
                Route::get('/donatur/add', function () {
                    return view('admin.manage.event.addDonation');
                })->name('donation.add');

                Route::get('/volunteer/add', [AdminDashboardController::class, 'createVolunteerEvent'])->name('volunteer.add');
                Route::post('/volunteer/add', [AdminDashboardController::class, 'storeEventVolunteer'])->name('volunteer.add');
                Route::delete('/volunteer/{id}', [AdminDashboardController::class, 'deleteEventVolunteer'])->name('volunteer.delete');

                Route::get('/donatur/add', [AdminDashboardController::class, 'createDonationEvent'])->name('donation.add');
                Route::post('/donatur/add', [AdminDashboardController::class, 'storeEventDonation'])->name('donation.add');
                Route::delete('/donation/{id}', [AdminDashboardController::class, 'deleteEventDonation'])->name('donation.delete');
            });
        });

        Route::prefix('location')->name('location.')->group(function () {
            Route::post('/store', [AdminDashboardController::class, 'storeLocation'])->name('store');
            Route::delete('/delete/{id}', [AdminDashboardController::class, 'deleteLocation'])->name('delete');
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
        Route::get('/details/events', [VolunteerDashboardController::class, 'detailsEvents'])->name('details.details');
        Route::delete('/volunteer/cancel-participation/{event}', [VolunteerDashboardController::class, 'cancelParticipation'])->name('cancel_participation');
        Route::get('/our-partner', [VolunteerDashboardController::class, 'partner'])->name('partner.show');
        Route::get('/notification', [VolunteerDashboardController::class, 'notifications'])->name('notification.show');
        Route::post('/volunteer/logout-to-register', function (Request $request) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('register');
        })->name('volunteer.logout.to.register');
    });

    Route::get('/volunteer/certificate/download', [VolunteerDashboardController::class, 'downloadCertificate'])
    ->name('volunteer.certifications.download')
    ->middleware(['auth', 'verified', 'check.role:volunteer']);

    Route::get('/donatur/certificate/download', [DonaturDashboardController::class, 'downloadCertificate'])
    ->name('donatur.certifications.download')
    ->middleware(['auth', 'verified', 'check.role:donatur']);

    // Donatur
    Route::prefix('donatur')->name('donatur.')->middleware('role:donatur')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'donatur'])->name('dashboard'); 
        Route::get('/about', [DonaturDashboardController::class, 'about'])->name('about.show');
        Route::get('/locations', [DonaturDashboardController::class, 'locations'])->name('locations.show');
        Route::get('/donations', [DonaturDashboardController::class, 'donations'])->name('donations.show');
        Route::post('/locations/search', [DonaturDashboardController::class, 'searchLocations'])->name('locations.search');

        // Donations
        Route::get('/donations/register', [DonaturDashboardController::class, 'donationsRegister'])->name('donations.create');
        Route::post('/donations/register/store', [DonaturDashboardController::class, 'donationsRegisterStore'])->name('donations.store');
        Route::get('/donations/register/landing', [DonaturDashboardController::class, 'donationsRegisterLanding'])->name('donations.landing');
        Route::get('/donations/{donation_id}/confirmation', [DonaturDashboardController::class, 'showDonationConfirmation'])->name('donations.confirm');
        Route::post('/donation/{donation_id}/upload-proof', [DonaturDashboardController::class, 'uploadPaymentProof'])->name('donations.upload-proof');

        // Details Donations
        Route::get('/details', [DonaturDashboardController::class, 'details'])->name('details.show');
        Route::get('/details/events', [DonaturDashboardController::class, 'detailsEvents'])->name('details.details');
        Route::delete('/cancel-participation/{event}', [DonaturDashboardController::class, 'cancelParticipation'])->name('cancel_participation');
        Route::get('/our-partner', [DonaturDashboardController::class, 'partner'])->name('partner.show');
        Route::get('/notification', [DonaturDashboardController::class, 'notifications'])->name('notification.show');
    });
});