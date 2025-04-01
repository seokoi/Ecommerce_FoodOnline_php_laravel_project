<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::query();

        // Tìm kiếm và phân loại
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $foods = $query->paginate(12);
        $categories = Category::all();

        return view('foods.index', compact('foods', 'categories'));
    }

public function show(Food $food)
{
    // Lấy các món ăn liên quan
    $relatedProducts = Food::where('category_id', $food->category_id)
        ->where('id', '!=', $food->id)
        ->take(4)
        ->get();

    return view('foods.show', compact('food', 'relatedProducts'));
}

    public function create()
    {
        $categories = Category::all(); // Lấy tất cả danh mục
        return view('admin.foods.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', // Kiểm tra category_id
            'image' => 'image|nullable'
        ]);

        $food = new Food();
        $food->name = $request->name;
        $food->description = $request->description;
        $food->price = $request->price;
        $food->category_id = $request->category_id; // Lưu category_id

        if ($request->hasFile('image')) {
            $food->image = $request->file('image')->store('images', 'public');
        }

        $food->save();
        return redirect()->route('admin.foods.index')->with('success', 'Food created successfully.');
    }

    public function edit(Food $food)
    {
        $categories = Category::all(); // Lấy tất cả danh mục để hiển thị trong form chỉnh sửa
        return view('admin.foods.edit', compact('food', 'categories'));
    }

    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', // Kiểm tra category_id
            'image' => 'image|nullable'
        ]);

        $food->name = $request->name;
        $food->description = $request->description;
        $food->price = $request->price;
        $food->category_id = $request->category_id; // Cập nhật category_id

        if ($request->hasFile('image')) {
            $food->image = $request->file('image')->store('images', 'public');
        }

        $food->save();
        return redirect()->route('admin.foods.index')->with('success', 'Food updated successfully.');
    }

public function destroy(Food $food)
{
    $food->delete();
    return redirect()->route('admin.foods.index')->with('success', 'Food deleted successfully.');
}
        public function adminIndex(Request $request)
    {
        $query = Food::query();

        // Tìm kiếm
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
            // Tìm kiếm theo thể loại
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }
    $foods = $query->paginate(10); // Phân trang
    $categories = Category::all(); // Lấy tất cả danh mục
    return view('admin.foods.index', compact('foods', 'categories'));
    }

}