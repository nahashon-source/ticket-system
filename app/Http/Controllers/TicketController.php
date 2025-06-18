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

        $ticketsQuery = Ticket::query()->applyUserFilter($user)->applyRequestFilters($request);

        // Role-based ticket filtering
        match ($user->role) {
            'user'  => $ticketsQuery->where('user_id', $user->id),
            'agent' => $ticketsQuery->where('assigned_user_id', $user->id),
            default => null,
        };

        // Optional filters

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
        $user = Auth::user();

        
        
        // Only get agents if user is admin
        $users = $user && $user->role === 'admin'
            ? User::where('role', 'agent')->get()
            : collect();
    
        $categories = Category::all();//  ->unique('name');
        $labels     = Label::all();
        $statuses   = Status::all();//->unique('name');
        $priorities = Priority::all();//->unique('name');
        $users = User::all();
    
        return view('tickets.create', compact('users', 'categories', 'labels', 'statuses', 'priorities'));
    }



public function store(Request $request)
{
    \Log::info('Inline validation being used');
    \Log::info('Calling validate on:', ['class' => get_class($request)]);

    $validated = validator($request->all(),[
        'title'             => ['required', 'string', 'max:255'],
        'description'       => ['nullable', 'string'],
        'priority_id'       => ['nullable', 'exists:priorities,id'],
        'status_id'         => ['nullable', 'exists:statuses,id'],
        'assigned_user_id'  => ['nullable', 'exists:users,id'],
        'categories'        => ['nullable', 'array'],
        'categories.*'      => ['exists:categories,id'],
        'labels'            => ['nullable', 'array'],
        'labels.*'          => ['exists:labels,id'],
        'files.*'           => ['file', 'max:2048'],
    ])->validate();

    $ticket = Ticket::create([
        'title'             => $validated['title'],
        'description'       => $validated['description'] ?? 'No description provided',
        'priority_id'       => $validated['priority_id'] ?? Priority::first()->id,
        'status_id'         => $validated['status_id'] ?? Status::first()->id,
        'assigned_user_id'  => $validated['assigned_user_id'] ?? null,
        'user_id'           => Auth::id(),
    ]);

    $ticket->categories()->sync($validated['categories'] ?? []);
    $ticket->labels()->sync($validated['labels'] ?? []);

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

        if (
            ($user->role === 'user'  && $ticket->user_id !== $user->id) ||
            ($user->role === 'agent' && $ticket->assigned_user_id !== $user->id)
        ) {
            abort(403, 'Unauthorized access.');
        }

        $this->authorize('view', $ticket);

        $ticket->load(['labels', 'categories', 'files']);

        return view('tickets.show', compact('ticket'));
    }
    public function filterByStatus($statusId)
{
    $user = Auth::user();

    $statuses   = Status::all();
    $priorities = Priority::all();
    $categories = Category::all();

    $ticketsQuery = Ticket::query()->applyUserFilter($user)->applyRequestFilters(request());

    // Role-based ticket filtering
    match ($user->role) {
        'user'  => $ticketsQuery->where('user_id', $user->id),
        'agent' => $ticketsQuery->where('assigned_user_id', $user->id),
        default => null,
    };

    $tickets = $ticketsQuery->where('status_id', $statusId)->paginate(10);

    return view('tickets.index', compact('tickets', 'statuses', 'priorities', 'categories'));
}

public function filterByPriority($priorityId)
{
    $user = Auth::user();

    $statuses   = Status::all();
    $priorities = Priority::all();
    $categories = Category::all();

    $ticketsQuery = Ticket::query()->applyUserFilter($user)->applyRequestFilters(request());

    match ($user->role) {
        'user'  => $ticketsQuery->where('user_id', $user->id),
        'agent' => $ticketsQuery->where('assigned_user_id', $user->id),
        default => null,
    };

    $tickets = $ticketsQuery->where('priority_id', $priorityId)->paginate(10);

    return view('tickets.index', compact('tickets', 'statuses', 'priorities', 'categories'));
}
}
