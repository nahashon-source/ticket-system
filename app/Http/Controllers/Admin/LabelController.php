<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::latest()->get();
        return view('admin.labels.index', compact('labels'));
    }

    // other CRUD methods...
}
