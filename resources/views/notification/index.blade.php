@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="px-4 py-5 mx-auto bg-white border-2 border-black rounded-lg shadow max-w-none sm:px-6">
        <h3 class="mb-3 font-semibold">All notifications</h3>

        <div class="w-full p-4 space-y-3 bg-gray-100 border rounded-md">
            @forelse ($notifications as $notification)
                <div class="border-2 border-gray-600 rounded-md bg-gray-300/50">
                    <a href="{{ $notification->data['url'] }}" class="flex items-center justify-between px-4 py-5 text-gray-800 rounded-md hover:bg-gray-100">
                        <div class="flex gap-x-1">
                            <h4 class="font-semibold text-gray-800 hover:underline">
                                {{ $notification->data['user_name'] }}
                            </h4>
                            <span>{{ $notification->data['text'] }}</span>
                        </div>
                        <span class="block text-xs text-gray-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </a>
                </div>
            @empty
                <p class="font-medium text-center">You have no notifications yet</p>
            @endforelse
        </div>
    </div>
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
@endsection
