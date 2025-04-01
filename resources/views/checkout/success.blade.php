@extends('layouts.app')
@section('content')
<body>
    <div class="container">
        <h1>Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được ghi nhận.</p>
        <a href="{{ route('home') }}">Quay lại trang chủ</a>
    </div>
</body>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
