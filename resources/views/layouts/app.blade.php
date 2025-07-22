<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Quản lý sự kiện')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('client.index') }}">Trang chủ</a>
            @auth
                @if (Auth::user()->role === 'admin')
                    <a class="nav-link" href="{{ route('admin.index') }}">Quản trị sự kiện</a>
                @else
                    <a class="nav-link" href="{{ route('client.index') }}">Sự kiện</a>
                @endif
                <span class="navbar-text">Xin chào, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-link" type="submit">Đăng xuất</button>
                </form>
            @else
                <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>

</html>