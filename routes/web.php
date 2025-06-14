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
    TestController
};

// Include authentication routes
require __DIR__.'/auth.php';

// Root route - redirect to appropriate dashboard
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

// Authenticated users routes
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User-only ticket routes
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    // User-only category viewing (no manage rights)
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
        Route::get('/priorities', [PriorityController::class, 'priorities'])->name('priorities');
        Route::get('/labels', [LabelController::class, 'labels'])->name('labels');
    });

    // Comments (resource-based)
    Route::resource('comments', CommentController::class)->only(['store', 'destroy']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-only routes
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('priorities', PriorityController::class);

});


// Validator test route (accessible to all for now — can wrap in 'auth' if needed)
Route::get('/test-validator', [TestController::class, 'testValidator']);
// Route::get('/test', function () {
//     return view('test');
// });
// Route::patch('/test', function () {
//     return 'PATCH received';
// })->name('test.patch');
