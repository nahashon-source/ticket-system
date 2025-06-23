<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Status;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of tickets.
     */
    public function index()
    {
        // Fetch all tickets with related status and agent
        $tickets = Ticket::with(['status', 'agent'])
                         ->latest()
                         ->paginate(10);

        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Show the form to create a new ticket.
     */
    public function create()
    {
        $agents = User::where('role', 'agent')->get();
        return view('admin.tickets.create', compact('agents'));
    }

    /**
     * Store a newly created ticket in the database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            // optionally add validation for priority if needed
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Ticket::create([
            'title'       => $request->title,
            'description' => $request->description,
            'priority_id' => $request->priority_id,
            'status_id'   => 1, // Open by default
            'user_id'     => Auth::id(),
            'agent_id'    => null, // unassigned
        ]);

        return redirect()->route('admin.tickets.index')
                         ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified ticket.
     */
    public function show($id)
    {
        $ticket = Ticket::with(['comments.user', 'status', 'priority'])->findOrFail($id);
        $statuses = Status::all();
        $agents = User::where('role', 'agent')->get();

        return view('admin.tickets.show', compact('ticket', 'statuses', 'agents'));
    }

    /**
     * Show the form to edit a ticket.
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $agents = User::where('role', 'agent')->get();

        return view('admin.tickets.edit', compact('ticket', 'agents'));
    }

    /**
     * Update the specified ticket.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'agent_id'    => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->only('title', 'description', 'agent_id'));

        return redirect()->route('admin.tickets.index')
                         ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified ticket.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('admin.tickets.index')
                         ->with('success', 'Ticket deleted successfully.');
    }

    /**
     * Close a ticket.
     */
    public function close(Ticket $ticket)
    {
        $ticket->update(['status_id' => 2]); // 2 = Closed
        return redirect()->route('admin.tickets.show', $ticket->id)
                         ->with('success', 'Ticket closed successfully.');
    }

    /**
     * Update a ticket's status.
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'status_id' => 'required|exists:statuses,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ticket->update(['status_id' => $request->status_id]);

        return back()->with('success', 'Ticket status updated successfully.');
    }

    /**
     * Display all High Priority tickets.
     */
    public function highPriority()
    {

        // dd('High Priority route works!');

        $highPriority = Priority::where('name', 'High')->first();

        if (!$highPriority) {
            return back()->with('error', 'High priority not defined.');
        }

        $tickets = Ticket::where('priority_id', $highPriority->id)
                         ->with(['status', 'priority'])
                         ->latest()
                         ->paginate(10);

        return view('admin.tickets.high-priority', compact('tickets'));
    }

    /**
     * Filter tickets by status.
     */
    public function filterByStatus($statusId)
    {
        $status = Status::find($statusId);

        if (!$status) {
            return back()->with('error', 'Invalid status selected.');
        }

        $tickets = Ticket::where('status_id', $statusId)
                         ->with(['status', 'priority'])
                         ->latest()
                         ->paginate(10);

        return view('admin.tickets.index', compact('tickets', 'status'));
    }

    /**
     * Assign an agent to a ticket.
     */
    public function assignAgent(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'agent_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($ticket->agent_id == $request->agent_id) {
            return back()->with('info', 'This agent is already assigned.');
        }

        $ticket->update(['agent_id' => $request->agent_id]);

        return redirect()->route('admin.tickets.show', $ticket)
                         ->with('success', 'Agent assigned successfully.');
    }
}
