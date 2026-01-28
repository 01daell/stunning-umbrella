<?php

namespace App\Policies;

use App\Models\BrandKit;
use App\Models\User;

class BrandKitPolicy
{
    public function view(User $user, BrandKit $kit): bool
    {
        return $kit->workspace->members()->where('user_id', $user->id)->exists();
    }

    public function update(User $user, BrandKit $kit): bool
    {
        return $kit->workspace->members()
            ->where('user_id', $user->id)
            ->whereIn('role', ['OWNER', 'ADMIN', 'MEMBER'])
            ->exists();
    }

    public function delete(User $user, BrandKit $kit): bool
    {
        return $kit->workspace->members()
            ->where('user_id', $user->id)
            ->whereIn('role', ['OWNER', 'ADMIN'])
            ->exists();
    }
}
