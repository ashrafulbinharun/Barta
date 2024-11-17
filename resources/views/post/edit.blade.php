@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <main class="container max-w-xl min-h-screen px-2 mx-auto mt-8 md:px-0">
        {{-- Edit Post Form --}}
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data"
            class="px-4 py-5 mx-auto space-y-6 bg-white border-2 border-black rounded-lg shadow max-w-none sm:px-6" x-data="imageHandler({{ json_encode($post->image ? asset('storage/' . $post->image) : null) }})">
            @csrf
            @method('PUT')

            <div class="flex space-x-3">
                {{-- User Avatar --}}
                <div class="flex-shrink-0">
                    <img class="mt-1 rounded-full size-10" src="{{ auth()->user()->get_avatar }}" alt="{{ auth()->user()->name }}" />
                </div>

                <div class="flex-1">
                    {{-- Image Preview or Existing Image --}}
                    <div class="relative flex items-center justify-center mb-4">
                        {{-- Show current image if available --}}
                        <template x-if="existingImage && !newImage">
                            <img :src="existingImage" class="object-cover w-full rounded-lg min-h-auto max-h-64 md:max-h-72" alt="Post Image" />
                        </template>

                        {{-- Show preview of the newly uploaded image --}}
                        <template x-if="newImage">
                            <img :src="newImage" class="object-cover w-full rounded-lg min-h-auto max-h-64 md:max-h-72" alt="New Post Image Preview" />
                        </template>

                        {{-- Remove Image Button --}}
                        <x-cross-button @click="removeImage()" x-show="existingImage || newImage" />
                    </div>

                    {{-- Hidden Input to Indicate Image Removal --}}
                    <input type="hidden" name="remove_image" x-model="removeExistingImage">

                    {{-- Content --}}
                    <div class="w-full font-normal text-gray-700">
                        <x-input-textarea name="content" rows="4" :hasError="$errors->has('content')">
                            {{ old('content', $post->content) }}
                        </x-input-textarea>

                        @error('content')
                            <x-validation-error :messages="$errors->get('content')" />
                        @enderror

                        @error('image')
                            <x-validation-error :messages="$errors->get('image')" />
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Bottom Section --}}
            <div class="flex items-center justify-between">
                <div class="flex gap-4 text-gray-600">
                    {{-- Upload Picture Button --}}
                    <div>
                        <x-input-field type="file" name="image" id="picture" class="hidden" x-ref="pictureInput" @change="previewNewImage($event)" />

                        <x-post-image-label for="picture">
                            <span class="sr-only">Upload Image</span>
                        </x-post-image-label>
                    </div>
                </div>

                <x-primary-button>Update Post</x-primary-button>
            </div>
        </form>
    </main>

    <script>
        function imageHandler(existingImagePath) {
            return {
                existingImage: existingImagePath,
                newImage: null,
                removeExistingImage: false,

                previewNewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.newImage = URL.createObjectURL(file);
                        this.removeExistingImage = false;
                    }
                },

                removeImage() {
                    if (this.newImage) {
                        this.newImage = null;
                    } else if (this.existingImage) {
                        this.removeExistingImage = true;
                        this.existingImage = null;
                    }

                    this.$refs.pictureInput.value = null;
                }
            }
        }
    </script>
@endsection
