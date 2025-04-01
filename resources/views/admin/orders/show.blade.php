@extends('admin.sidebar')

@section('content')
<div class="container">
    <h1 class="h2">Chi tiết đơn hàng #{{ $order->id }}</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Tên món ăn</th>
                <th>Số lượng</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->food->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf
        <select name="status" class="form-select">
            <option value="đang chờ" {{ $order->status == 'đang chờ' ? 'selected' : '' }}>Đang chờ</option>
            <option value="đã duyệt" {{ $order->status == 'đã duyệt' ? 'selected' : '' }}>Đã duyệt</option>
            <option value="đang giao" {{ $order->status == 'đang giao' ? 'selected' : '' }}>Đang giao</option>
            <option value="đã giao" {{ $order->status == 'đã giao' ? 'selected' : '' }}>Đã giao</option>
            <option value="đã hủy" {{ $order->status == 'đã hủy' ? 'selected' : '' }}>Đã hủy</option>
        </select>
        <button type="submit" class="btn btn-primary mt-2">Cập nhật trạng thái</button>
    </form>
</div>
@endsection
