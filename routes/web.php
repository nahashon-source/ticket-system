<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::resource('tickets',TicketController::class);


Route::get('/', function () {
    return view('welcome');

    // Route::get('/tickets/create', [TicketController::class, 'create']);
    // Route::post('/tickets', [TicketController::class, 'store']);
});
