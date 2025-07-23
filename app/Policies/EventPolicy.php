<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class EventPolicy
{
    public function create(User $user)
    {
        // Chỉ cho phép admin hoặc organizer tạo sự kiện
        return in_array($user->role, ['admin', 'organizer']);
    }

    public function update(User $user, Event $event)
    {
        Log::info('UPDATE POLICY CHECK', [
            'user_id' => $user->id,
            'event_id' => $event->id,
            'user_role' => $user->role,
        ]);
        return in_array($user->role, ['admin', 'organizer']);
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
