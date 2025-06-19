<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Status;
use App\Models\Priority;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Dynamically fetch status IDs
        $openStatusId = Status::where('name', 'Open')->value('id');
        $closedStatusId = Status::where('name', 'Closed')->value('id');

        // Dynamically fetch high priority ID
        $highPriorityId = Priority::where('name', 'High')->value('id');

        // Ticket counts
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status_id', $openStatusId)->count();
        $closedTickets = Ticket::where('status_id', $closedStatusId)->count();
        $highPriorityTickets = Ticket::where('priority_id', $highPriorityId)->count();

        // User count
        $userCount = User::count();

        // Recent tickets with eager loading (avoids N+1 issue)
        $recentTickets = Ticket::with(['status', 'priority'])->latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalTickets'        => $totalTickets,
            'openTickets'         => $openTickets,
            'closedTickets'       => $closedTickets,
            'highPriorityTickets' => $highPriorityTickets,
            'userCount'           => $userCount,
            'recentTickets'       => $recentTickets,
            'closedStatusId'      => $closedStatusId   

        ]);
    }
}
