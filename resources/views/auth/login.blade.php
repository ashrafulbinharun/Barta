@extends('layouts.auth')

@section('title', 'Sign-In')

@section('content')
    <div class="flex flex-col justify-center min-h-full px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a href="./index.html" class="text-6xl font-bold text-center text-gray-900">
                <h1>Barta</h1>
            </a>

            <h1 class="mt-10 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">
                Sign in to your account
            </h1>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                {{-- email --}}
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" placeholder="alp.arslan@mail.com" @class([
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
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        {{-- forgot password --}}
                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-gray-900 underline hover:text-gray-900" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- password --}}
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

                {{-- remember me  --}}
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="text-gray-600 border-gray-300 rounded shadow-sm" name="remember">
                        <span class="text-sm text-gray-900 ms-2 ">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-10 text-sm text-center text-gray-500">
                Don't have an account yet?
                <a href="{{ route('register') }}" class="font-semibold leading-6 text-black hover:text-black">Sign Up</a>
            </p>
        </div>
    </div>
@endsection
