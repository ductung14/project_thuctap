<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Event::query()->with(['category', 'participants', 'organizer']);

        // Tìm kiếm theo tên sự kiện
        if ($request->filled('name')) {
            $query->where('title', 'like', '%' . $request->name . '%');
        }

        // Tìm kiếm theo người tạo (organizer)
        if ($request->filled('creator')) {
            $query->whereHas('organizer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->creator . '%');
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo thời gian bắt đầu
        if ($request->filled('start_at')) {
            $query->where('start_at', '>=', $request->start_at);
        }
        if ($request->filled('end_at')) {
            $query->where('end_at', '<=', $request->end_at);
        }

        $events = $query->paginate(10)->withQueryString();

        return view('admin.index', compact('events'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'status' => 'required|in:upcoming,ongoing,finished',
            'category_id' => 'required|exists:categories,id',
            'capacity' => 'required|integer|min:1',
        ]);
        $data['user_id'] = Auth::id();

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }
        $data['category_id'] = $request->category_id;

        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Tạo sự kiện thành công');
    }

    public function edit(Event $event)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $categories = Category::all();
        return view('admin.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'status' => 'required|in:upcoming,ongoing,finished',
            'category_id' => 'required|exists:categories,id',
            'capacity' => 'required|integer|min:1',
        ]);

        // Xử lý upload ảnh mới (nếu có)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        } else {
            unset($data['image']); // Không cập nhật trường image nếu không upload mới
        }

        $data['category_id'] = $request->category_id;

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Cập nhật sự kiện thành công');
    }

    public function destroy(Event $event)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $event->delete();
        return redirect()->route('admin.index')->with('success', 'Xoá sự kiện thành công');
    }

    public function show(Event $event)
    {
        $event->load(['participants', 'category']);
        return view('admin.show', compact('event'));
    }
}
