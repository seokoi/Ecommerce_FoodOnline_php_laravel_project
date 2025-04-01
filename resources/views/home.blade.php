@extends('layouts.app')

@section('content')
<div class="container-fluid p-0"> <!-- Sử dụng container-fluid để chiếm toàn bộ chiều rộng -->
    <div id="foodCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://redsvn.net/wp-content/uploads/2019/03/sample-brazils-national-dish-feijoada-a-hearty-stew-comprised-of-beef-pork-and-black-beans.jpg" class="d-block w-100" alt="Món ăn 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Feijoada</h5>
                    <p>Món ăn quốc dân của Brazil, một món hầm ngon miệng với thịt bò, thịt heo và đậu đen.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://danviet.mediacdn.vn/upload/4-2017/images/2017-10-04/150708937121667-mon-an-ngon-nhat-28.jpg" class="d-block w-100" alt="Món ăn 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Món ăn 2</h5>
                    <p>Mô tả ngắn gọn về món ăn thứ hai.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://vnn-imgs-a1.vgcloud.vn/znews-photo.zadn.vn/w1024/Uploaded/mdf_eioxrd/2019_10_09/6.jpeg?width=260&s=e0AT2uqu0iUebF3MYMzBkw" class="d-block w-100" alt="Món ăn 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Món ăn 3</h5>
                    <p>Mô tả ngắn gọn về món ăn thứ ba.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#foodCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#foodCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="text-center mt-5">
        <h2>Các Món Ăn Khác</h2>
        <p>Khám phá thêm nhiều món ăn hấp dẫn khác trong bộ sưu tập của chúng tôi.</p>
        <a href="{{ route('foods.index') }}" class="btn btn-primary btn-lg">Xem danh sách các món ăn của chúng tôi</a>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa; /* Màu nền nhẹ nhàng */
    }
    h1 {
        font-family: 'Arial', sans-serif;
        font-weight: bold;
        color: #343a40; /* Màu chữ tối */
    }
    h2 {
        font-family: 'Arial', sans-serif;
        color: #007bff; /* Màu chữ chính */
    }
    p {
        font-family: 'Arial', sans-serif;
        color: #6c757d; /* Màu chữ phụ */
    }
    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.5); /* Nền mờ cho chú thích */
        border-radius: 5px; /* Bo góc cho nền chú thích */
    }
    .btn-primary {
        background-color: #007bff; /* Màu nền nút */
        border: none; /* Bỏ viền */
    }
    .btn-primary:hover {
        background-color: #0056b3; /* Màu nền khi hover */
    }
    .carousel-item img {
        height: 500px; /* Đặt chiều cao cố định cho hình ảnh trong carousel */
        object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
        }
    .carousel-item {
        height: 500px; /* Đặt chiều cao cố định cho mỗi item trong carousel */
    }
    .carousel-item img {
        height: 100%; /* Đảm bảo hình ảnh chiếm toàn bộ chiều cao của item */
        object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
