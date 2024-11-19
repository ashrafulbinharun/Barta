    {{-- Barta Card Bottom --}}
    <footer class="py-2 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex gap-8 text-gray-600">
                {{-- Heart Button --}}
                <form action="{{ route('posts.like', $post) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 p-2 text-xs text-gray-600 rounded-full hover:text-gray-800">
                        <span class="sr-only">Like</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        {{-- Heart Count --}}
                        <p>{{ $post->likes_count }}</p>
                    </button>
                </form>

                {{-- Comment Button --}}
                <button type="submit" class="flex items-center gap-2 p-2 text-xs text-gray-600 rounded-full hover:text-gray-800">
                    <span class="sr-only">Comment</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                    </svg>
                    {{-- Comment Count --}}
                    <p>{{ $post->comments_count }}</p>
                </button>
            </div>


            {{-- Share Button --}}
            <div x-data="{ copied: false }" class="relative inline-block">
                <button type="button" class="flex items-center gap-2 p-2 text-xs text-gray-600 rounded-full hover:text-gray-800"
                    @click="navigator.clipboard.writeText('{{ route('posts.show', $post) }}').then(() => { copied = true; setTimeout(() => copied = false, 2000); })">
                    <span class="sr-only">Share</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                    </svg>
                </button>

                {{-- Tooltip Message --}}
                <div x-show="copied" x-transition:enter="transition ease-out duration-200" x-transition:leave="transition ease-in duration-200" x-cloak
                    class="absolute px-2 py-1 text-xs text-white transform translate-x-2 -translate-y-1/2 bg-black rounded shadow top-1/2 left-full" style="white-space: nowrap;">
                    Copied to clipboard!
                </div>
            </div>
        </div>
    </footer>
