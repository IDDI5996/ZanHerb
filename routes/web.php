<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ContactController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

//About us
Route::get('/about', function () {
    return view('about');
});

// Promotions page
Route::get('/promotions', [PromotionController::class, 'publicIndex'])->name('promotions.index');

//Services
Route::get('/services', [ServiceController::class, 'publicIndex'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'publicShow'])->name('services.show');

//
Route::prefix('products')->group(function () {
   Route::get('/', [ProductController::class, 'publicIndex'])->name('products.index');
   Route::get('/{product}', [ProductController::class, 'publicShow'])->name('products.show');
 });
 
//Contact us
Route::get('/contact', [ContactController::class, 'show']);
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    // Booking Routes (now reroup(function () {quires login)
    Route::prefix('bookings')->group(function () {
        Route::get('/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/{booking}', [BookingController::class, 'shows'])->name('bookings.shows');
        Route::patch('/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    });
    
    Route::get('/my-bookings', [BookingController::class, 'allUserBookings'])->name('user.bookings.all');
    Route::post('/bookings/{booking}/archive', [BookingController::class, 'archive'])->name('bookings.archive');
    
    // Feedback
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.submit');
    
    //Products
    //Route::get('/products', [ProductController::class, 'publicIndex'])->name('products.index');
    //Route::get('/products/{product}', [ProductController::class, 'publicShow'])->name('products.show');

    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])
        ->middleware('verified')
        ->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified', \App\Http\Middleware\IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        Route::get('bookings', [\App\Http\Controllers\BookingController::class, 'adminIndex'])->name('bookings.index');
        Route::get('bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
        Route::patch('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
        Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancelAdmin'])->name('bookings.cancel');   
        
        Route::resource('products', ProductController::class)->except(['show']);
        
        Route::resource('services', ServiceController::class)->except(['show']);
        
        Route::resource('promotions', PromotionController::class);
        
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        
        Route::get('/feedback', [FeedbackController::class, 'adminIndex'])->name('feedback.index');
        Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
        
        Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)
            ->except(['create', 'store', 'edit', 'update']);
    
        Route::post('contacts/{contact}/respond', [\App\Http\Controllers\Admin\ContactController::class, 'respond'])
            ->name('admin.contacts.respond');
        
        Route::resource('notifications', \App\Http\Controllers\Admin\NotificationController::class)
            ->except(['show']); //We are not using show
        
    });

// Test Routes (can be removed in production)
Route::get('/test-user/{user}', function(User $user) {
    return response()->json([
        'user' => $user,
        'is_active' => $user->is_active
    ]);
});

Route::post('/test-update/{user}', function(Request $request, User $user) {
    $user->update(['is_active' => $request->is_active]);
    return back();
});

require __DIR__.'/auth.php';