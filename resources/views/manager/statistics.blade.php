@extends('admin.sidebar')

@section('content')
<div class="container">
    <h1>Thống Kê Đơn Hàng</h1>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Tổng Số Đơn Hàng
                </div>
                <div class="card-body">
                    <h2 class="card-title">{{ $totalOrders }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Tổng Doanh Thu
                </div>
                <div class="card-body">
                    <h2 class="card-title">{{ number_format($totalRevenue, 0) }} VNĐ</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Thống Kê Theo Trạng Thái
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($ordersByStatus as $status)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $status->status }}
                                <span class="badge bg-primary">{{ $status->count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
