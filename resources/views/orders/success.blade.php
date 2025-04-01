@extends('layouts.app')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@section('content')
<div class="container">
    <h1>Thành Công!</h1>
    <p>Đơn hàng của bạn đã được tạo thành công.</p>
    <a href="{{ route('orders.index') }}" class="btn btn-primary">Quay Lại Danh Sách Đơn Hàng</a>
</div>
@endsection
