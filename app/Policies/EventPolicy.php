<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\Response;

class EventPolicy {
    /**
     * Create a new policy instance.
     */
    public function __construct() {
        //
    }

    public function edit(User $user, Event $event): bool {
        return $user->is_admin || ($user->id === $event->user_id);
    }

    public function update(User $user, Event $event): bool {
        return $user->is_admin || ($user->id === $event->user_id);
    }

    public function destroy(User $user, Event $event): bool {
        return $user->is_admin || ($user->id === $event->user_id);
    }
}
