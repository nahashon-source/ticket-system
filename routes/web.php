<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    TicketController,
    CategoryController,
    PriorityController,
    LabelController,
    CommentController,
    ProfileController,
    DashboardController,
    TestController,
    AdminDashboardController,
    Auth\AuthenticatedSessionController,
    Auth\RegisteredUserController
};

// ====================
// Public (Guest) Routes
// ====================
Route::middleware(['web'])->group(function () {

    // Auth routes are handled in routes/auth.php

    // Root Redirect
    Route::get('/', function () {
        return Auth::check() ? redirect('/dashboard') : redirect('/login');
    });

    // Test / Utility Routes
    Route::get('/test-validator', [TestController::class, 'testValidator']);
});

// ====================
// Authenticated User Routes
// ====================
Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
        Route::get('/priorities', [PriorityController::class, 'priorities'])->name('priorities');
        Route::get('/labels', [LabelController::class, 'labels'])->name('labels');
    });

    Route::resource('comments', CommentController::class)->only(['store', 'destroy']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================
// Admin-only Routes
// ====================
Route::middleware(['web', 'auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('priorities', PriorityController::class);
    Route::resource('labels', LabelController::class);
});

// Include authentication routes
require __DIR__.'/auth.php';
