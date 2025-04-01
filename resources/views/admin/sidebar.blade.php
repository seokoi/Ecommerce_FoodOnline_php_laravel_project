<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
<style>
    body {
        background-color: #f8f9fa;
    }
    .sidebar {
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        padding-top: 20px;
        background-color: #343a40;
        transition: all 0.3s;
        z-index: 1000;
    }
    .sidebar.collapsed {
        width: 0;
        overflow: hidden;
    }
    .sidebar h4 {
        color: #ffffff;
        text-align: center;
        margin-bottom: 20px;
    }
    .sidebar .nav-link {
        color: #ffffff;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .sidebar .nav-link:hover {
        background-color: #495057;
    }
    .sidebar .nav-link.active {
        background-color: #495057;
    }
    .content {
        margin-left: 250px;
        padding: 20px;
        transition: margin-left 0.3s;
    }
    .content.collapsed {
        margin-left: 0;
    }
    @media (max-width: 768px) {
        .sidebar {
            position: absolute;
            z-index: 1000;
            width: 250px;
            left: -250px; /* Ẩn sidebar */
            transition: left 0.3s;
        }
        .sidebar.active {
            left: 0; /* Hiện sidebar */
        }
        .content {
            margin-left: 0;
        }
    }
</style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <h4>Quản lý</h4>
    <ul class="nav flex-column items-center">
        @if(auth()->user()->hasRole('admin') || auth()->user()->can('manage food'))
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.foods.index') }}">Quản lý sản phẩm</a>
            </li>
        @endif

        @if(auth()->user()->hasRole('admin') || auth()->user()->can('manage users'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">Quản lý người dùng</a>
            </li>
        @endif

        @if(auth()->user()->hasRole('admin') || auth()->user()->can('manage orders'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">Quản lý đơn hàng</a>
            </li>
        @endif

        @if(auth()->user()->hasRole('admin') || auth()->user()->can('view reports'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('manager.statistics') }}">Xem thống kê</a>
            </li>
        @endif

        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link nav-link">Đăng xuất</button>
            </form>
        </li>
    </ul>
</div>

<div class="content" id="content">
    <h2 class="mb-4">Xin chào, {{ auth()->user()->name }}!</h2>
    @yield('content')
</div>

<!-- Nút để hiển thị sidebar -->
<button id="toggleSidebar" class="btn btn-primary" style="position: absolute; top: 20px; left: 20px;">☰</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Kiểm tra kích thước màn hình
    function checkWidth() {
        if (window.innerWidth < 768) {
            document.getElementById('toggleSidebar').style.display = 'block'; // Hiện nút toggle
        } else {
            document.getElementById('toggleSidebar').style.display = 'none'; // Ẩn nút toggle
            document.getElementById('sidebar').classList.remove('active');
        }
    }

    // Toggle sidebar
    document.getElementById('toggleSidebar').onclick = function() {
        document.getElementById('sidebar').classList.toggle('active');
    };

    // Kiểm tra khi tải trang
    checkWidth();

    // Kiểm tra khi thay đổi kích thước cửa sổ
    window.onresize = checkWidth;
</script>
</body>
</html>
