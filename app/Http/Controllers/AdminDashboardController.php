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
     * Display the admin dashboard with aggregated ticket and user stats.
     */
    public function index()
    {
        // Dynamically fetch status IDs to avoid hardcoded magic numbers
        $openStatusId   = Status::where('name', 'Open')->value('id');
        $closedStatusId = Status::where('name', 'Closed')->value('id');

        // Dynamically fetch 'High' priority ID
        $highPriorityId = Priority::where('name', 'High')->value('id');

        // Ticket counts
        $totalTickets        = Ticket::count();
        $openTickets         = Ticket::where('status_id', $openStatusId)->count();
        $closedTickets       = Ticket::where('status_id', $closedStatusId)->count();
        $highPriorityTickets = Ticket::where('priority_id', $highPriorityId)->count();

        // Registered users count
        $userCount = User::count();

        // Recent tickets (latest 5), eager loading related status and priority to avoid N+1 issues
        $recentTickets = Ticket::with(['status', 'priority'])
            ->latest()
            ->take(5)
            ->get();

        // Pass the data compactly to the view
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
