<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status_id', 1)->count(); // assuming 1 = Open
        $closedTickets = Ticket::where('status_id', 2)->count(); // assuming 2 = Closed
        $highPriorityTickets = Ticket::where('priority_id', 1)->count(); // assuming 1 = High
        $userCount = User::count();
        $recentTickets = Ticket::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalTickets',
            'openTickets',
            'closedTickets',
            'highPriorityTickets',
            'userCount',
            'recentTickets'
        ));
    }
}
