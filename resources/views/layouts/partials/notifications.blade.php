@if (auth()->check())
    <div x-data="{ open: false }" class="relative">
        {{-- Bell Icon with Count --}}
        <button @click="open = !open" class="relative flex items-center focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
            @if ($unreadCount = $user->unreadNotifications->count())
                @if ($unreadCount > 0)
                    <span class="absolute flex items-center justify-center text-xs font-semibold text-white rounded-full size-5 bg-sky-900 -top-2 -right-2">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            @endif
        </button>

        {{-- Notifications Dropdown --}}
        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 z-20 mt-2 bg-white border border-gray-200 rounded-lg shadow-md w-72" x-cloak>
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>

                <ul class="mt-2 space-y-2">
                    @forelse ($user->unreadNotifications as $notification)
                        <li>
                            <a href="{{ $notification->data['url'] }}" class="block p-2 text-sm text-gray-800 border border-gray-500 rounded-md hover:bg-gray-100">
                                {{ $notification->data['message'] }}
                                <span class="block mt-2 text-xs text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </a>
                        </li>
                    @empty
                        <p class="mt-2 text-sm text-gray-500">No new notifications.</p>
                    @endforelse
                </ul>

                <div class="flex items-center justify-between mt-4">
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:underline">Mark all as read</button>
                    </form>
                    <a href="{{ route('notifications.index') }}" class="text-sm text-gray-600 hover:underline">View all</a>
                </div>
            </div>
        </div>
    </div>
@endif
