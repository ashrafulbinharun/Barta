@extends('layouts.app')

@section('title', 'Post Details')

@section('content')
    @include('post.partials.single-post', [
        'post' => $post,
        'showFullContent' => true,
    ])
@endsection
