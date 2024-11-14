<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());

        Auth::login($user);

        return to_route('home')->with(['message' => 'Registration Successful']);
    }
}
