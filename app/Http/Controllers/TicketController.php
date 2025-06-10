<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;

use App\Models\Label;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'store', 'show', 'create']);
    }

    public function index()
    {
        $user = Auth::user();
        $tickets = Ticket::where('user_id', $user->id)->with(['categories', 'labels', 'priority', 'status'])->latest()->paginate(10);
        return view('tickets.index', compact('tickets'));
    }

    public function create()
{
    $users = User::all(); 
    $categories = Category::all();
    $labels = Label::all();
    return view('tickets.create', compact('users', 'categories', 'labels'));
}

 

public function store(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'priority'    => 'required|in:low,medium,high',
        'status'      => 'required|in:open,in_progress,closed',
        'categories'  => 'nullable|array|exists:categories,id',
        'labels'      => 'nullable|array|exists:labels,id',
        'files.*'     => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ]);

    // Create ticket
    $ticket = Ticket::create([
        'title'       => $validated['title'],
        'description' => $validated['description'],
        'priority'    => $validated['priority'],
        'status'      => $validated['status'],
        'user_id'     => Auth::id(),
    ]);

    // Attach categories and labels if provided
    $ticket->categories()->sync($validated['categories'] ?? []);
    $ticket->labels()->sync($validated['labels'] ?? []);

    // Handle file uploads
    if ($request->hasFile('files')) {
        collect($request->file('files'))->each(function ($file) use ($ticket) {
            $path = $file->store('attachments', 'public');
            $ticket->files()->create(['path' => $path]);
        });
    }

    return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
}


    public function show(Ticket $ticket)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized access to ticket.');
        }

        return view('tickets.show', compact('ticket'));
    }
}
