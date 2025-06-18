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
            return 'Simple Login FAILED! Email: ' . $request->email . ' Password Length: ' . strlen($request->password);
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

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/tickets/status/{statusId}', [TicketController::class, 'filterByStatus'])->name('tickets.filter.status');
    Route::get('/tickets/priority/{priorityId}', [TicketController::class, 'filterByPriority'])->name('tickets.filter.priority');

    // 🔽 NEW Routes you wanted
    Route::get('/tickets/status/{status}', [TicketController::class, 'filterByStatus'])->name('tickets.status');
    Route::get('/tickets/priority/high', [TicketController::class, 'highPriority'])->name('tickets.high');

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
    Route::resource('priorities', \App\Http\Controllers\Admin\PriorityController::class);
    Route::resource('labels', LabelController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['create', 'store']);
});

// ====================
// Auth Scaffolding
// ====================
require __DIR__.'/auth.php';
