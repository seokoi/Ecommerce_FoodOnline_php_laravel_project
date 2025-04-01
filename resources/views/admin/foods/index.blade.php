@extends('admin.sidebar')

@section('content')
<style>
    /* Các style đã có trước đó */
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1.h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #343a40;
    }

    .alert {
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .input-group {
        margin-bottom: 20px;
    }

    .form-control, .form-select {
        border-radius: 0.25rem;
        box-shadow: none;
        border: 1px solid #ced4da;
    }

    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #ffffff;
        border-radius: 0.25rem;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }

    th {
        background-color: #f1f1f1;
        color: #495057;
    }

    tr:hover {
        background-color: #f8f9fa;
    }

    img {
        border-radius: 0.25rem;
        transition: transform 0.2s;
    }

    img:hover {
        transform: scale(1.05);
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .pagination {
        margin-top: 20px;
    }
</style>

<div class="container">
    <h1 class="h2">Quản lý món ăn</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.foods.create') }}" class="btn btn-primary mb-3">Thêm món ăn</a>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mb-3">Xem các danh mục hiện có</a>

    <form method="GET" action="{{ route('admin.foods.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" placeholder="Tìm kiếm món ăn" value="{{ request('search') }}" class="form-control" />
            <select name="category" class="form-select">
                <option value="">Tất cả thể loại</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foods as $food)
                <tr>
                    <td>{{ $food->id }}</td>
                    <td>{{ $food->name }}</td>
                    <td>{{ number_format($food->price, 0) }} VNĐ</td>
                    <td>
                        @if($food->category)
                            {{ $food->category->name }} <!-- Hiển thị tên danh mục -->
                        @else
                            <span>Không có danh mục</span>
                        @endif
                    </td>
                    <td>
                        @if($food->image)
                            <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" style="width: 100px; height: 100px; object-fit: cover;" />
                        @else
                            <span>Không có hình</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.foods.edit', $food) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.foods.destroy', $food) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $foods->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection
