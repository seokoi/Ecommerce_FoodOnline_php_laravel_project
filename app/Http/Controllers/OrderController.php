<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food; // Thay đổi từ Product thành Food
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

public function index(Request $request)
{
    $query = Order::with(['user', 'orderItems.food'])
        ->where('user_id', Auth::id()); // Lọc theo user_id

    // Tìm kiếm theo tên người dùng (nếu cần)
    if ($request->filled('search')) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    // Lọc theo trạng thái (nếu cần)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Phân trang
    $orders = $query->paginate(10); // Số lượng đơn hàng trên mỗi trang

    return view('orders.index', compact('orders'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        // Tạo đơn hàng mới
        $order = new Order();
        $order->user_id = Auth::id(); // Lấy ID người dùng đã đăng nhập
        $order->name = $request->name;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->status = 'đang chờ'; // Trạng thái ban đầu
        $order->save();

        return redirect()->route('success')->with('success', 'Đơn hàng đã được tạo thành công.');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được cập nhật thành công.');
    }

public function destroy(Request $request, Order $order)
{
    // Lưu lý do hủy (nếu có)
    if ($request->has('cancellation_reason')) {
        // Nếu lý do là "Khác", lưu nội dung từ textarea
        if ($request->input('cancellation_reason') === "Khác" && $request->has('other_reason')) {
            $order->cancellation_reason = $request->other_reason;
        } else {
            $order->cancellation_reason = $request->cancellation_reason;
        }

        // Cập nhật trạng thái đơn hàng
        $order->status = 'đã hủy';
        $order->save();
    }

    return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được hủy thành công.');
}

    public function pay(Order $order)
    {
        // Kiểm tra trạng thái đơn hàng
        if ($order->status !== 'đang chờ') {
            return redirect()->route('orders.index')->with('error', 'Đơn hàng đã được thanh toán hoặc không hợp lệ.');
        }

        // Giả định bạn có logic thanh toán ở đây
        $order->status = 'paid';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được thanh toán thành công.');
    }

    public function checkout($foodId)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đặt hàng.');
        }

        $user = Auth::user();
        $food = Food::find($foodId);

        if (!$food) {
            return redirect()->back()->with('error', 'Món ăn không tồn tại.');
        }

        return view('orders.create', compact('food', 'user'))->with('quantity', 1);
    }

    public function bulkCheckout(Request $request)
    {
        $request->validate([
            'selected_foods' => 'required|array',
            'selected_foods.*' => 'exists:foods,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        // Lấy thông tin món ăn đã chọn
        $foods = Food::whereIn('id', $request->selected_foods)->get();

        // Kiểm tra xem có món ăn nào không
        if ($foods->isEmpty()) {
            return redirect()->back()->with('error', 'Không tìm thấy món ăn nào.');
        }

        // Lấy thông tin người dùng đã đăng nhập
        $user = Auth::user();
        $quantities = $request->quantities;

        // Chuyển hướng đến trang thanh toán với thông tin món ăn đã chọn và số lượng
        return view('orders.create', compact('foods', 'user', 'quantities'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'food_id' => 'required|array',
            'food_id.*' => 'exists:foods,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $totalAmount = 0;

        foreach ($request->food_id as $index => $foodId) {
            $food = Food::find($foodId);

            // Tạo đơn hàng mới
            $order = new Order();
            $order->user_id = Auth::id();
            $order->food_id = $food->id; // Lưu ID món ăn
            $order->quantity = $request->quantity[$index];
            $order->total = $food->price * $request->quantity[$index]; // Tính tổng cho từng món ăn
            $totalAmount += $order->total; // Cộng dồn tổng số tiền
            $order->address = $request->address;
            $order->phone = $request->phone;
            $order->status = 'đang chờ'; // Trạng thái đơn hàng
            $order->save();
        }

        return redirect()->route('success')->with('success', 'Đơn hàng đã được tạo thành công với tổng số tiền: ' . number_format($totalAmount, 0) . ' VNĐ.');
    }

    public function success()
    {
        return view('orders.success'); // Tạo view để hiển thị thông báo thành công
    }
    public function trackOrder($orderId)
{
    // Retrieve the order for the authenticated user
    $order = Order::with(['user', 'orderItems.food'])
        ->where('id', $orderId)
        ->where('user_id', Auth::id())
        ->first();

    // Check if the order exists
    if (!$order) {
        return redirect()->route('orders.index')->with('error', 'Đơn hàng không tồn tại hoặc không thuộc về bạn.');
    }

    return view('orders.track', compact('order'));
}
    // Hiển thị danh sách đơn hàng cho quản trị viên
public function adminIndex(Request $request)
{
    $query = Order::with(['user', 'orderItems.food']);

    // Tìm kiếm theo tên người dùng
    if ($request->filled('search')) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    // Lọc theo trạng thái
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Phân trang
    $orders = $query->paginate(10); // Số lượng đơn hàng trên mỗi trang

    return view('admin.orders.index', compact('orders'));
}

    // Hiển thị chi tiết đơn hàng cho quản trị viên
    public function adminShow(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    // Cập nhật trạng thái đơn hàng
public function adminUpdate(Request $request, Order $order)
{
    // \Log::info('Cập nhật trạng thái đơn hàng', ['order_id' => $order->id, 'status' => $request->status]);

    $request->validate([
        'status' => 'required|string|in:đang chờ,đã duyệt,đang giao,đã giao,đã hủy',
    ]);

    $order->status = $request->status; // Cập nhật trạng thái đơn hàng
    $order->save();

    return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công.');
}

    // Hủy đơn hàng
    public function adminDestroy(Order $order)
    {
        $order->status = 'canceled'; // Cập nhật trạng thái thành đã hủy
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được hủy thành công.');
    }
}