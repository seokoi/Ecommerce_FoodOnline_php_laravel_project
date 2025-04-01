@extends('admin.sidebar')

@section('content')
<div class="container">
    <h1 class="h2">Thêm Danh Mục Mới</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên Danh Mục</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô Tả</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Tạo Danh Mục</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>
@endsection
