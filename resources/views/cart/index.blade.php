@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Giỏ Hàng của Bạn</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <div class="alert alert-info">Giỏ hàng của bạn hiện đang trống.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tên Món Ăn</th>
                    <th>Số Lượng</th>
                    <th>Tổng Tiền</th>
                    <th>Thao Tác</th>
                    <th>Chọn</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->food->name }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control w-25 d-inline" required>
                                <button type="submit" class="btn btn-primary btn-sm">Cập Nhật</button>
                            </form>
                        </td>
                        <td>
                            <strong>{{ number_format($item->food->price * $item->quantity, 0) }} VNĐ</strong>
                        </td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-light select-item" data-id="{{ $item->id }}">Chọn</button>
                            <button type="button" class="btn btn-danger deselect-item" data-id="{{ $item->id }}" style="display: none;">Bỏ Chọn</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('cart.checkoutSelected') }}" method="POST" class="mt-3" id="checkout-form">
            @csrf
            <input type="hidden" name="selected_items" id="selected-items">
            <button type="submit" class="btn btn-success" id="checkout-button" disabled>Thanh Toán</button>
        </form>
    @endif
</div>

<script>
    let selectedItems = [];

    document.querySelectorAll('.select-item').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            if (!selectedItems.includes(itemId)) {
                selectedItems.push(itemId);
                this.style.display = 'none'; // Ẩn nút "Chọn"
                this.nextElementSibling.style.display = 'inline'; // Hiện nút "Bỏ Chọn"
            }
            updateCheckoutButtonState();
        });
    });

    document.querySelectorAll('.deselect-item').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            selectedItems = selectedItems.filter(id => id !== itemId);
            this.style.display = 'none'; // Ẩn nút "Bỏ Chọn"
            this.previousElementSibling.style.display = 'inline'; // Hiện nút "Chọn"
            updateCheckoutButtonState();
        });
    });

    function updateCheckoutButtonState() {
        document.getElementById('checkout-button').disabled = selectedItems.length === 0;
        document.getElementById('selected-items').value = selectedItems.join(','); // Cập nhật giá trị cho trường ẩn
    }
</script>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
