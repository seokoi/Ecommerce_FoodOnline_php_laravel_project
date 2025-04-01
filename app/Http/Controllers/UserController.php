<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $data = User::latest()->paginate(5);

        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Sử dụng validate từ đối tượng Request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User  created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id): View
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id): View
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->getRoleNames()->toArray(); // Lấy danh sách vai trò của người dùng

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Sử dụng validate từ đối tượng Request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']); // Loại bỏ password nếu không có
        }

        $user = User::findOrFail($id);
        $user->update($input);
        $user->syncRoles($request->input('roles')); // Đồng bộ vai trò
                return redirect()->route('users.index')
            ->with('success', 'User  updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Kiểm tra xem người dùng có phải là chính họ không
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Cannot delete your own account.');
        }

        // Xóa người dùng
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User  deleted successfully');
    }

    /**
     * Hiển thị form chỉnh sửa thông tin cá nhân của người dùng.
     *
     * @return \Illuminate\View\View
     */
    public function editProfile(): View
    {
        // Trả về view chỉnh sửa thông tin cá nhân
        return view('profile.edit');
    }

    /**
     * Cập nhật thông tin cá nhân của người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        // Xác thực đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Thêm xác thực cho ảnh
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255'
        ]);

        /** @var \App\Models\User $user **/
        // Lấy người dùng đã đăng nhập
        $user = Auth::user();

        // Cập nhật thông tin người dùng
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        // Xử lý tải lên ảnh
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension(); // Đặt tên cho ảnh
            $request->avatar->move(public_path('images'), $imageName); // Di chuyển ảnh vào thư mục public/images
            $user->avatar = 'images/' . $imageName; // Lưu đường dẫn ảnh vào cơ sở dữ liệu
        }

        $user->save(); // Lưu thông tin vào cơ sở dữ liệu

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    /**
     * Hủy đơn hàng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelOrder(Request $request, $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        // Kiểm tra xem đơn hàng có thể hủy không
        if ($order->status === 'đang chờ') {
            $order->status = 'Đã hủy'; // Cập nhật trạng thái
            $order->cancellation_reason = $request->input('reason'); // Lưu lý do hủy
            $order->save(); // Lưu thay đổi vào cơ sở dữ liệu

            return redirect()->route('user.orders.index')->with('success', 'Đơn hàng đã được hủy thành công.');
        } else {
            // Nếu trạng thái không phải "Đang chờ"
            return redirect()->route('user.orders.index')->with('error', 'Không thể hủy đơn hàng này.');
        }
    }
}