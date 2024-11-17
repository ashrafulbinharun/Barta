<section x-data="avatarUploader('{{ $user->get_avatar }}')">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Update Profile Avatar
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Keep your profile picture up-to-date so that our users can easily find you across the site!
        </p>
    </header>

    <form class="mt-6" method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="col-span-full">
            <div class="flex items-center mt-2 gap-x-3">
                <div class="relative">
                    <img :src="avatarPreview || originalAvatar" alt="{{ $user->name }}" class="object-cover rounded-full size-16 ring-2 ring-gray-300" />
                </div>

                <div class="flex items-center">
                    <label for="avatar"
                        class="inline-flex items-center px-4 py-2 ml-3 text-xs font-semibold tracking-wide text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm cursor-pointer hover:bg-gray-100">
                        Choose
                    </label>

                    <x-input-field type="file" name="avatar" id="avatar" class="hidden" @change="previewImage($event)" />

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 ml-3 text-xs font-semibold tracking-wide text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class="mt-6">
        <form action="{{ route('profile.avatar.delete') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-wider text-white uppercase transition duration-150 ease-in-out bg-red-600 rounded-md">
                Delete Current Avatar
            </button>
        </form>
    </div>

    <x-validation-error :messages="$errors->get('avatar')" />
</section>

<script>
    function avatarUploader(originalAvatar) {
        return {
            originalAvatar: originalAvatar,
            avatarPreview: null,

            previewImage(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.avatarPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },
        };
    }
</script>
