{{-- Comments Container --}}
<div x-data="{ openModal: false, commentId: null, commentContent: '' }" class="flex flex-col ">
    {{-- Comments Header --}}
    <h1 class="mb-6 text-lg font-semibold">
        {{ Str::plural('Comment', $post->comments_count) }} ({{ $post->comments_count }})
    </h1>

    {{-- Comments --}}
    @foreach ($post->comments as $comment)
        <article class="min-w-full px-4 py-2 mx-auto mb-6 bg-white border-2 border-black divide-y rounded-lg shadow max-w-none sm:px-6">
            <div class="py-4">
                <header>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            {{-- Commented User Avatar --}}
                            <div class="flex-shrink-0">
                                <img class="rounded-full size-10" src="{{ $comment->user->get_avatar }}" alt="{{ $comment->user->name }}" />
                            </div>

                            {{-- Commented User Info --}}
                            <div class="flex flex-col flex-1 min-w-0 text-gray-900">
                                <a href="{{ route('profile.index', $comment->user->username) }}" class="font-semibold hover:underline line-clamp-1">
                                    {{ $comment->user->name }}
                                </a>

                                <a href="{{ route('profile.index', $comment->user->username) }}" class="text-sm text-gray-500 hover:underline line-clamp-1">
                                    {{ '@' . $comment->user->username }}
                                </a>
                            </div>
                        </div>

                        {{-- Card Action Dropdown --}}
                        @canany(['update', 'delete'], $comment)
                            <div class="flex self-center flex-shrink-0" x-data="{ open: false }">
                                <div class="relative inline-block text-left">
                                    <div>
                                        <button @click="open = !open" type="button" class="flex items-center p-2 -m-2 text-gray-400 rounded-full hover:text-gray-600">
                                            <span class="sr-only">Open options</span>
                                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Dropdown menu --}}
                                    <div x-show="open" @click.away="open = false" x-cloak
                                        class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

                                        @can('update', $comment)
                                            <button @click="openModal = true; commentId = {{ $comment->id }}; commentContent = @js($comment->content);"
                                                class="flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Edit
                                            </button>
                                        @endcan

                                        @can('delete', $comment)
                                            <form action="{{ route('posts.comments.destroy', [$post, $comment]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endcanany
                    </div>
                </header>

                {{-- Content --}}
                <div class="py-4 font-normal text-gray-700">
                    <p>{{ $comment->content }}</p>
                </div>

                {{-- Comment Date --}}
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </article>
    @endforeach

    {{-- Edit Modal --}}
    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center mt-0 bg-gray-500 bg-opacity-75">
        <div class="w-full max-w-lg p-6 bg-white rounded shadow-lg">
            <h2 class="mb-4 text-lg font-semibold">Edit Comment</h2>
            <form :action="`${baseRoute}/${commentId}`" method="POST" x-data="{ baseRoute: '{{ route('posts.comments.update', [$post->id, '']) }}' }">
                @csrf
                @method('PUT')
                <div>
                    <x-input-textarea name="comment" placeholder="Write a comment..." rows="1" x-model="commentContent"></x-input-textarea>

                    <x-validation-error :messages="$errors->get('comment')" />
                </div>

                <div class="flex justify-end gap-4 mt-4">
                    <button type="button" @click="openModal = false" class="text-sm font-semibold text-gray-900">
                        Cancel
                    </button>
                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
