<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventListController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('creator')) {
            $query->whereHas('organizer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->creator . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('start_at')) {
            $query->where('start_at', '>=', $request->start_at);
        }
        if ($request->filled('end_at')) {
            $query->where('end_at', '<=', $request->end_at);
        }

        $events = $query->with('organizer')->paginate(10);

        return view('client.index', compact('events'));
    }

    public function register(Event $event, Request $request)
    {
        $user = $request->user();
        if ($user->events()->exists()) {
            return back()->with('error', 'Bạn chỉ được đăng ký 1 sự kiện!');
        }

        // Kiểm tra sự kiện đã đủ số lượng chưa
        if ($event->participants()->count() >= $event->capacity) {
            return back()->with('error', 'Sự kiện đã đủ số lượng người tham gia!');
        }

        $event->participants()->attach($user->id);
        return redirect()->route('client.index')->with('success', 'Đăng ký thành công');
    }

    public function unregister(Event $event, Request $request)
    {
        $user = $request->user();
        $registration = $event->registrations()->where('user_id', $user->id)->first();

        if (!$registration) {
            return back()->with('error', 'Bạn chưa đăng ký sự kiện này');
        }

        $registration->delete();
        return back()->with('success', 'Huỷ đăng ký thành công');
    }
}
