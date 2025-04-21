@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Cột trái: Gói cước -->
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 mb-4">
                <img src="{{ asset('assets/images/' . $goi->hinh_anh) }}" class="card-img-top" alt="{{ $goi->tieu_de }}" style="max-width: 100%; height: auto; border-radius: 10px; margin-top: 20px;">
                <div class="card-body">
                    <h2 class="card-title fw-bold">{{ $goi->tieu_de }}</h2>
                    <hr>
                    <div class="card-text mb-4">
                        <!-- Mô tả chi tiết gói cước -->
                        {!! $goi->mo_ta_chi_tiet !!}
                    </div>
                    <a href="javascript:history.back()" class="btn btn-outline-primary mb-2">← Quay lại</a>
                </div>
            </div>
        </div>

        <!-- Cột phải: Gói cước khác -->
        @if ($otherGoiCuocList->count())
        <div class="col-md-4">
            <h4 class="mb-3">Gói {{ $tenLoaiThueBao }} khác</h4>

            @foreach ($otherGoiCuocList as $item)
            <a href="{{ route('frontend.goicuocloai.show', $item->id) }}" class="text-decoration-none text-dark">
                <div class="card mb-4 border-0 rounded-4 shadow-sm overflow-hidden hover-effect">
                    <img src="{{ asset('assets/images/' . $item->hinh_anh) }}" class="card-img-top img-hover" alt="{{ $item->tieu_de }}" style="height: 180px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $item->tieu_de }}</h5>
                        <p class="card-text text-muted small mb-2">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->mo_ta), 100) }}
                        </p>
                        <p class="card-text mb-0">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->mo_ta_chi_tiet), 150) }}
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection

<style>
    .card-text p {
        font-size: 1rem;
        line-height: 1.5;
    }

    /* Định dạng bảng trong mô tả chi tiết */
    .card-text table {
        width: 100%;
        margin-top: 15px;
        margin-bottom: 15px;
        border-collapse: collapse;
    }

    .card-text table th,
    .card-text table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .card-text table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .card-text ul {
        list-style-type: disc;
        padding-left: 20px;
    }

    .card-text li {
        margin-bottom: 8px;
    }
</style>
