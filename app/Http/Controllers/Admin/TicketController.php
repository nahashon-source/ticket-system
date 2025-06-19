<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);
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
            'agent_id'    => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Ticket::create($request->only('title', 'description', 'agent_id'));

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket created successfully.');
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        $statuses = Status::all();


        return view('admin.tickets.show', compact('ticket', 'statuses'));
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

  


}
