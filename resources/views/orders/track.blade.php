<!-- resources/views/orders/track.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>

    <p><strong>Tên người dùng:</strong> {{ $order->user->name }}</p>
    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
    <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
    <p><strong>Trạng thái:</strong> {{ $order->status }}</p>

    <h2>Thông tin món ăn</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tên món ăn</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->food->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->food->price, 0) }} VNĐ</td>
                    <td>{{ number_format($item->food->price * $item->quantity, 0) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Tổng số tiền:</strong> {{ number_format($order->total, 0) }} VNĐ</p>
    <a href="{{ route('orders.index') }}" class="btn btn-primary">Trở về danh sách đơn hàng</a>
</div>
@endsection
