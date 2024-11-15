@extends('layouts.auth')

@section('title', 'Registration')

@section('content')
    <div class="flex flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a href="{{ route('home') }}" class="text-6xl font-bold text-center text-gray-900">
                <h1>Barta</h1>
            </a>
            <h1 class="mt-5 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">
                Create a new account
            </h1>
        </div>

        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                {{-- name --}}
                <div>
                    <x-input-label for="name">Full Name</x-input-label>

                    <x-input-field name="name" id="name" autocomplete="name" placeholder="Alp Arslan" value="{{ old('name') }}" :hasError="$errors->has('name')" />

                    <x-validation-error :messages="$errors->get('name')" />
                </div>

                {{-- username  --}}
                <div>
                    <x-input-label for="username">Username</x-input-label>

                    <x-input-field name="username" id="username" autocomplete="username" placeholder="alparslan1029" value="{{ old('username') }}" :hasError="$errors->has('username')" />

                    <x-validation-error :messages="$errors->get('username')" />
                </div>

                {{-- email --}}
                <div>
                    <x-input-label for="email">Email Address</x-input-label>

                    <x-input-field type="email" name="email" id="email" autocomplete="email" placeholder="alp.arslan@mail.com" value="{{ old('email') }}" :hasError="$errors->has('email')" />

                    <x-validation-error :messages="$errors->get('email')" />
                </div>

                {{-- password --}}
                <div>
                    <x-input-label for="password">Password</x-input-label>

                    <x-input-field type="password" name="password" id="password" :hasError="$errors->has('password')" />

                    <x-validation-error :messages="$errors->get('password')" />
                </div>

                {{-- confirm password --}}
                <div>
                    <x-input-label for="confirm_password">Confirm Password</x-input-label>

                    <x-input-field type="password" name="password_confirmation" id="confirm_password" :hasError="$errors->has('password_confirmation')" />

                    <x-validation-error :messages="$errors->get('password_confirmation')" />
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                        Register
                    </button>
                </div>
            </form>

            <p class="mt-10 text-sm text-center text-gray-500">
                Already a member?
                <a href="{{ route('login') }}" class="font-semibold leading-6 text-black hover:text-black">Sign In</a>
            </p>
        </div>
    </div>
@endsection
