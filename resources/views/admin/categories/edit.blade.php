@extends('admin.sidebar')

@section('content')
<div class="container">
    <h1 class="h2">Sửa Danh Mục</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('POST')
        <div class="mb-3">
            <label for="name" class="form-label">Tên Danh Mục</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô Tả</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $category->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>
@endsection
