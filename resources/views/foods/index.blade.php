@extends('layouts.app')
@section('content')
@vite(['resources/scss/app.scss', 'resources/js/app.js'])



<div class="container mt-4">
    <form action="{{ route('foods.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <select name="category" class="form-select">
                <option value="">Chọn danh mục sản phẩm</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <input type="text" name="search" placeholder="Tìm kiếm món" value="{{ request('search') }}" class="form-control">
            <button type="submit" class="btn btn-primary">Tìm</button>
        </div>
    </form>

    <h1 class="h2 mb-4">Sản phẩm</h1>

    <div class="row">
    @foreach ($foods as $food)
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="card-img-top" style="object-fit: cover; height: 200px;">
                <div class="card-body">
                    <h5 class="card-title">{{ $food->name }}</h5>
                    <p class="card-text">Giá: <strong>{{ number_format($food->price, 0) }} VNĐ</strong></p>
                    <p class="card-text">
                        Trạng thái:
                        <strong class="{{ $food->status == 'available' ? 'status-available' : 'status-out-of-stock' }}">
                            {{ $food->status == 'available' ? 'Còn hàng' : 'Hết hàng' }}
                        </strong>
                    </p>
                    <a href="{{ route('foods.show', $food) }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

    @if($foods->isEmpty())
        <p class="mt-4 text-danger">Không tìm thấy sản phẩm nào.</p>
    @endif
</div>

<!-- Phân trang -->
<div class="d-flex justify-content-center mt-4">
    {{ $foods->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
