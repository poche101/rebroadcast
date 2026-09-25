<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Rebroadcast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        $comments = Comment::with(['user', 'rebroadcast'])
            ->when($request->filled('rebroadcast_id'), fn ($q) => $q->where('rebroadcast_id', $request->rebroadcast_id))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $rebroadcasts = Rebroadcast::orderByDesc('scheduled_at')->get(['id', 'title']);

        return view('admin.comments.index', compact('comments', 'rebroadcasts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rebroadcast_id' => ['required', 'uuid', 'exists:rebroadcasts,id'],
            'body' => ['required', 'string', 'max:1000'],
        ]);

        Comment::create([
            'rebroadcast_id' => $validated['rebroadcast_id'],
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
            'is_admin_comment' => true,
        ]);

        return back()->with('status', 'Comment posted.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('status', 'Comment removed.');
    }
}
