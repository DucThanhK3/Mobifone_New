@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="h3 mb-4 text-gray-800">Quản lý đăng ký gói cước</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách đăng ký</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
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
                                <td>{{ $dangKy->id }}</td>
                                <td>{{ optional($dangKy->goiCuoc)->ten_goi ?? 'Không có gói cước' }}</td>
                                <td>{{ optional($dangKy->soDienThoai)->so ?? 'Không có số' }}</td>
                                <td>
                                    @if($dangKy->trang_thai == 'cho_duyet')
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
                                    @if($dangKy->trang_thai == 'cho_duyet')
                                        <form action="{{ route('admin.dangkygoicuoc.approve', $dangKy->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có chắc muốn duyệt đăng ký này?')">Duyệt</button>
                                        </form>
                                        <form action="{{ route('admin.dangkygoicuoc.reject', $dangKy->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn từ chối đăng ký này?')">Từ chối</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection