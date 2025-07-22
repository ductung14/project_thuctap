<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    public function index(Event $event)
    {
        $registrations = $event->registrations()->with('user')->get();
        return response()->json($registrations);
    }

    public function register(Event $event, Request $request)
    {
        $user = $request->user();

        if ($event->registrations()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Bạn đã đăng ký sự kiện này'], 409);
        }

        if ($event->registrations()->count() >= $event->max_participants) {
            return response()->json(['message' => 'Sự kiện đã đủ số lượng người tham gia'], 409);
        }

        $event->registrations()->create(['user_id' => $user->id]);


        return response()->json(['message' => 'Đăng ký thành công']);
    }

    public function unregister(Event $event, Request $request)
    {
        $user = $request->user();

        $registration = $event->registrations()->where('user_id', $user->id)->first();

        if (!$registration) {
            return response()->json(['message' => 'Bạn chưa đăng ký sự kiện này'], 404);
        }

        $registration->delete();

        return response()->json(['message' => 'Huỷ đăng ký thành công']);
    }
}