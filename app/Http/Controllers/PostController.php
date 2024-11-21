<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function create()
    {
        return view('post.create');
    }

    public function store(StorePostRequest $request, PostService $postService)
    {
        $postService->store(
            $request->validated(),
            $request->hasFile('image') ? $request->file('image') : null
        );

        return to_route('home')->with(['message' => 'Post created']);
    }

    public function show(Post $post)
    {
        $post = $post->load(['user', 'comments.user'])->loadCount(['likes', 'comments']);
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post, PostService $postService)
    {
        Gate::authorize('update', $post);

        $postService->update(
            $post,
            $request->validated(),
            $request->hasFile('image') ? $request->file('image') : null
        );

        return redirect()->intended()->with(['message' => 'Post updated']);
    }

    public function destroy(Post $post, PostService $postService)
    {
        Gate::authorize('delete', $post);

        $postService->delete($post);

        return redirect()->intended()->with(['message' => 'Post deleted']);
    }
}
