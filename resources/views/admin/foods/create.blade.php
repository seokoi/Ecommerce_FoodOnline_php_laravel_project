@extends('admin.sidebar')

@section('content')
<div class="container">
    <h1 class="h2">Thêm món ăn</h1>

    <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Tên món ăn</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="price">Giá món ăn</label>
            <input type="number" class="form-control" name="price" id="price" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="category_id">Danh mục</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image">Hình ảnh</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>

        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
</div>
@endsection
