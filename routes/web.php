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
    Auth\RegisteredUserController,
};

// ====================
// Public (Guest) Routes
// ====================
Route::middleware(['web'])->group(function () {
    Route::get('/test-login', function() {
        $credentials = ['email' => 'admin@example.com', 'password' => 'password123'];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return 'Login SUCCESS! User: ' . $user->name . ' (' . $user->email . ') - Role: ' . $user->role;
        } else {
            return 'Login FAILED!';
        }
    });

    Route::get('/simple-login', function() {
        return '
        <form method="POST" action="/simple-login-post">
            <input type="hidden" name="_token" value="' . csrf_token() . '">
            <div><label>Email:</label><br><input type="email" name="email" required></div><br>
            <div><label>Password:</label><br><input type="password" name="password" required></div><br>
            <button type="submit">Login</button>
        </form>
        ';
    });

    Route::post('/simple-login-post', function(\Illuminate\Http\Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return 'Simple Login SUCCESS! User: ' . $user->name . ' (' . $user->email . ') - Role: ' . $user->role;
        } else {
            return 'Simple Login FAILED!';
        }
    });

    Route::get('/debug-auth', function() {
        if (Auth::check()) {
            $user = Auth::user();
            return 'LOGGED IN: ' . $user->name . ' (' . $user->email . ') - Role: ' . $user->role . ' - Is Admin: ' . ($user->isAdmin() ? 'YES' : 'NO');
        } else {
            return 'NOT LOGGED IN';
        }
    });
});

// ====================
// Authenticated User Routes
// ====================
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Ticket Routes
    Route::resource('tickets', TicketController::class);
    Route::get('/tickets/status/{status}', [TicketController::class, 'filterByStatus'])->name('tickets.filter.status');

    // Comments
    Route::resource('comments', CommentController::class)->only(['store', 'destroy']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================
// Admin-only Routes
// ====================
Route::middleware(['web', 'auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin Ticket Management
    Route::resource('tickets', \App\Http\Controllers\Admin\TicketController::class);

    // Ticket actions for admin
    Route::patch('/tickets/{ticket}/close', [\App\Http\Controllers\Admin\TicketController::class, 'close'])->name('tickets.close');
    Route::patch('/tickets/{ticket}/status', [\App\Http\Controllers\Admin\TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::patch('/tickets/{ticket}/assign', [\App\Http\Controllers\Admin\TicketController::class, 'assignAgent'])->name('tickets.assignAgent');

    // High Priority tickets for admin
    Route::get('/tickets/high-priority', [\App\Http\Controllers\Admin\TicketController::class, 'highPriority'])->name('tickets.highPriority');

    // Admin category, priority, label, user management
    Route::resource('categories', CategoryController::class);
    Route::resource('priorities', \App\Http\Controllers\Admin\PriorityController::class);
    Route::resource('labels', LabelController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['create', 'store']);
});

// ====================
// Auth Scaffolding
// ====================
require __DIR__.'/auth.php';
