<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function update(User $user, Comment $comment): bool
    {
        return $this->isOwner($user, $comment);
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $this->isOwner($user, $comment);
    }

    private function isOwner(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}
