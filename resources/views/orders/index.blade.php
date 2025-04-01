@extends('layouts.app')
@vite(['resources/scss/app.scss', 'resources/js/app.js'])


@section('content')
<div class="container">
    <h1>Danh Sách Đơn Hàng</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Món Ăn</th>
                <th>Số Lượng</th>
                <th>Tổng Tiền</th>
                <th>Giá Sản Phẩm</th>
                <th>Trạng Thái</th>
                <th>Lý Do Hủy</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->food->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($order->total, 0) }} VNĐ</td>
                        <td>{{ number_format($item->price, 0) }} VNĐ</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if($order->cancellation_reason)
                                {{ $order->cancellation_reason }}
                            @else
                                Không có
                            @endif
                        </td>
                        <td>
                            @if($order->status === 'đã giao')
                                <span class="text-muted">Đã giao</span>
                            @elseif($order->status !== 'đã hủy')
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-info">Xem</a>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal{{ $order->id }}">Hủy</button>
                            @else
                                <span class="text-muted">Đã hủy</span>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal hủy đơn hàng -->
                    <div class="modal fade" id="cancelOrderModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="cancelOrderModalLabel{{ $order->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelOrderModalLabel{{ $order->id }}">Hủy Đơn Hàng #{{ $order->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('orders.destroy', $order) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="cancellation_reason">Lý Do Hủy:</label>
                                            <select class="form-control" id="cancellation_reason" name="cancellation_reason" onchange="toggleOtherReason(this, 'otherReason{{ $order->id }}')">
                                                <option value="">Chọn lý do</option>
                                                <option value="Không còn nhu cầu">Không còn nhu cầu</option>
                                                <option value="Món ăn không đúng như mô tả">Món ăn không đúng như mô tả</option>
                                                <option value="Chất lượng món ăn không đạt">Chất lượng món ăn không đạt</option>
                                                <option value="Thời gian giao hàng lâu">Thời gian giao hàng lâu</option>
                                                <option value="Khác">Khác</option>
                                            </select>
                                            <textarea class="form-control mt-2 d-none" id="otherReason{{ $order->id }}" name="other_reason" rows="3" placeholder="Nhập lý do khác..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-danger">Xác Nhận Hủy</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function toggleOtherReason(select, otherReasonId) {
        const textarea = document.getElementById(otherReasonId);
        if (select.value === "Khác") {
            textarea.classList.remove('d-none');
            textarea.required = true; // Make it required
        } else {
            textarea.classList.add('d-none');
            textarea.required = false; // Not required
            textarea.value = ""; // Clear the content
        }
    }
</script>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
