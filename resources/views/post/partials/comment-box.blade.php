{{-- Comment Form  --}}
<form action="{{ route('posts.comments.store', $post) }}" method="POST">
    @csrf
    <div class="space-y-3">
        <div class="flex items-start space-x-3">
            {{-- User Avatar  --}}
            <div class="flex-shrink-0">
                <img class="mt-1 rounded-full size-8" src="{{ $user->get_avatar }}" alt="{{ $user->name }}" />
            </div>

            {{-- Comment Box --}}
            <div class="w-full font-normal text-gray-700">
                <x-input-textarea name="comment" placeholder="Write a comment..." rows="1"></x-input-textarea>

                <x-validation-error :messages="$errors->get('comment')" />
            </div>
        </div>

        {{-- Comment Button --}}
        <div class="flex items-center justify-end">
            <x-primary-button>Comment</x-primary-button>
        </div>
    </div>
</form>
