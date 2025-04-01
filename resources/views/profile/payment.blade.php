@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Thanh toán</h1>
            <form action="{{ route('payment.store', $order->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên người nhận</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ nhận hàng</label>
                    <input type="text" name="address" id="address" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Thanh toán</button>
            </form>
        </div>
    </div>
</div>
@endsection
