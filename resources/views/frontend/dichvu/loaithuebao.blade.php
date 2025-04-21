@extends('layouts.frontend')

@section('content')
<style>
    .navbar-nav {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        position: relative;
        z-index: 10;
    }

    .navbar-nav .nav-item {
        margin-right: 20px;
    }

    .navbar-nav .nav-item a {
        padding: 10px 25px;
    }

    #myTab {
        margin-top: 30px;
    }

    .tab-content {
        margin-top: 50px;
    }

    .hover-effect:hover {
        transform: translateY(-6px);
        transition: 0.3s ease;
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
    }

    .img-hover {
        transition: transform 0.4s ease-in-out;
    }

    .img-hover:hover {
        transform: scale(1.05);
    }

    .card-title {
        font-size: 1.2rem;
        color: #222;
    }

    .btn-outline-primary {
        transition: all 0.3s ease;
        padding: 10px 25px;
        font-size: 0.95rem;
        border-radius: 30px;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .card-body {
        padding: 1.5rem;
    }

    .container {
        max-width: 1140px;
    }

    .dropdown-menu {
        display: none;
    }

    .nav-item:hover .dropdown-menu {
        display: block;
    }

    .card-text table {
        width: 100%;
        margin-top: 15px;
        margin-bottom: 15px;
        border-collapse: collapse;
    }

    .card-text table th,
    .card-text table td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }

    .card-text table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    /* Điều chỉnh vị trí các nút bên dưới sidebar */
    .nav-button-wrapper {
        margin-top: 150px;
        display: flex;
        align-items: center;
    }
</style>

<div class="container py-4">
    {{-- Navbar Nút --}}
    <div class="nav-button-wrapper mb-4">
        <a href="/" class="btn btn-outline-primary mx-2">Trang chủ</a>
        <a href="{{ route('frontend.goicuocloai.index') }}" class="btn btn-outline-primary mx-2">Loại thuê bao</a>
        <a class="btn btn-outline-primary mx-2 dropdown-toggle" id="dichvuDropdown" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Dịch vụ</a>
        <ul class="dropdown-menu" aria-labelledby="dichvuDropdown">
            <li><a class="dropdown-item" href="#">Loại thuê bao</a></li>
            <li><a class="dropdown-item" href="#">Gói cước</a></li>
            <li><a class="dropdown-item" href="#">Gói data</a></li>
            <li><a class="dropdown-item" href="#">Dịch vụ</a></li>
            <li><a class="dropdown-item" href="#">Đăng ký hòa mạng</a></li>
            <li><a class="dropdown-item" href="#">Dịch vụ quốc tế</a></li>
        </ul>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active fw-bold" id="trac-truoc-tab" data-bs-toggle="tab" href="#trac-truoc" role="tab">Trả trước</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-bold" id="tra-sau-tab" data-bs-toggle="tab" href="#tra-sau" role="tab">Trả sau</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-bold" id="fast-connect-tab" data-bs-toggle="tab" href="#fast-connect" role="tab">Fast Connect</a>
        </li>
    </ul>

    {{-- Nội dung tab --}}
    <div class="tab-content" id="myTabContent">
        {{-- Trả trước --}}
        <div class="tab-pane fade show active" id="trac-truoc" role="tabpanel">
            <div class="row">
                @foreach($traTruoc as $goi)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden hover-effect">
                        <img src="{{ asset('assets/images/' . $goi->hinh_anh) }}" class="card-img-top img-hover" alt="{{ $goi->tieu_de }}" style="height: 220px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $goi->tieu_de }}</h5>
                            <p class="card-text text-muted small mb-3">{{ \Illuminate\Support\Str::limit(strip_tags($goi->mo_ta_chi_tiet), 100) }}</p>
                            <a href="{{ route('frontend.goicuocloai.show', $goi->id) }}" class="btn btn-outline-primary mt-auto w-100 rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Trả sau --}}
        <div class="tab-pane fade" id="tra-sau" role="tabpanel">
            <div class="row">
                @foreach($traSau as $goi)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden hover-effect">
                        <img src="{{ asset('assets/images/' . $goi->hinh_anh) }}" class="card-img-top img-hover" alt="{{ $goi->tieu_de }}" style="height: 220px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $goi->tieu_de }}</h5>
                            <p class="card-text text-muted small mb-3">{{ \Illuminate\Support\Str::limit(strip_tags($goi->mo_ta_chi_tiet), 100) }}</p>
                            <a href="{{ route('frontend.goicuocloai.show', $goi->id) }}" class="btn btn-outline-primary mt-auto w-100 rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Fast Connect --}}
        <div class="tab-pane fade" id="fast-connect" role="tabpanel">
            <div class="row">
                @foreach($fastConnect as $goi)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden hover-effect">
                        <img src="{{ asset('assets/images/' . $goi->hinh_anh) }}" class="card-img-top img-hover" alt="{{ $goi->tieu_de }}" style="height: 220px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $goi->tieu_de }}</h5>
                            <p class="card-text text-muted small mb-3">{{ \Illuminate\Support\Str::limit(strip_tags($goi->mo_ta_chi_tiet), 100) }}</p>
                            <a href="{{ route('frontend.goicuocloai.show', $goi->id) }}" class="btn btn-outline-primary mt-auto w-100 rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
