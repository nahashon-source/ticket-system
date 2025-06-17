<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Priority;
use App\Models\Label;

class UserController extends Controller
{
    public function categories()
    {
        $categories = Category::all();
        return view('user.categories', compact('categories'));
    }

    public function priorities()
    {
        $priorities = Priority::all();
        return view('user.priorities', compact('priorities'));
    }

    public function labels()
    {
        $labels = Label::all();
        return view('user.labels', compact('labels'));
    }
}
