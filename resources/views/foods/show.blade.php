@extends('layouts.app')

@section('content')
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="container my-4">
    @if($food)
        <div class="card my-5 py-2 bg-light shadow">
            <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="card-img-top" style="object-fit: cover; height: 300px;">
            <div class="card-body">
                <h1 class="card-title text-center text-primary">{{ $food->name }}</h1>
                <p class="card-text"><strong>Mô tả món ăn:</strong> {{ $food->description }}</p>
                <p class="card-text"><strong>Giá mỗi phần:</strong> <strong class="text-danger">{{ number_format($food->price, 0) }} VNĐ</strong></p>
                <p class="card-text"><strong>Trạng thái:</strong> <strong class="{{ $food->status == 'available' ? 'text-success' : 'text-danger' }}">{{ ucfirst($food->status) }}</strong></p>

                <div class="d-flex justify-content-between mt-3">
                    @if($food->status == 'available')
                        <form action="{{ route('cart.add', $food->id) }}" method="POST" class="w-50">
                            @csrf
                            <div class="form-group">
                                <label for="quantity">Số lượng:</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Thêm vào giỏ hàng</button>
                        </form>
                    @else
                        <button class="btn btn-secondary" disabled>Hết hàng</button>
                    @endif
                </div>

                <form action="{{ route('checkout.index') }}" method="GET" class="mt-3">
                    @csrf
                    <input type="hidden" name="food_id" value="{{ $food->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="immediate_purchase" value="true">
                    <button type="submit" class="btn btn-success w-100">Mua ngay</button>
                </form>

                <a href="{{ route('foods.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách sản phẩm</a>
            </div>
        </div>

        <!-- Suggested Foods -->
        <h3 class="mt-4 text-center">Món Ăn Gợi Ý</h3>
        <div class="row">
            @foreach ($relatedProducts as $relatedProduct)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                            <p class="card-text">Giá: <strong class="text-danger">{{ number_format($relatedProduct->price, 0) }} VNĐ</strong></p>
                            <a href="{{ route('foods.show', $relatedProduct->id) }}" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($relatedProducts->isEmpty())
            <p class="mt-4 text-danger text-center">Không có món ăn gợi ý nào.</p>
        @endif
    @else
        <p class="text-danger text-center">Món ăn không tồn tại.</p>
    @endif
</div>
@endsection
