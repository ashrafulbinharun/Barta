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
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Full Name</label>
                    <div class="mt-2">
                        <input id="name" name="name" type="text" autocomplete="name" placeholder="Alp Arslan" value="{{ old('name') }}" @class([
                            'block w-full rounded-md border p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6',
                            'border-red-600 dark:border-red-800' => $errors->has('name'),
                        ])
                            required />
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- username  --}}
                <div>
                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>

                    <div class="mt-2">
                        <input id="username" name="username" type="text" autocomplete="username" placeholder="alparslan1029" value="{{ old('username') }}"
                            @class([
                                'block w-full rounded-md border p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6',
                                'border-red-600 dark:border-red-800' => $errors->has('username'),
                            ]) required />
                    </div>
                    @error('username')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- email --}}
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" placeholder="alp.arslan@mail.com" value="{{ old('email') }}"
                            @class([
                                'block w-full rounded-md border p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6',
                                'border-red-600 dark:border-red-800' => $errors->has('email'),
                            ]) required />
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- password --}}
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" placeholder="••••••••" @class([
                            'block w-full rounded-md border p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6',
                            'border-red-600 dark:border-red-800' => $errors->has('password'),
                        ]) required />
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- confirm password --}}
                <div>
                    <label for="confirm_password" class="block text-sm font-medium leading-6 text-gray-900">Confirm
                        Password</label>
                    <div class="mt-2">
                        <input id="confirm_password" name="password_confirmation" type="password" autocomplete="current-password" placeholder="••••••••" @class([
                            'block w-full rounded-md border p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6',
                            'border-red-600 dark:border-red-800' => $errors->has(
                                'password_confirmation'),
                        ])
                            required />
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
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
