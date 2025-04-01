@extends('admin.sidebar')

@section('title', 'Chỉnh Sửa Người Dùng')

@section('content')
<div class="container">
    <h1>Chỉnh Sửa Người Dùng</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" class="form-control">
            <small class="form-text text-muted">Để trống nếu không muốn thay đổi mật khẩu.</small>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Xác nhận Mật khẩu:</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="form-group">
            <label for="role">Vai trò:</label>
            <select name="role" class="form-control" required>
                <option value="">Chọn vai trò</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="permissions">Quản lý quyền:</label>
            <div>
                @foreach($permissions as $permission)
                    <div class="form-check">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}
                            class="form-check-input" id="permission_{{ $permission->id }}">
                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật Người Dùng</button>
    </form>
</div>
@endsection
