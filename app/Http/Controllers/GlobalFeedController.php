<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class GlobalFeedController extends Controller
{
    public function __invoke(Request $request)
    {
        $searchResults = $request->query('word');

        $posts = Post::with('user')
            ->search($searchResults)
            ->latest()
            ->get();

        return view('home', compact('posts', 'searchResults'));
    }
}
