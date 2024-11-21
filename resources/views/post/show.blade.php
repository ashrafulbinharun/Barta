@extends('layouts.app')

@section('title', 'Post Details')

@section('content')
    <article class="px-4 py-5 mx-auto bg-white border-2 border-black rounded-lg shadow max-w-none sm:px-6">
        <header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    {{-- User Avatar --}}
                    <div class="flex-shrink-0">
                        <img class="rounded-full size-10" src="{{ $post->user->get_avatar }}" alt="{{ $post->user->name }}" />
                    </div>

                    {{-- User Info --}}
                    <div class="flex flex-col flex-1 min-w-0 text-gray-900">
                        <a href="{{ route('profile.index', $post->user->username) }}" class="font-semibold hover:underline line-clamp-1">
                            {{ $post->user->name }}
                        </a>

                        <a href="{{ route('profile.index', $post->user->username) }}" class="text-sm text-gray-500 hover:underline line-clamp-1">
                            {{ '@' . $post->user->username }}
                        </a>
                    </div>
                </div>

                {{-- Card Action Dropdown --}}
                @canany(['update', 'delete'], $post)
                    <div class="flex self-center flex-shrink-0" x-data="{ open: false }">
                        <div class="relative inline-block text-left">
                            <div>
                                <button @click="open = !open" type="button" class="flex items-center p-2 -m-2 text-gray-400 rounded-full hover:text-gray-600" id="menu-0-button">
                                    <span class="sr-only">Open options</span>
                                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            {{-- Dropdown menu  --}}
                            <div x-show="open" @click.away="open = false" x-cloak
                                class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                @can('update', $post)
                                    <a href="{{ route('posts.edit', $post) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1"
                                        id="user-menu-item-0">
                                        Edit
                                    </a>
                                @endcan

                                @can('delete', $post)
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @method('DELETE')
                                        @csrf
                                        <button class="block w-full px-4 py-2 text-sm text-gray-700 text-start hover:bg-gray-100" role="menuitem" tabindex="-1"
                                            id="user-menu-item-1">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endcanany
            </div>
        </header>

        {{-- Image Preview --}}
        @if ($post->image)
            <div class="my-4">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="object-cover w-full h-auto rounded-lg max-h-64">
            </div>
        @endif

        {{-- Content --}}
        <div class="py-4 font-normal text-gray-700">
            <p class="mb-2">
                {{ $post->content }}
            </p>
        </div>

        {{-- Post Details --}}
        <div class="flex items-center gap-2 mb-2 text-xs text-gray-500">
            <span>{{ $post->created_at->diffForHumans() }}</span>
            <span>•</span>
            <span>{{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}</span>
            {{-- <span >•</span>
            <span>450 views</span> --}}
        </div>

        <hr class="my-6" />

        @include('post.partials.comment-box', ['user' => auth()->user()])
    </article>

    <hr />
    @include('post.partials.comments', ['post' => $post])
@endsection
