@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-4">Chỉnh Sửa Hồ Sơ</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tên</label>
            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="form-control" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số Điện Thoại</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone) }}" class="form-control" placeholder="Nhập số điện thoại">
            @error('phone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa Chỉ</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', Auth::user()->address) }}" placeholder="Nhập địa chỉ">
            <button type="button" class="btn btn-secondary mt-2" id="fetch-address">Lấy Địa Chỉ</button>
            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="profile_picture" class="form-label">Ảnh Đại Diện</label>
            <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('images/default-avatar.png') }}" alt="Current Avatar" class="img-thumbnail mb-2" style="width: 150px; height: 150px; object-fit: cover;">
            <input type="file" name="avatar" id="profile_picture" class="form-control">
            @error('avatar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật Hồ Sơ</button>
    </form>
</div>

<script>
    document.getElementById('fetch-address').addEventListener('click', function() {
        fetch('/api/locations')
            .then(response => response.json())
            .then(data => {
                // Xử lý dữ liệu địa chỉ ở đây
                console.log(data);
                // Bạn có thể hiển thị dữ liệu trong một dropdown hoặc một modal
            })
            .catch(error => console.error('Error fetching address:', error));
    });
</script>
@endsection
