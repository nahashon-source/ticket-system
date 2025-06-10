<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Ticket, Category, User, Status, Priority, Label};
use App\Http\Requests\StoreTicketRequest;



class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'store', 'show', 'create']);
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $statuses   = Status::all();
        $priorities = Priority::all();
        $categories = Category::all();

        $ticketsQuery = Ticket::with(['priority', 'status', 'categories']);

        // Role-based ticket filtering
        match ($user->role) {
            'user'  => $ticketsQuery->where('created_by', $user->id),
            'agent' => $ticketsQuery->where('assigned_user_id', $user->id),
            default => null,
        };

        // Apply optional filters
        $ticketsQuery->when($request->filled('status'), fn ($q) =>
            $q->where('status_id', $request->status)
        )->when($request->filled('priority'), fn ($q) =>
            $q->where('priority_id', $request->priority)
        )->when($request->filled('category'), fn ($q) =>
            $q->whereHas('categories', fn ($q) => $q->where('category_id', $request->category))
        );

        $tickets = $ticketsQuery->paginate(10);

        return view('tickets.index', compact('tickets', 'statuses', 'priorities', 'categories'));
    }

    public function create()
    {
        $users      = User::where('role', 'agent')->get();
        $categories = Category::all();
        $labels     = Label::all();
        $users = User::all();
        $statuses   = Status::all();
        $priorities = Priority::all();

        return view('tickets.create', compact('users', 'categories', 'labels', 'statuses', 'priorities'));
    }

    public function store(StoreTicketRequest $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'priority_id'       => 'required|exists:priorities,id',
            'status_id'         => 'required|exists:statuses,id',
            'categories'        => 'nullable|array',
            'categories.*'      => 'exists:categories,id',
            'labels'            => 'nullable|array',
            'labels.*'          => 'exists:labels,id',
            'assigned_user_id'  => 'nullable|exists:users,id',
            'files.*'           => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $ticket = Ticket::create([
            'title'             => $validated['title'],
            'description'       => $validated['description'],
            'priority_id'       => $validated['priority_id'],
            'status_id'         => $validated['status_id'],
            'assigned_user_id'  => $validated['assigned_user_id'] ?? null,
            'created_by'        => Auth::id(),
        ]);

        $ticket->categories()->sync($validated['categories'] ?? []);
        $ticket->labels()->sync($validated['labels'] ?? []);

        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('attachments', 'public');
                $ticket->files()->create(['path' => $path]);
            }
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
    }

    public function show(Ticket $ticket)
    {
        $user = Auth::user();

        // Role-based authorization
        if (
            ($user->role === 'user'  && $ticket->created_by !== $user->id) ||
            ($user->role === 'agent' && $ticket->assigned_user_id !== $user->id)
        ) {
            abort(403, 'Unauthorized access.');
        }

    $this->authorize('view', $ticket);

    $ticket->load(['labels', 'categories', 'files']);


        return view('tickets.show', compact('ticket'));
    }
}
