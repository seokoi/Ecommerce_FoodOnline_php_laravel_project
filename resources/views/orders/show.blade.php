@extends('layouts.app')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@section('content')
<div class="container">
    <h1>Chi Tiết Đơn Hàng </h1>

    <p><strong>Địa Chỉ:</strong> {{ $order->address }}</p>
    <p><strong>Số Điện Thoại:</strong> {{ $order->phone }}</p>
    <p><strong>Trạng Thái:</strong> {{ $order->status }}</p>
    <p><strong>Tổng Tiền:</strong> {{ number_format($order->total, 0) }} VNĐ</p>

    <h3>Các Món Ăn Trong Đơn Hàng</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Tên Món Ăn</th>
                <th>Số Lượng</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            @if($order->orderItems && $order->orderItems->isNotEmpty())
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->food->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 0) }} VNĐ</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center">Không có món ăn nào trong đơn hàng.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-primary">Quay Lại</a>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
