@extends('layouts.frontend')

@section('content')

<div class="container py-5">
    <h1 class="text-center text-primary fw-bold mb-5">🗞️ Bản Tin Mới Nhất</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($tinTucs as $tinTuc)
        <div class="col">
            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden hover-effect">
                @php
                    $imagePath = $tinTuc->hinh_anh ? asset('assets/images/' . $tinTuc->hinh_anh) : asset('assets/images/default.jpg');
                @endphp

                <a href="{{ route('frontend.tin_tuc.show', $tinTuc->id) }}">
                    <img src="{{ $imagePath }}" class="card-img-top img-hover" alt="{{ $tinTuc->tieu_de }}"
                         style="height: 220px; object-fit: cover;"
                         onerror="this.onerror=null; this.src='{{ asset('assets/images/default.jpg') }}';">
                </a>

                <div class="card-body d-flex flex-column">
                    <p class="text-muted small mb-2">
                        <i class="bi bi-calendar-event"></i> {{ $tinTuc->created_at->format('d/m/Y') }}
                    </p>
                    <h5 class="fw-bold text-dark mb-2">{{ $tinTuc->tieu_de }}</h5>
                    <p class="card-text text-muted small mb-3">
                        {{ \Illuminate\Support\Str::limit(strip_tags($tinTuc->content), 100) }}
                    </p>
                    <a href="{{ route('frontend.tin_tuc.show', $tinTuc->id) }}"
                       class="btn btn-outline-primary mt-auto w-100 rounded-pill fw-semibold">Xem chi tiết</a>
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
    </style>
@endpush
