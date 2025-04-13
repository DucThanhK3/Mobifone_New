@extends('layouts.frontend')

@section('content')

<div class="container py-5">
    <!-- Tiêu đề Tin Tức -->
    <h1 class="text-center text-primary mb-4 fw-bold">{{ $tinTuc->tieu_de }}</h1>
    
    <!-- Ngày tháng -->
    <p class="text-center text-muted">{{ $tinTuc->created_at->format('d/m/Y') }}</p>

    <!-- Hiển thị hình ảnh -->
    @php
        $imagePath = $tinTuc->hinh_anh ? asset('assets/images/' . $tinTuc->hinh_anh) : asset('assets/images/default.jpg');
    @endphp
    <img src="{{ $imagePath }}" alt="{{ $tinTuc->tieu_de }}" class="img-fluid rounded-3 mb-4" 
         onerror="this.onerror=null; this.src='{{ asset('assets/images/default.jpg') }}';">

    <!-- Nội dung Tin Tức -->
    <div class="content mt-4">
        {!! $tinTuc->content !!}
    </div>
    
    <!-- Quay lại danh sách tin tức -->
    <div class="text-center mt-5">
        <a href="{{ route('frontend.tin_tuc.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left-circle"></i> Quay lại danh sách
        </a>
    </div>
</div>

@endsection
