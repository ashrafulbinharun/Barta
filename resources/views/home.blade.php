@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <main class="container max-w-xl min-h-screen px-2 mx-auto mt-8 space-y-8 md:px-0">
        {{-- Barta Create Post Card  --}}
        @if (auth()->check())
            @include('post.partials.create-post-form', ['user' => auth()->user()])
        @endif

        @foreach ($posts as $post)
            {{-- Barta Single Post Card --}}
            @include('post.partials.single-post', ['post' => $post])
        @endforeach
    </main>
@endsection
