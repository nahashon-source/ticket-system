<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Label;
use App\Models\File;
use App\Models\User;

class TicketController extends Controller
{
    public function create()
    {
        $categories = Category::select('id', 'name')->distinct()->orderBy('name')->get();
        $labels = Label::select('id', 'name')->distinct()->orderBy('name')->get();
        $users = User::select('id', 'name')->orderBy('name')->get();
    
        return view('tickets.create', compact('categories', 'labels', 'users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'priority'    => 'required|in:low,medium,high',
            'status'      => 'required|in:open,in_progress,closed',
            'user_id'     => 'required|exists:users,id',
            'categories'  => 'array|exists:categories,id',
            'labels'      => 'array|exists:labels,id',
            'files.*'     => 'file|max:2048',
        ]);

        $ticket = Ticket::create($request->only(['title', 'description', 'priority', 'status', 'user_id']));

        if ($request->has('categories')) {
            $ticket->categories()->sync($request->categories);
        }

        if ($request->has('labels')) {
            $ticket->labels()->sync($request->labels);
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('attachments', 'public');
                $ticket->files()->create(['path' => $path]);
            }
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
    }
}
