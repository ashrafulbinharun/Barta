<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticateUserController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(AuthenticateUserRequest $request)
    {
        $credentials = $request->validated();

        if ( ! Auth::attempt($credentials, request()->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match',
            ]);
        }

        request()->session()->regenerate();

        return redirect()->intended(route('home'))->with(['message' => 'Login Successful']);
    }

    public function destroy()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
