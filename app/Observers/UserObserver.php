<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Log::info('New user registered', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->getRoleNameAttribute(),
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Log important profile changes
        if ($user->isDirty('email')) {
            Log::info('User email changed', [
                'user_id' => $user->id,
                'old_email' => $user->getOriginal('email'),
                'new_email' => $user->email,
            ]);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        Log::info('User deleted', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);
    }
}
