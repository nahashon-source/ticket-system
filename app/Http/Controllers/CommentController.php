<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommentRequest;


class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Ticket $ticket)
    {
        $ticket->comments()->create([
            'user_id' => Auth::id(),
            'body'    => $request->body,
        ]);
    
        return back()->with('success', 'Comment added successfully.');
    }
}
