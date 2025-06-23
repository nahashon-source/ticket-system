<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AgentCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        // Validate request manually using Validator facade
        $validator = Validator::make($request->all(), [
            'body' => 'required|string|max:5000',
        ]);

        // If validation fails, redirect back with errors and input
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // If validation passes, save comment
        $comment = new Comment();
        $comment->ticket_id = $ticket->id;
        $comment->user_id = Auth::id();
        $comment->body = $request->body;
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}
