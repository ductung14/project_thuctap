{{-- filepath: resources/views/events/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh sách sự kiện</h1>
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="Tên sự kiện" value="{{ request('name') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="creator" class="form-control" placeholder="Người tạo"
                    value="{{ request('creator') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">-- Trạng thái --</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Sắp diễn ra</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Đang diễn ra</option>
                    <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Kết thúc</option>
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
                <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Đặt lại</a>
            </div>
        </form>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <a href="{{ route('admin.events.create') }}" class="btn btn-success">+ Thêm sự kiện</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Ảnh</th>
                    <th>Tối đa</th>
                    <th>Bắt đầu</th>
                    <th>Kết thúc</th>
                    <th>Người tổ chức</th>
                    <th>Trạng thái</th>
                    <th>Quản lý người tham gia</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->description }}</td>
                        <td>
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="Ảnh sự kiện" style="max-width:100px;">
                            @else
                                Không có ảnh
                            @endif
                        </td>
                        <td>{{ $event->capacity }}</td>
                        <td>{{ $event->start_at }}</td>
                        <td>{{ $event->end_at }}</td>
                        <td>{{ $event->organizer->name ?? '' }}</td>
                        <td>
                            @if ($event->status == 'upcoming')
                                <span class="badge bg-info">Sắp diễn ra</span>
                            @elseif($event->status == 'ongoing')
                                <span class="badge bg-success">Đang diễn ra</span>
                            @else
                                <span class="badge bg-secondary">Kết thúc</span>
                            @endif
                        <td>
                            <a href="{{ route('admin.events.show', $event) }}" class="btn btn-info btn-sm">
                                Xem danh sách
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                                style="display:inline-block" onsubmit="return confirm('Bạn chắc chắn muốn xoá?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $events->links() }}
    </div>
@endsection