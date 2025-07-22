{{-- filepath: resources/views/admin/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Chi tiết sự kiện: {{ $event->title }}</h2>
        <div class="row mb-4">
            <div class="col-md-4">
                @if ($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="Ảnh sự kiện" class="img-fluid rounded shadow">
                @else
                    <div class="bg-secondary text-white text-center py-5 rounded">Không có ảnh</div>
                @endif
            </div>
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th>Mô tả</th>
                        <td>{{ $event->description }}</td>
                    </tr>
                    <tr>
                        <th>Thời gian bắt đầu</th>
                        <td>{{ $event->start_at }}</td>
                    </tr>
                    <tr>
                        <th>Thời gian kết thúc</th>
                        <td>{{ $event->end_at }}</td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            @if ($event->status == 'upcoming')
                                <span class="badge bg-info">Sắp diễn ra</span>
                            @elseif($event->status == 'ongoing')
                                <span class="badge bg-success">Đang diễn ra</span>
                            @else
                                <span class="badge bg-secondary">Kết thúc</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Số lượng tối đa</th>
                        <td>{{ $event->capacity }}</td>
                    </tr>
                    <tr>
                        <th>Chủ đề</th>
                        <td>{{ $event->category->name ?? 'Không có' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <h4 class="mb-3">Danh sách người tham gia ({{ $event->participants->count() }}/{{ $event->capacity }})</h4>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Thời gian đăng ký</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($event->participants as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ optional($user->pivot->created_at)->format('d/m/Y H:i') ?? 'Không xác định' }}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Chưa có người tham gia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary mt-4">Quay lại danh sách</a>
    </div>
@endsection
