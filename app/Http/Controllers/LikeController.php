<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostLikedNotification;

class LikeController extends Controller
{
    public function __invoke(Post $post)
    {
        $user = auth()->user();

        if (! $user || ! $user instanceof User) {
            return to_route('login');
        }

        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        // Unlike the post
        if ($existingLike) {
            $existingLike->delete();

            return redirect()->intended(route('home'));
        }

        // Like the post
        $post->likes()->create([
            'user_id' => $user->id,
        ]);

        if ($post->user_id !== $user->id) {
            $post->user->notify(new PostLikedNotification($user, $post));
        }

        return redirect()->back();
    }
}
