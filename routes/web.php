<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CruiseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\Admin\AdminCruiseController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminVoyageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\VoyageController;
use App\Http\Controllers\VoyageBookingController;
use App\Http\Controllers\VoyageBookingPaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingCancelController;
use App\Http\Controllers\StripeVoyageWebhookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

Route::view('/', 'welcome');


// Route::get('/test-pdf/{ticket}', function(Ticket $ticket) {
//     return Pdf::loadView('tickets.pdf', compact('ticket'))
//         ->stream('test.pdf');
// });




// Logout Logic
    Route::post('/logout', function() {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect('/');
    })->middleware('auth')->name('logout');

    Route::get('/logout', function() {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->middleware('auth')->name('logout');




// Route::post('/stripe/voyage-webhook', [StripeVoyageWebhookController::class, 'handleWebhook'])
//     ->name('stripe.voyage-webhook');


// Админ-часть
Route::prefix('admin')
    ->middleware(['auth', 'admin', 'verified'])
    ->group(function() {
        Route::redirect('/', '/admin/dashboard');
        


        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');
          
        // Reviews  
        Route::get('/reviews/pending', [ReviewController::class, 'pending'])->name('admin.reviews.pending');
        Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

        // Cruises
        Route::resource('cruises', AdminCruiseController::class)
            ->except('show')
            ->names([
                'index' => 'admin.cruises.index',
                'create' => 'admin.cruises.create',
                'store' => 'admin.cruises.store',
                'edit' => 'admin.cruises.edit',
                'update' => 'admin.cruises.update',
                'destroy' => 'admin.cruises.destroy'
            ]);
        
        // Users
        Route::resource('users', AdminUserController::class)
            ->except(['create', 'store', 'show'])
            ->names([
                'index' => 'admin.users.index',
                'edit' => 'admin.users.edit',
                'update' => 'admin.users.update',
                'destroy' => 'admin.users.destroy'
            ]);
            
        // Bookings (cruises)
        Route::resource('bookings', AdminBookingController::class)
            ->only(['index', 'show', 'destroy'])
            ->names([
                'index' => 'admin.bookings.index',
                'show' => 'admin.bookings.show',
                'destroy' => 'admin.bookings.destroy'
            ]);


        Route::post('bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])
        ->name('admin.bookings.cancel');
        
        // Voayges
        Route::resource('voyages', AdminVoyageController::class)
            ->except('show')
            ->names([
                'index' => 'admin.voyages.index',
                'create' => 'admin.voyages.create',
                'store' => 'admin.voyages.store',
                'edit' => 'admin.voyages.edit',
                'update' => 'admin.voyages.update',
                'destroy' => 'admin.voyages.destroy'
            ]);

        // Voyage Bookings
        Route::resource('voyage-bookings', \App\Http\Controllers\Admin\AdminVoyageBookingController::class)
            ->only(['index', 'show', 'destroy'])
            ->names([
                'index' => 'admin.voyage-bookings.index',
                'show' => 'admin.voyage-bookings.show',
                'destroy' => 'admin.voyage-bookings.destroy'
            ]);

        Route::post('voyage-bookings/{voyageBooking}/cancel', [\App\Http\Controllers\Admin\AdminVoyageBookingController::class, 'cancel'])
            ->name('admin.voyage-bookings.cancel');

        // Vessels
        Route::resource('vessels', \App\Http\Controllers\Admin\AdminVesselController::class)
            ->except('show')
            ->names([
                'index' => 'admin.vessels.index',
                'create' => 'admin.vessels.create',
                'store' => 'admin.vessels.store',
                'edit' => 'admin.vessels.edit',
                'update' => 'admin.vessels.update',
                'destroy' => 'admin.vessels.destroy'
            ]);

        // Ports
        Route::resource('ports', \App\Http\Controllers\Admin\AdminPortController::class)
            ->except('show')
            ->names([
                'index' => 'admin.ports.index',
                'create' => 'admin.ports.create',
                'store' => 'admin.ports.store',
                'edit' => 'admin.ports.edit',
                'update' => 'admin.ports.update',
                'destroy' => 'admin.ports.destroy'
            ]);

        Route::resource('faq', FaqController::class)->except(['show', 'index'])->names([
        'create' => 'admin.faq.create',
        'store' => 'admin.faq.store',
        'edit' => 'admin.faq.edit',
        'update' => 'admin.faq.update',
        'destroy' => 'admin.faq.destroy'

        ]);
        Route::get('/faq', [FaqController::class, 'adminIndex'])->name('admin.faq.index');



        // Analytics
        Route::get('/analytics', [AnalyticsController::class, 'index'])
            ->name('admin.analytics');
    });



    //User's 

    Route::middleware(['auth', 'verified'])->group(function () {


    // Logout Logic
    Route::post('/logout', function() {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect('/');
    })->name('logout');

    Route::get('/logout', function() {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');

    // Main Page
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    //Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::view('/about', 'about')->name('about');

    Route::view('/faq', 'faq')->name('faq');
    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
    
    // Profile
    Route::view('/profile', 'profile')->name('profile');
    Route::get('/profile/bookings', [UserController::class, 'bookings'])->name('profile.bookings');

    // Cruises
    Route::get('/cruises', [CruiseController::class, 'index'])
        ->name('cruises.index');
        
    Route::get('/cruises/{cruise}', [CruiseController::class, 'show'])
        ->name('cruises.show');

    // Bookings
    Route::prefix('booking')->group(function () {
        Route::get('/{cruise}', \App\Livewire\BookingForm::class)
            ->name('booking.form');
            //->middleware('can:book,cruise');
            
        Route::post('/booking/{cruise}/process', [PaymentController::class, 'processCruiseBooking'])
            ->name('booking.process')
            ->middleware('can:book,cruise');
            
        Route::get('/success/{booking}', [BookingController::class, 'success'])
            ->name('booking.success');

        Route::post('/{booking}/cancel', [BookingCancelController::class, '__invoke']) // if b go down + /booking
            ->name('booking.cancel');
    });


    //Tickets

    Route::prefix('tickets')->group(function () {
        Route::get('/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::get('/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');
        Route::post('/{ticket}/check-in', [TicketController::class, 'checkIn'])->name('tickets.check-in');
        Route::get('/verify-form', [TicketController::class, 'verifyForm'])->name('tickets.verify-form');
        Route::post('/verify-check', [TicketController::class, 'verifyCheck'])->name('tickets.verify-check');
        Route::get('/verify/{ticketNumber}', [TicketController::class, 'verify'])->name('tickets.verify');
    });

    // Voyages
    Route::prefix('voyages')->group(function () {
        Route::get('/', [VoyageController::class, 'index'])->name('voyages.index');
        Route::get('/{voyage}', [VoyageController::class, 'show'])->name('voyages.show');
    });

    // Voyage bookings
    Route::prefix('voyage-booking')->group(function () {
        Route::get('/{voyage}', \App\Livewire\VoyageBookingForm::class)
            ->name('voyage-booking.form');

    Route::post('/voyage-booking/{voyage}/process', [PaymentController::class, 'processVoyageBooking'])
        ->name('voyage-booking.process')
        ->middleware('auth');

        Route::get('/success/{booking}', [VoyageBookingController::class, 'success'])
            ->name('voyage-booking.success');
            
        Route::get('/cancel/{booking}', [VoyageBookingController::class, 'cancel'])
            ->name('voyage-booking.cancel');
    });

    //Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::middleware('auth')->group(function () {
        Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    });


    Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])
        ->name('stripe.webhook');
});

require __DIR__.'/auth.php';