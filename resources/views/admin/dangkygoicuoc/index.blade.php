@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Quản lý yêu cầu đăng ký gói cước</h2>

    @foreach ($dangKys as $dangKy)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    {{ optional($dangKy->user)->name ?? 'Không có người dùng' }} - 
                    {{ optional($dangKy->goiCuoc)->ten_goi ?? 'Không có gói cước' }}
                </h5>
                <p class="card-text">
                    Trạng thái:
                    @if ($dangKy->trang_thai == 'chua_duyet')
                        Chưa duyệt
                    @elseif ($dangKy->trang_thai == 'da_duyet')
                        Đã duyệt
                    @elseif ($dangKy->trang_thai == 'tu_choi')
                        Từ chối
                    @else
                        Không xác định
                    @endif
                </p>
                <a href="{{ route('admin.dang_ky_goi_cuoc.approve', $dangKy->id) }}" 
                   class="btn btn-success" 
                   {{ $dangKy->trang_thai == 'da_duyet' ? 'disabled' : '' }}>Duyệt</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
