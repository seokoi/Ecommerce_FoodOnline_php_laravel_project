@extends('admin.sidebar')

@section('content')
<div class="container">
    <h1 class="h2">Quản lý đơn hàng</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên người dùng" value="{{ request('search') }}">
            <select name="status" class="form-select">
                <option value="">Tất cả trạng thái</option>
                <option value="đang chờ" {{ request('status') == 'đang chờ' ? 'selected' : '' }}>Đang chờ</option>
                <option value="đã duyệt" {{ request('status') == 'đã duyệt' ? 'selected' : '' }}>Đã duyệt</option>
                <option value="đang giao" {{ request('status') == 'đang giao' ? 'selected' : '' }}>Đang giao</option>
                <option value="đã giao" {{ request('status') == 'đã giao' ? 'selected' : '' }}>Đã giao</option>
                <option value="đã hủy" {{ request('status') == 'đã hủy' ? 'selected' : '' }}>Đã hủy</option>
            </select>
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên người dùng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ number_format($order->total, 0) }} VNĐ</td>
                    <td>
<form action="{{ route('admin.orders.update', $order) }}" method="POST" style="display:inline;">
    @csrf
    @method('PATCH') <!-- This is important for specifying the PATCH method -->
    <select name="status" onchange="this.form.submit()">
        <option value="đang chờ" {{ $order->status == 'đang chờ' ? 'selected' : '' }}>Đang chờ</option>
        <option value="đã duyệt" {{ $order->status == 'đã duyệt' ? 'selected' : '' }}>Đã duyệt</option>
        <option value="đang giao" {{ $order->status == 'đang giao' ? 'selected' : '' }}>Đang giao</option>
        <option value="đã giao" {{ $order->status == 'đã giao' ? 'selected' : '' }}>Đã giao</option>
        <option value="đã hủy" {{ $order->status == 'đã hủy' ? 'selected' : '' }}>Đã hủy</option>
    </select>
</form>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">Xem</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

<div class="d-flex justify-content-center mt-4">
    {{ $orders->links('vendor.pagination.bootstrap-5') }}
</div>

</div>

<style>
    .container {
        margin-top: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .alert {
        margin-bottom: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .btn {
        margin-right: 5px;
    }
</style>
@endsection
