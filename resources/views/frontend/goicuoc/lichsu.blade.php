@extends('layouts.frontend')

@section('content')
<div class="container py-5">
@if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

    {{-- Tiêu đề --}}
    <h2 class="text-center text-primary fw-bold mb-4">
        📄 Lịch sử đăng ký gói cước của <span class="text-dark">{{ $so->so }}</span>
    </h2>

    {{-- Bảng lịch sử --}}
    <div class="table-responsive shadow rounded-4 bg-white p-3">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-primary text-center">
                <tr>
                    <th>Tên gói</th>
                    <th>Giá</th>
                    <th>Ngày đăng ký</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dangKys as $dk)
                <tr>
                    <td class="fw-semibold text-primary">{{ $dk->goiCuoc->ten_goi }}</td>
                    <td>{{ number_format($dk->goiCuoc->gia) }} VND</td>
                    <td>{{ $dk->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        <form action="{{ route('frontend.huy_dang_ky', $dk->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy gói này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                ❌ Hủy
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted fst-italic py-4">
                        Bạn chưa đăng ký gói cước nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
