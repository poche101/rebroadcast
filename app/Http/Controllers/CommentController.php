<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'rebroadcast_id' => ['required', 'uuid', 'exists:rebroadcasts,id'],
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $comment = Comment::create([
            'rebroadcast_id' => $validated['rebroadcast_id'],
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
            'is_admin_comment' => $request->user()->isAdmin(),
        ]);

        return response()->json([
            'comment' => $comment->load('user'),
        ]);
    }
}
