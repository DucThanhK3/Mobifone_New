@extends('layouts.frontend')

@section('content')

{{-- ✅ Danh sách Tin Tức --}}
<div class="container py-5">
    <h1 class="text-center text-primary mb-5 fw-bold">Danh sách Tin Tức</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($tinTucs as $tinTuc)
        <div class="col">
            <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden transition-all transform-hover">
                @php
                    // Kiểm tra nếu có hình ảnh trong CSDL và thiết lập đường dẫn
                    $imagePath = $tinTuc->hinh_anh ? asset('assets/images/' . $tinTuc->hinh_anh) : asset('assets/images/default.jpg');
                @endphp
                <img src="{{ $imagePath }}"
                     alt="{{ $tinTuc->tieu_de }}"
                     class="img-fluid p-2 transition-transform"
                     onerror="this.onerror=null; this.src='{{ asset('assets/images/default.jpg') }}';">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold">{{ $tinTuc->tieu_de ?? 'Không có tiêu đề' }}</h5>
                    <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($tinTuc->content), 150) }}</p>
                    <a href="{{ route('frontend.tin_tuc.show', $tinTuc->id) }}" class="btn btn-primary w-100 rounded-pill shadow-sm hover-shadow">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Phân trang --}}
    <div class="mt-5 text-center">
        {{ $tinTucs->links() }}
    </div>
</div>

@endsection

@push('styles')
    <style>
        /* Hiệu ứng hover khi card được di chuột vào */
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Thêm hiệu ứng cho nút */
        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Ảnh thay đổi vị trí nhẹ khi hover */
        .img-fluid {
            transition: transform 0.3s ease;
        }

        .img-fluid:hover {
            transform: scale(1.1); /* Phóng to ảnh khi hover */
        }

        /* Thêm hiệu ứng khi hover lên card */
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Hiệu ứng hover nút */
        .hover-shadow:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Thêm hiệu ứng khi hover vào ảnh */
        .transition-transform {
            transition: transform 0.3s ease;
        }
    </style>
@endpush
