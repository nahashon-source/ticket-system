<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCommentRequest;


class AdminCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        // Manual validation
        if (!$request->has('body') || empty($request->input('body'))) {
            return back()->withErrors(['body' => 'Comment body is required.'])->withInput();
        }
    
        // Proceed to save the comment
        Comment::create([
            'body'      => $request->input('body'),
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
        ]);
    
        return back()->with('success', 'Comment posted successfully.');
    }
    
    
    
    
}
