@extends('layouts.frontend')

@section('content')

<div class="container py-5">

    <!-- Tiêu đề Tin Tức -->
    <h1 class="text-center text-primary fw-bold mb-2">{{ $tinTuc->tieu_de }}</h1>
    <p class="text-center text-muted mb-4">{{ $tinTuc->created_at->format('d/m/Y') }}</p>

    <!-- Hình ảnh đại diện -->
    @php
        $imagePath = $tinTuc->hinh_anh ? asset('assets/images/' . $tinTuc->hinh_anh) : asset('assets/images/default.jpg');
    @endphp
    <div class="text-center">
        <img src="{{ $imagePath }}" alt="{{ $tinTuc->tieu_de }}"
             class="img-fluid rounded shadow full-width-image"
             onerror="this.onerror=null; this.src='{{ asset('assets/images/default.jpg') }}';">
    </div>

    <!-- Nội dung bài viết -->
    <div class="content mt-4">
        {!! $tinTuc->noi_dung !!}
    </div>

    <!-- 📰 Mục Tin Khác -->
    @if($tinKhac->count())
        <div class="mt-5">
            <h3 class="text-primary fw-bold mb-4 text-center">🔎 Tin Tức Khác</h3>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($tinKhac as $tin)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 rounded-4 transition-all">
                            @php
                                $image = $tin->hinh_anh ? asset('assets/images/' . $tin->hinh_anh) : asset('assets/images/default.jpg');
                            @endphp
                            <a href="{{ route('frontend.tin_tuc.show', $tin->id) }}">
                                <img src="{{ $image }}" alt="{{ $tin->tieu_de }}" class="card-img-top rounded-top" style="height: 180px; object-fit: cover;">
                            </a>
                            <div class="card-body">
                                <a href="{{ route('frontend.tin_tuc.show', $tin->id) }}" class="text-decoration-none">
                                    <h5 class="card-title fw-bold text-dark mb-2">{{ $tin->tieu_de }}</h5>
                                </a>
                                <p class="card-text text-muted small">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($tin->noi_dung), 100) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Nút quay lại -->
    <div class="text-center mt-5">
        <a href="{{ route('frontend.tin_tuc.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left-circle"></i> Quay lại danh sách
        </a>
    </div>
</div>

@push('styles')
    <style>
        .content {
            line-height: 1.8;
            font-size: 1.125rem;
            font-family: 'Roboto', sans-serif;
            text-align: justify;
            color: #333;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 3rem;
        }

        .content p {
            margin-bottom: 1.5rem;
            text-indent: 2rem;
        }

        .content p::first-letter {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }

        .full-width-image {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin-bottom: 2rem;
            object-fit: cover;
        }

        .btn-outline-primary {
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 30px;
            text-transform: uppercase;
            font-size: 0.95rem;
            border: 2px solid #007bff;
            color: #007bff;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }

        .container {
            max-width: 860px;
        }

        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
@endpush

@endsection
