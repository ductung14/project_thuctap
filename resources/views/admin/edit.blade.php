{{-- filepath: resources/views/admin/edit.blade.php --}}
@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Sửa sự kiện</h2>
        <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Tên sự kiện</label>
                <input type="text" class="form-control" name="title" value="{{ old('title', $event->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="description">{{ old('description', $event->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Ảnh đại diện</label>
                @if($event->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="Ảnh sự kiện" style="max-width:100px;">
                    </div>
                @endif
                <input type="file" class="form-control" name="image">
            </div>
            <div class="mb-3">
                <label class="form-label">Thời gian bắt đầu</label>
                <input type="datetime-local" class="form-control" name="start_at"
                    value="{{ old('start_at', \Carbon\Carbon::parse($event->start_at)->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Thời gian kết thúc</label>
                <input type="datetime-local" class="form-control" name="end_at"
                    value="{{ old('end_at', \Carbon\Carbon::parse($event->end_at)->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select class="form-select" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $event->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select class="form-select" name="status" required>
                    <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>Sắp diễn ra
                    </option>
                    <option value="ongoing" {{ old('status', $event->status) == 'ongoing' ? 'selected' : '' }}>Đang diễn ra
                    </option>
                    <option value="finished" {{ old('status', $event->status) == 'finished' ? 'selected' : '' }}>Kết thúc
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Số lượng tối đa</label>
                <input type="number" class="form-control" name="capacity" value="{{ old('capacity', $event->capacity) }}"
                    required>
            </div>
            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>
    </div>
@endsection