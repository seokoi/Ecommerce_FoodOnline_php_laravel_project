@extends('layouts.app')


@section('content')
<div class="container mt-4">
    <h1 class="h2">
        @if(isset($food))
            Đặt hàng cho món ăn: {{ $food->name }}
        @else
            Đặt hàng cho các món ăn đã chọn
        @endif
    </h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('checkout.place') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-8">
                @if(isset($food))
                    <div class="food-item mt-3">
                        <h3>{{ $food->name }}</h3>
                        <p>Giá: {{ number_format($food->price, 2) }} VNĐ</p>
                        <p>Số lượng:
                            <input type="number" name="quantity[]" class="form-control" value="{{ isset($quantity) ? $quantity : 1 }}" min="1" required onchange="updateTotal()">
                        </p>
                        <input type="hidden" name="food_id[]" value="{{ $food->id }}">
                    </div>
                @elseif(isset($cartItems))
                    @foreach ($cartItems as $cartItem)
                        <div class="food-item mt-3">
                            <h3>{{ $cartItem->food->name }}</h3>
                            <p>Giá: {{ number_format($cartItem->food->price, 2) }} VNĐ</p>
                            <p>Số lượng:
                                <input type="number" name="quantity[]" class="form-control" value="{{ $cartItem->quantity }}" min="1" required onchange="updateTotal()">
                            </p>
                            <input type="hidden" name="food_id[]" value="{{ $cartItem->food->id }}">
                        </div>
                    @endforeach
                @else
                    <p>Không có món ăn nào được chọn. Vui lòng quay lại giỏ hàng để chọn món ăn.</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="total">Tổng số tiền</label>
                    <input type="text" id="total" class="form-control" value="{{ number_format($totalAmount ?? 0, 2) }} VNĐ" readonly>
                </div>

                @if(Auth::user()->address && Auth::user()->phone)
                    <div class="form-group">
                        <label for="address">Địa chỉ nhận hàng</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ Auth::user()->address }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ Auth::user()->phone }}" readonly>
                    </div>
                @else
                    <div class="form-group">
                        <label for="address">Địa chỉ nhận hàng</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Nhập địa chỉ" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại" required>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary mt-3">Thanh toán</button>
            </div>
        </div>
    </form>
</div>

<script>
    function updateTotal() {
        let total = 0;
        const quantities = document.querySelectorAll('input[name="quantity[]"]');
        const prices = @json(isset($cartItems) ? $cartItems->pluck('food.price') : [isset($food) ? $food->price : 0]); // Lấy giá từ các món ăn
        quantities.forEach((input, index) => {
            const quantity = parseInt(input.value) || 0; // Lấy số lượng
            const price = prices[index] || 0; // Lấy giá tương ứng
            total += price * quantity; // Cập nhật tổng
        });

        // Cập nhật giá trị tổng
        document.getElementById('total').value = total.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }

    // Gọi hàm updateTotal khi trang được tải
    window.onload = updateTotal;
</script>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
