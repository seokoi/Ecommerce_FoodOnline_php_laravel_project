@vite(['resources/scss/app.scss', 'resources/js/app.js'])

<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 shadow">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logowhite.png') }}" alt="Logo" style="width: 50px; height: 50px; margin-right: 0px;">
            ShopBFox
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('foods.index') }}">Các món ăn</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                @auth
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-light me-2 position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge bg-light text-dark position-absolute top-0 start-100 translate-middle rounded-pill">
                            {{ Auth::check() && Auth::user()->cartItems ? Auth::user()->cartItems->count() : 0 }}
                        </span>
                    </a>
                    <div class="dropdown">
                        <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('images/default-avatar.png') }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; margin-right: 10px; object-fit: cover;">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="navbar-text text-white">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Chỉnh sửa hồ sơ</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">Danh sách đơn hàng</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-outline-light me-2" href="{{ route('login') }}">Đăng nhập</a>
                    <a class="btn btn-outline-light" href="{{ route('register') }}">Đăng ký</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .navbar {
        transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu nền */
    }
    .navbar.scrolled {
        background-color: rgba(0, 0, 0, 0.9); /* Màu nền khi cuộn */
    }
    .navbar-brand img {
        transition: transform 0.3s ease; /* Hiệu ứng phóng to logo */
    }
    .navbar-brand:hover img {
        transform: scale(1.1); /* Phóng to logo khi hover */
    }
</style>

<script>
    // Thay đổi màu nền của navbar khi cuộn
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
