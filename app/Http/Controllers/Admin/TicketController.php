<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AssignAgentRequest;
use Illuminate\Support\Facades\Gate;



class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);
        $tickets = Ticket::with(['status', 'agent'])->latest()->get();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $agents = User::where('role', 'agent')->get();
        return view('admin.tickets.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            // 'agent_id'    => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        Ticket::create([
            'title'       => $request->title,
            'description' => $request->description,
            'priority_id' => $request->priority_id,   // if applicable, or set a default
            'status_id'   => 1, // for example, Open
            'user_id'     => Auth::id(), // the creator of the ticket
            'agent_id'    => null, // unassigned initially
        ]);


        return redirect()->route('admin.tickets.index')->with('success', 'Ticket created successfully.');
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        $statuses = Status::all();
        $agents = User::where('role', 'agent')->get();



        return view('admin.tickets.show', compact('ticket', 'statuses', 'agents'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $agents = User::where('role', 'agent')->get();
        return view('admin.tickets.edit', compact('ticket', 'agents'));
    }

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

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    public function close(Ticket $ticket)
    {
        $ticket->update(['status_id' => 2]); // assuming 2 = Closed
        return redirect()->route('admin.tickets.show', $ticket->id)->with('success', 'Ticket closed successfully.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
     {
         if (!Auth::check() || Auth::user()->role !== 'admin') {
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

     public function highPriority()
{
    $highPriority = \App\Models\Priority::where('name', 'High')->first();

    if (!$highPriority) {
        return back()->with('error', 'High priority not defined.');
    }

    $tickets = Ticket::where('priority_id', $highPriority->id)
                     ->latest()
                     ->paginate(10);

    return view('admin.tickets.high-priority', compact('tickets'));
}

public function filterByStatus($statusId)
{
    // Validate that the status exists first to avoid invalid queries
    $status = Status::find($statusId);

    if (!$status) {
        return back()->with('error', 'Invalid status selected.');
    }

    // Fetch tickets with the given status, eager-load status and priority
    $tickets = Ticket::where('status_id', $statusId)
                     ->with(['status', 'priority'])
                     ->latest()
                     ->paginate(10);

    return view('admin.tickets.index', compact('tickets', 'status'));
}


  

public function assignAgent(Request $request, Ticket $ticket)
{
    // 1. Authorization
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    // 2. Validate input
    $validator = Validator::make($request->all(), [
        'agent_id' => 'nullable|exists:users,id',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // 3. If already the same agent, inform
    if ($ticket->agent_id == $request->agent_id) {
        return back()->with('info', 'This agent is already assigned.');
    }

    // 4. Update the agent assignment
    $ticket->update([
        'agent_id' => $request->agent_id]);

    // 5. Redirect back to show with success
    return redirect()
        ->route('admin.tickets.show', $ticket)
        ->with('success', 'Agent assigned successfully.');
}


}
