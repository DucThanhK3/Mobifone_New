@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <h1 class="text-center display-5 fw-bold text-primary mb-3">LỊCH SỬ ĐĂNG KÝ GÓI CƯỚC</h1>
    <p class="text-center text-muted mb-5">Xem lại các gói cước bạn đã đăng ký</p>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($dangKyGoiCuocs->isEmpty())
        <div class="alert alert-info text-center">Bạn chưa đăng ký gói cước nào.</div>
    @else
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Gói cước</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                            <th>Ngày đăng ký</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dangKyGoiCuocs as $dangKy)
                            <tr>
                                <td>{{ optional($dangKy->goiCuoc)->ten_goi ?? 'Không có gói cước' }}</td>
                                <td>{{ optional($dangKy->soDienThoai)->so_dien_thoai ?? 'Không có số' }}</td>
                                <td>
                                    @if($dangKy->trang_thai == 'chua_duyet')
                                        Chưa duyệt
                                    @elseif($dangKy->trang_thai == 'da_duyet')
                                        Đã duyệt
                                    @elseif($dangKy->trang_thai == 'tu_choi')
                                        Từ chối
                                    @else
                                        Không xác định
                                    @endif
                                </td>
                                <td>{{ $dangKy->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($dangKy->trang_thai == 'chua_duyet')
                                        <form action="{{ route('frontend.goicuocdichvu.destroy', $dangKy->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn hủy đăng ký này?')">Hủy</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection