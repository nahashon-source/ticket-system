<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth; // Add this

class AgentDashboardController extends Controller
{
    public function index()
    {
        // Defensive: only proceed if user is authenticated and is agent
        abort_unless(Auth::check(), 403, 'Unauthorized access.');
    
        $agentId = Auth::id();
    
        // Count total assigned tickets
        $ticketCount = Ticket::where('agent_id', $agentId)->count();
    
        // Group counts by status to avoid repetitive queries
        $statusCounts = Ticket::where('agent_id', $agentId)
            ->with('status')
            ->get()
            ->groupBy(fn($ticket) => $ticket->status->name)
            ->map->count();
    
        // Defensive defaults to avoid undefined variables in view
        $openCount   = $statusCounts->get('Open', 0);
        $closedCount = $statusCounts->get('Closed', 0);
    
        // Fetch recent tickets
        $recentTickets = Ticket::where('agent_id', $agentId)
            ->with(['status', 'priority'])
            ->latest()
            ->take(5)
            ->get();
    
        return view('agent.dashboard', compact(
            'ticketCount',
            'openCount',
            'closedCount',
            'recentTickets'
        ));
    }
    
}
