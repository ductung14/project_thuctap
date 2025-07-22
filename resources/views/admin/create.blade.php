@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Tạo sự kiện mới</h2>
        <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tên sự kiện</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" class="form-control" name="image">
            </div>
            <div class="mb-3">
                <label class="form-label">Thời gian bắt đầu</label>
                <input type="datetime-local" class="form-control" name="start_at" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Thời gian kết thúc</label>
                <input type="datetime-local" class="form-control" name="end_at" required>
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
                    <option value="upcoming">Sắp diễn ra</option>
                    <option value="ongoing">Đang diễn ra</option>
                    <option value="finished">Kết thúc</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Số lượng tối đa</label>
                <input type="number" class="form-control" name="capacity" required>
            </div>
            <button type="submit" class="btn btn-success">Tạo sự kiện</button>
        </form>
    </div>
@endsection