<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request)
    {
        $user = auth()->user();

        $request->validated();

        $this->deleteExistingAvatar($user);

        $user->update([
            'avatar_url' => $request->file('avatar')->store('avatars', 'public'),
        ]);

        return redirect()->back()->with(['message' => 'Profile avatar successfully updated']);
    }

    public function destroy()
    {
        $user = auth()->user();

        $this->deleteExistingAvatar($user);

        $user->update([
            'avatar_url' => null,
        ]);

        return redirect()->back()->with(['message' => 'Profile avatar successfully deleted']);
    }

    private function deleteExistingAvatar($user): void
    {
        if ($user->avatar_url) {
            Storage::disk('public')->delete($user->avatar_url);
        }
    }
}
