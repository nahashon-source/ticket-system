<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketLog;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin.dashboard'); // or whatever view you plan to load
    }

    public function dashboard()
{
    $totalTickets = Ticket::count();
    $openTickets = Ticket::whereHas('status', function($q){
        $q->where('name', 'Open');
    })->count();

    $closedTickets = Ticket::whereHas('status', function($q){
        $q->where('name', 'Closed');
    })->count();

    $inProgressTickets = Ticket::whereHas('status', function($q){
        $q->where('name', 'In Progress');
    })->count();

    return view('admin.dashboard', compact(
        'totalTickets',
        'openTickets',
        'closedTickets',
        'inProgressTickets'
    ));
    
}
     public function logs()
     {
        $logs = TicketLog::with(['ticket','user'])->latest()->paginate(20);
        return view('admin.logs', compact('logs'));
     }


    
}
