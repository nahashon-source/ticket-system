<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:priorities,name'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Priority::create($validator->validated());

        return redirect()->route('admin.priorities.index')->with('success', 'Priority created.');
    }

    public function show(Priority $priority)
    {
        return view('admin.priorities.show', compact('priority'));
    }

    public function edit(Priority $priority)
    {
        return view('admin.priorities.edit', compact('priority'));
    }

    public function update(Request $request, Priority $priority)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:priorities,name,' . $priority->id
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $priority->update($validator->validated());

        return redirect()->route('admin.priorities.index')->with('success', 'Priority updated.');
    }

    public function destroy(Priority $priority)
    {
        $priority->delete();

        return redirect()->route('admin.priorities.index')->with('success', 'Priority deleted.');
    }
}
