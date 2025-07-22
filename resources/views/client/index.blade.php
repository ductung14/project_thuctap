{{-- filepath: resources/views/client/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh sách sự kiện</h2>

    {{-- Form tìm kiếm và lọc --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="Tên sự kiện" value="{{ request('name') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="creator" class="form-control" placeholder="Người tạo" value="{{ request('creator') }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">-- Trạng thái --</option>
                <option value="upcoming" {{ request('status')=='upcoming' ? 'selected' : '' }}>Sắp diễn ra</option>
                <option value="ongoing" {{ request('status')=='ongoing' ? 'selected' : '' }}>Đang diễn ra</option>
                <option value="finished" {{ request('status')=='finished' ? 'selected' : '' }}>Kết thúc</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="start_at" class="form-control" value="{{ request('start_at') }}">
        </div>
        <div class="col-md-2">
            <input type="date" name="end_at" class="form-control" value="{{ request('end_at') }}">
        </div>
        <div class="col-md-12 mt-2">
            <button class="btn btn-primary" type="submit">Tìm kiếm/Lọc</button>
            <a href="{{ route('client.index') }}" class="btn btn-secondary">Đặt lại</a>
        </div>
    </form>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Danh sách sự kiện --}}
    <div class="row">
        @forelse($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="Ảnh sự kiện">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text text-truncate">{{ $event->description }}</p>
                        <p class="mb-1"><strong>Thời gian:</strong> {{ $event->start_at }} - {{ $event->end_at }}</p>
                        <p class="mb-1"><strong>Chủ đề:</strong> {{ $event->category->name ?? 'Không có' }}</p>
                        <p class="mb-1"><strong>Người tạo:</strong> {{ $event->organizer->name ?? '' }}</p>
                        <p class="mb-1">
                            <strong>Trạng thái:</strong>
                            @if($event->status == 'upcoming')
                                <span class="badge bg-info">Sắp diễn ra</span>
                            @elseif($event->status == 'ongoing')
                                <span class="badge bg-success">Đang diễn ra</span>
                            @else
                                <span class="badge bg-secondary">Kết thúc</span>
                            @endif
                        </p>
                        <p class="mb-2"><strong>Đã đăng ký:</strong> {{ $event->participants_count ?? $event->participants->count() ?? 0 }}/{{ $event->capacity }}</p>
                        <div class="mt-auto">
                            @auth
                                @if($event->participants->contains(auth()->id()))
                                    <form method="POST" action="{{ route('events.unregister', $event) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">Huỷ đăng ký</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('events.register', $event) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary w-100">Đăng nhập để đăng ký</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">Không có sự kiện nào phù hợp.</div>
            </div>
        @endforelse
    </div>

    {{-- Phân trang --}}
    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>
@endsection