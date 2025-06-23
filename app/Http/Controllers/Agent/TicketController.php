<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::where('agent_id', Auth::id())->with(['status', 'priority']);

        if ($request->has('status')) {
            $query->whereHas('status', function ($q) use ($request) {
                $q->where('name', $request->status);
            });
        }

        $tickets = $query->latest()->get();

        return view('agent.tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::with(['comments.user', 'status', 'priority', 'user'])->find($id);

        if (!$ticket) {
            abort(404, 'Ticket not found.');
        }

        if (Auth::id() != $ticket->agent_id) {
            abort(403, 'Unauthorized access — this ticket is not assigned to you.');
        }

        return view('agent.tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function filterByStatus($status)
    {
        $agentId = Auth::id();

        $tickets = Ticket::where('agent_id', $agentId)
            ->whereHas('status', function ($q) use ($status) {
                $q->where('name', $status);
            })
            ->with(['status', 'priority'])
            ->get();

        return view('agent.tickets.index', compact('tickets'));
    }
}
