<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        return view('profile.index', compact('user'));
    }

    public function edit(User $user)
    {
        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()->back()->with(['message' => 'Profile updated']);
    }
}