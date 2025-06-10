<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController, TicketController, AdminController,
    CategoryController, PriorityController, LabelController,
    DashboardController, UserController, LogController
};

// Public Route
Route::view('/', 'welcome')->name('home');

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {

    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Ticket Resource (only: index, create, store, show)
    Route::resource('tickets', TicketController::class)->except(['edit', 'update', 'destroy']);

    // User-specific management pages
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/priorities', [PriorityController::class, 'index'])->name('priorities.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});

// Admin-only Routes (role:admin middleware)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

// Admin Dashboard & Resource Management (is_admin middleware)
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Resource Controllers
    Route::resources([
        'categories' => CategoryController::class,
        'priorities' => PriorityController::class,
        'labels'     => LabelController::class,
    ]);
});

// Auth scaffolding routes (Fortify, Breeze, Jetstream, etc.)
require __DIR__ . '/auth.php';
