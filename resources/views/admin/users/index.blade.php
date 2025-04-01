@extends('admin.sidebar')

@section('title', 'Danh Sách Người Dùng')

@section('content')
<style>
    .container {
        margin-top: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .alert {
        margin-bottom: 20px;
    }

    .btn {
        margin-right: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    ul {
        padding-left: 20px;
    }

    .btn-warning, .btn-danger {
        margin-top: 5px;
    }
</style>

<div class="container">
    <h1>Danh Sách Người Dùng</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Thêm Người Dùng</a>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Quản lý quyền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->getRoleNames()->isNotEmpty())
                            {{ implode(', ', $user->getRoleNames()->toArray()) }}
                        @else
                            Chưa có vai trò
                        @endif
                    </td>
                    <td>
                        <h5>Quyền:</h5>
                        @if($user->getAllPermissions()->isNotEmpty())
                            <ul>
                                @foreach($user->getAllPermissions() as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Không có quyền nào</p>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Chỉnh Sửa</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
