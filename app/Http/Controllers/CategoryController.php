<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    // Hiển thị danh sách danh mục
public function index(Request $request)
{
    $categories = Category::paginate(10); // Sử dụng paginate
    return view('admin.categories.index', compact('categories'));
}

    // Hiển thị form tạo danh mục mới
    public function create()
    {
        return view('admin.categories.create'); // Tạo view cho form
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category')); // Tạo view cho form sửa
    }


// Lưu danh mục mới
// Lưu danh mục mới
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ]);

    $slug = Str::slug($request->name);
    Category::create($request->only('name', 'description') + ['slug' => $slug]);

    return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được tạo thành công.');
}

// Cập nhật danh mục
// Cập nhật danh mục
public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ]);

    $slug = Str::slug($request->name);
    $category->update($request->only('name', 'description') + ['slug' => $slug]);

    return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật thành công.');
}

    // Xóa danh mục
    public function destroy(Category $category)
    {
        $category->delete(); // Xóa danh mục

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa thành công.');
    }
}