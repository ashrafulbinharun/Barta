<form action="{{ route('profile.update', $user) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="space-y-12">
        <div class="pb-12 border-b border-gray-900/10">
            <h2 class="text-xl font-semibold leading-7 text-gray-900">
                Edit Profile
            </h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">
                This information will be displayed publicly so be careful what you share.
            </p>

            <div class="pb-12 mt-10 border-b border-gray-900/10">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    {{-- name --}}
                    <div class="sm:col-span-3">
                        <x-input-label for="name">Full Name</x-input-label>

                        <x-input-field id="name" name="name" :hasError="$errors->has('name')" value="{{ old('name', $user->name) }}" />

                        <x-validation-error :messages="$errors->get('name')" />
                    </div>

                    {{-- username --}}
                    <div class="sm:col-span-3">
                        <x-input-label for="username">Username</x-input-label>

                        <x-input-field id="username" name="username" :hasError="$errors->has('username')" value="{{ old('username', $user->username) }}" />

                        <x-validation-error :messages="$errors->get('username')" />
                    </div>

                    {{-- email --}}
                    <div class="col-span-full">
                        <x-input-label>Email Address</x-input-label>

                        <x-input-field class="bg-gray-200 cursor-not-allowed" disabled readonly value="{{ $user->email }}" />
                    </div>

                    {{-- password --}}
                    <div class="col-span-full">
                        <x-input-label for="password">Password</x-input-label>

                        <x-input-field type="password" name="password" id="password" :hasError="$errors->has('password')" />

                        <x-validation-error :messages="$errors->get('password')" />
                    </div>

                    {{-- confirm password --}}
                    <div class="col-span-full">
                        <x-input-label for="confirm_password">Confirm Password</x-input-label>

                        <x-input-field type="password" name="password_confirmation" id="confirm_password" :hasError="$errors->has('password_confirmation')" />

                        <x-validation-error :messages="$errors->get('password_confirmation')" />
                    </div>
                </div>
            </div>

            {{-- bio --}}
            <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="col-span-full">
                    <x-input-label for="bio">Bio</x-input-label>

                    <x-input-textarea id="bio" name="bio" rows="3" :hasError="$errors->has('bio')">{{ old('bio', $user->bio) }}</x-input-textarea>

                    <x-validation-error :messages="$errors->get('bio')" />

                    <p class="mt-3 text-sm leading-6 text-gray-600">
                        Write a few sentences about yourself.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end mt-6 gap-x-6">
        <button type="button" class="text-sm font-semibold leading-6 text-gray-900">
            Cancel
        </button>
        <x-primary-button class="leading-6">Save</x-primary-button>
    </div>
</form>
