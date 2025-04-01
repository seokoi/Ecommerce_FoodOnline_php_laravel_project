@extends('admin.sidebar')

@section('content')
<div class="container">
    <h1 class="h2">Sửa món ăn</h1>

    <form action="{{ route('admin.foods.update', $food) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Tên món ăn</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $food->name }}" required>
        </div>

        <div class="form-group">
            <label for="price">Giá món ăn</label>
            <input type="number" class="form-control" name="price" id="price" value="{{ $food->price }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" name="description" id="description" required>{{ $food->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="category_id">Danh mục</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $food->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image">Hình ảnh</label>
            <input type="file" class="form-control" name="image" id="image">
            @if($food->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" style="width: 100px; height: auto; object-fit: cover;" />
                </div>
            @else
                <span>Không có hình</span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
