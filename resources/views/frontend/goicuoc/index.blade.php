@extends('layouts.frontend')

@section('content')

{{-- ✅ Carousel banner đầu trang --}}
<style>
    /* Hiệu ứng mờ và trượt caption từ dưới lên */
    .carousel-caption {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.8s ease-in-out;
    }

    .carousel-item.active .carousel-caption {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="container-fluid px-0">
    <div id="bannerCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">

            @php
                $banners = [
                    ['image' => 'goicuoc.jpg', 'title' => 'Chào mừng đến với Mobifone', 'desc' => 'Kết nối nhanh – Giá cước hấp dẫn'],
                    ['image' => 'goicuoc1.jpg', 'title' => 'Ưu đãi gói cước cực sốc', 'desc' => '1GB/ngày, gọi miễn phí, data thả ga'],
                    ['image' => 'goicuoc2.jpg', 'title' => 'Đăng ký nhanh qua SMS', 'desc' => 'Miễn phí gửi tin đến 9084'],
                    ['image' => 'goicuoc4.jpg', 'title' => 'Dịch vụ toàn quốc', 'desc' => 'Phủ sóng khắp Việt Nam'],
                    ['image' => 'goicuoc5.jpg', 'title' => 'Chăm sóc tận tâm', 'desc' => 'Hỗ trợ khách hàng 24/7'],
                ];
            @endphp

            @foreach ($banners as $index => $banner)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }} position-relative">
                <img src="{{ asset('assets/images/' . $banner['image']) }}" 
                     class="d-block w-100" 
                     style="height: 400px; object-fit: cover;" 
                     alt="Banner {{ $index + 1 }}">
                <div class="carousel-caption bg-dark bg-opacity-50 rounded-3 px-4 py-3 shadow">
                    <h5 class="fw-bold text-white">{{ $banner['title'] }}</h5>
                    <p class="text-light mb-0">{{ $banner['desc'] }}</p>
                </div>
            </div>
            @endforeach

        </div>

        {{-- Nút điều hướng --}}
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Sau</span>
        </button>
    </div>
</div>



{{-- ✅ Danh sách Gói Cước --}}
<div class="container py-5">
    <h1 class="text-center text-primary mb-5 fw-bold">Danh sách Gói Cước</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($goiCuocs as $goi)
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                @php
                    $fallback = 'default-' . $goi->ma_goi . '.jpg';
                @endphp
                <img src="{{ asset('assets/images/' . $goi->hinh_anh) }}"
                     alt="{{ $goi->ten_goi }}"
                     class="img-fluid p-2"
                     onerror="this.onerror=null; this.src='{{ asset('assets/images/' . $fallback) }}';">

                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold">{{ $goi->ten_goi }}</h5>
                    <p class="card-text text-muted small">{{ $goi->mo_ta }}</p>
                    <p class="card-text fw-semibold text-success">{{ number_format($goi->gia) }} VND</p>

                    <button 
                        class="btn btn-primary w-100 btn-dang-ky"
                        data-id="{{ $goi->id }}"
                        data-ten="{{ $goi->ten_goi }}"
                        data-cuphap="{{ $goi->cu_phap_dang_ky }}">
                        Đăng ký
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-5 text-center">
        <a href="{{ route('frontend.lichsu') }}" class="text-decoration-none text-primary fw-semibold">
            Xem lịch sử đăng ký gói cước
        </a>
    </div>
</div>

{{-- ✅ Modal hiển thị cú pháp đăng ký --}}
<div id="confirmModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Cú Pháp Đăng Ký</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <p id="modalText" class="text-center text-dark"></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Script xử lý modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.btn-dang-ky');
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const ten = button.dataset.ten;
                const cuPhap = button.dataset.cuphap;

                document.getElementById('modalText').innerHTML = `
                    Cú pháp (miễn phí SMS đến 9084) <strong>${ten}</strong><br>
                    Cú pháp: <span class="badge bg-secondary">${cuPhap}</span>
                `;

                modal.show();
            });
        });
    });
</script>

@endsection
