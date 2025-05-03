@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1 class="h3 mb-4">Quản lý đăng ký gói cước</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách đăng ký chờ duyệt</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Gói cước</th>
                                    <th>Số điện thoại</th>
                                    <th>Ngày đăng ký</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($dangKys) && $dangKys->count() > 0)
                                    @foreach($dangKys as $dangKy)
                                        <tr>
                                            <td>{{ $dangKy->id }}</td>
                                            <td>{{ optional($dangKy->goiCuoc)->ten_goi ?? 'Không có gói cước' }}</td>
                                            <td>{{ optional($dangKy->soDienThoai)->so ?? 'Không có số' }}</td>
                                            <td>{{ $dangKy->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($dangKy->trang_thai == 'pending' || $dangKy->trang_thai == 'cho_duyet')
                                                    <span class="badge badge-warning">Chờ duyệt</span>
                                                @elseif($dangKy->trang_thai == 'approved')
                                                    <span class="badge badge-success">Đã duyệt</span>
                                                @elseif($dangKy->trang_thai == 'da_tu_choi')
                                                    <span class="badge badge-danger">Đã từ chối</span>
                                                @else
                                                    <span class="text-muted">Không xác định</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($dangKy->trang_thai == 'pending' || $dangKy->trang_thai == 'cho_duyet')
                                                    <form action="{{ route('admin.dangkygoicuoc.approve', $dangKy->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">Duyệt</button>
                                                    </form>
                                                    <form action="{{ route('admin.dangkygoicuoc.reject', $dangKy->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">Từ chối</button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">--</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if(isset($dangKys) && $dangKys->hasPages())
                        <div class="d-flex justify-content-end mt-3">
                            {{ $dangKys->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
