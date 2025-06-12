<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $validated = $request->validated();

        $comment = Comment::create([
            'content' => $validated['content'],
            // add other fields here if necessary
        ]);

        return response()->json(['message' => 'Comment created!', 'data' => $comment], 201);
    }
}
