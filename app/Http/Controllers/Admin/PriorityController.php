<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    public function index()
    {
        $priorities = Priority::latest()->get();
        return view('admin.priorities.index', compact('priorities'));
    }

    public function create()
    {
        return view('admin.priorities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:priorities,name'
        ]);

        Priority::create($validated);

        return redirect()->route('admin.priorities.index')->with('success', 'Priority created.');
    }

    public function edit(Priority $priority)
    {
        return view('admin.priorities.edit', compact('priority'));
    }

    public function update(Request $request, Priority $priority)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:priorities,name,' . $priority->id
        ]);

        $priority->update($validated);

        return redirect()->route('admin.priorities.index')->with('success', 'Priority updated.');
    }

    public function destroy(Priority $priority)
    {
        $priority->delete();

        return redirect()->route('admin.priorities.index')->with('success', 'Priority deleted.');
    }
}
