@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Đặt hàng</h1>

    @if(isset($foods) && $foods->isNotEmpty())
        <form action="{{ route('checkout.place') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    @foreach ($foods as $food)
                        <div class="product-item mt-3">
                            <h3>{{ $food->name }}</h3>
                            <p>Giá: {{ number_format($food->price, 2) }} VNĐ</p>

                            <input type="hidden" name="food_id[]" value="{{ $food->id }}">
                            <div class="form-group">
                                <label for="quantity_{{ $food->id }}">Số lượng</label>
                                <input type="number" name="quantity[]" id="quantity_{{ $food->id }}" class="form-control" value="1" min="1" required onchange="updateTotal()">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="total">Tổng số tiền</label>
                        <input type="text" id="total" class="form-control" value="0 VNĐ" readonly>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ nhận hàng</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Nhập địa chỉ" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Thanh toán</button>
                </div>
            </div>
        </form>
    @else
        <p>Không có món ăn nào để đặt hàng.</p>
    @endif
</div>

{{-- <script>
    function updateTotal() {
        let total = 0;
        const quantities = document.querySelectorAll('input[name="quantity[]"]');
        // const prices = @json($foods->pluck('price')); // Lấy giá của các món ăn

        quantities.forEach((input, index) => {
            const quantity = parseInt(input.value) || 0;
            const price = prices[index] || 0;
            total += price * quantity;
        });

        // Cập nhật giá trị tổng tiền trong trường tổng tiền
        document.getElementById('total').value = total.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }
</script> --}}
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
