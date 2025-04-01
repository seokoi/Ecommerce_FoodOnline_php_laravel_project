<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food; // Model cho món ăn
use App\Models\Order; // Model cho đơn hàng
use App\Models\OrderItem; // Model cho chi tiết đơn hàng
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
public function index(Request $request)
{
    // Lấy ID món ăn từ request
    $foodId = $request->input('food_id');
    $food = null;

    if ($foodId) {
        // Nếu có ID món ăn, tìm món ăn đó
        $food = Food::find($foodId);

        // Kiểm tra xem món ăn có tồn tại không
        if (!$food) {
            return redirect()->route('cart.index')->with('error', 'Món ăn không tồn tại.');
        }
    } else {
        // Nếu không có ID món ăn, chuyển hướng về trang giỏ hàng hoặc trang khác
        return redirect()->route('cart.index')->with('error', 'Bạn chưa chọn món ăn nào.');
    }

    // Trả về view checkout với thông tin món ăn
    return view('checkout.index', compact('food'));
}

public function place(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'food_id' => 'required|array',
        'quantity' => 'required|array',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
    ]);

    // Tính toán tổng giá tiền
    $total = 0;

    foreach ($request->input('food_id') as $index => $foodId) {
        $food = Food::find($foodId);
        $total += $food->price * $request->input('quantity')[$index]; // Tính tổng
    }

    // Tạo đơn hàng mới
    $order = new Order();
    $order->user_id = Auth::id();
    $order->address = $request->input('address');
    $order->phone = $request->input('phone');
    $order->quantity = array_sum($request->input('quantity')); // Hoặc cách tính khác
    $order->total = $total; // Gán tổng cho trường total
    $order->status = 'đang chờ';

    // Lưu đơn hàng
    if ($order->save()) {
        // Lưu các món ăn đã đặt
        foreach ($request->input('food_id') as $index => $foodId) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id; // Gán order_id từ đơn hàng đã lưu
            $orderItem->food_id = $foodId; // Gán food_id
            $orderItem->quantity = $request->input('quantity')[$index]; // Gán quantity
            $orderItem->price = $food->price; // Gán giá của món ăn

            // Lưu mỗi mục đơn hàng
            $orderItem->save();
        }

        // Chuyển hướng đến trang thành công
        return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
    } else {
        return redirect()->back()->with('error', 'Không thể lưu đơn hàng. Vui lòng thử lại.');
    }
}    public function success()
    {
        return view('checkout.success'); // Tạo view để hiển thị thông báo thành công
    }
}
