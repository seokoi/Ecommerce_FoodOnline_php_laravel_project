<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Lấy các món ăn trong giỏ hàng của người dùng đã đăng nhập
        $cartItems = Auth::user()->cartItems;
        return view('cart.index', compact('cartItems'));
    }

public function add(Request $request, $foodId)
{
    $food = Food::findOrFail($foodId);

    // Kiểm tra trạng thái món ăn
    if ($food->status !== 'available') {
        return redirect()->route('foods.show', $foodId)->with('error', 'Món ăn này hiện không còn hàng.');
    }

    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    // Tìm hoặc tạo mục giỏ hàng
    $cartItem = CartItem::firstOrNew([
        'user_id' => Auth::id(),
        'food_id' => $food->id,
    ]);

    // Cập nhật số lượng
    $cartItem->quantity += $request->input('quantity');
    $cartItem->save();

    return redirect()->route('cart.index')->with('success', 'Món ăn đã được thêm vào giỏ hàng.');
}

    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::find($cartItemId);
        if ($cartItem && $cartItem->user_id == Auth::id()) {
            $food = Food::find($cartItem->food_id);
            if ($food && $food->status === 'available') {
                $cartItem->quantity = $request->input('quantity');
                $cartItem->save();
                return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
            }
            return redirect()->route('cart.index')->with('error', 'Món ăn này hiện không còn hàng.');
        }
        return redirect()->route('cart.index')->with('error', 'Hành động không được phép.');
    }

    public function remove($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        if ($cartItem && $cartItem->user_id == Auth::id()) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Món ăn đã được xóa khỏi giỏ hàng.');
        }

        return redirect()->route('cart.index')->with('error', 'Hành động không được phép.');
    }

public function checkoutSelected(Request $request)
{
    $selectedItems = explode(',', $request->input('selected_items', ''));

    // Check if any items are selected
    if (empty($selectedItems)) {
        return redirect()->route('cart.index')->with('error', 'Bạn chưa chọn sản phẩm nào để mua.');
    }

    // Get selected items from the cart
    $cartItems = CartItem::whereIn('id', $selectedItems)->with('food')->get();

    // Calculate total amount
    $totalAmount = $cartItems->sum(function ($item) {
        return $item->food->price * $item->quantity;
    });

    // Pass the total amount to the view
    return view('checkout.index', compact('cartItems', 'totalAmount'));
}
public function immediatePurchase(Request $request)
{
    $foodId = $request->input('food_id');
    $quantity = $request->input('quantity', 1); // Default to 1 if not provided

    $food = Food::findOrFail($foodId);

    // Calculate total amount for immediate purchase
    $totalAmount = $food->price * $quantity;

    // Pass the food item and total amount to the view
    return view('checkout.index', compact('food', 'quantity', 'totalAmount'));
}
}