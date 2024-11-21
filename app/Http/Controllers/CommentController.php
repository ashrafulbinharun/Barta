<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Post $post)
    {
        $validated = request()->validate([
            'comment' => ['required', 'string', 'max:255'],
        ]);

        $comment = $post->comments()->create([
            'content' => $validated['comment'],
            'user_id' => auth()->id(),
        ]);

        if ($post->user_id !== auth()->id()) {
            $post->user->notify(new CommentNotification(request()->user(), $post, $comment));
        }

        return redirect()->back()->with(['message' => 'Comment added']);
    }

    public function update(Post $post, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $validated = request()->validate([
            'comment' => ['required', 'string', 'max:255'],
        ]);

        $comment->update([
            'content' => $validated['comment'],
        ]);

        return redirect()->back()->with(['message' => 'Comment updated']);
    }

    public function destroy(Post $post, Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with(['message' => 'Comment deleted']);
    }
}