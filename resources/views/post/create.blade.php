@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <main class="container max-w-xl min-h-screen px-2 mx-auto mt-8 md:px-0">
        {{-- Barta Create Post Card --}}
        @include('post.partials.create-post-form', ['user' => auth()->user()])
    </main>
@endsection
