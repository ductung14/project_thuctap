<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy
{
    public function create(User $user)
    {
        // Chỉ cho phép admin hoặc organizer tạo sự kiện
        return in_array($user->role, ['admin', 'organizer']);
    }

    public function update(User $user, Event $event)
    {
        return $user->role === 'admin' && $event->user_id === $user->id;
    }

    public function delete(User $user, Event $event)
    {
        return $user->role === 'admin' && $event->user_id === $user->id;
    }

    public function register(User $user, Event $event)
    {
        return $user->role === 'user';
    }
}
