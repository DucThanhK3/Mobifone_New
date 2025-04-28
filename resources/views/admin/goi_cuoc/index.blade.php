@extends('layouts.admin')

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #f8f9fa; }
        .table-hover tbody tr:hover { background-color: #f1f3f5; }
        .btn-gradient { background: linear-gradient(to right, #4facfe, #00f2fe); color: white; border: none; }
        .btn-gradient:hover { background: linear-gradient(to right, #00f2fe, #4facfe); }
    </style>
</head>

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Quản lý Gói Cước</h2>

    <!-- Nút thêm gói cước -->
    <button class="btn btn-gradient mb-3" data-bs-toggle="modal" data-bs-target="#modalThem">
        <i class="fas fa-plus"></i> Thêm gói cước
    </button>

    <!-- Bảng danh sách gói cước -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên Gói</th>
                    <th>Giá</th>
                    <th>Mô Tả</th>
                    <th>Cú pháp ĐK</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="danhSachGoiCuoc">
                @foreach ($goiCuocs as $goiCuoc)
                <tr id="goi_cuoc_{{ $goiCuoc->id }}">
                    <td>{{ $goiCuoc->id }}</td>
                    <td>{{ $goiCuoc->ten_goi }}</td>
                    <td>{{ $goiCuoc->gia }}</td>
                    <td>{{ $goiCuoc->mo_ta }}</td>
                    <td>{{ $goiCuoc->cu_phap_dang_ky }}</td>

                    <td>
                        <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $goiCuoc->id }}" data-ten="{{ $goiCuoc->ten_goi }}" data-gia="{{ $goiCuoc->gia }}" data-mo_ta="{{ $goiCuoc->mo_ta }}" data-cu_phap="{{ $goiCuoc->cu_phap_dang_ky }}">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $goiCuoc->id }}">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Thêm -->
<div class="modal fade" id="modalThem" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Gói Cước</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formThem">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên Gói Cước</label>
                        <input type="text" class="form-control" id="ten_goi" name="ten_goi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" step="0.01" class="form-control" id="gia" name="gia" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="mo_ta" name="mo_ta"></textarea>
                    </div>
                    <div class="mb-3">
                         <label for="cu_phap_dang_ky" class="form-label">Cú pháp đăng ký</label>
                        <input type="text" class="form-control" id="cu_phap_dang_ky" name="cu_phap_dang_ky">
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sửa -->
<div class="modal fade" id="modalSua" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa Gói Cước</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formSua">
                    @csrf
                    <input type="hidden" id="id_sua" name="id">

                    <div class="mb-3">
                        <label class="form-label">Tên Gói Cước</label>
                        <input type="text" class="form-control" id="ten_goi_sua" name="ten_goi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" step="0.01" class="form-control" id="gia_sua" name="gia">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="mo_ta_sua" name="mo_ta"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="cu_phap_dang_ky_sua" class="form-label">Cú pháp đăng ký</label>
                        <input type="text" class="form-control" id="cu_phap_dang_ky_sua" name="cu_phap_dang_ky">
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS: Xử lý thêm, sửa, xóa -->
<script>
$(document).ready(function () {

    // Xử lý thêm gói cước
    $('#formThem').submit(function (event) {
        event.preventDefault(); // Ngăn chặn form gửi mặc định và tải lại trang

        let formData = $(this).serialize(); // Lấy dữ liệu từ form

        $.ajax({
            url: "{{ route('admin.goi_cuoc.store') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Thêm gói cước vào bảng mà không cần tải lại trang
                        let newRow = ` 
                            <tr id="goi_cuoc_${response.goicuoc.id}">
                                <td>${response.goicuoc.id}</td>
                                <td>${response.goicuoc.ten_goi}</td>
                                <td>${response.goicuoc.gia}</td>
                                <td>${response.goicuoc.mo_ta}</td>
                                <td>${response.goicuoc.cu_phap_dang_ky}</td>

                                <td>
                                    <button class="btn btn-warning btn-sm btn-edit" data-id="${response.goicuoc.id}" data-ten="${response.goicuoc.ten_goi}" data-gia="${response.goicuoc.gia}" data-mo_ta="${response.goicuoc.mo_ta}" data-cu_phap="${response.goicuoc.cu_phap_dang_ky}">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="${response.goicuoc.id}">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>`;
                        $('#danhSachGoiCuoc').append(newRow); // Thêm dòng vào bảng
                        $('#modalThem').modal('hide'); // Đóng modal sau khi thêm
                        $('#formThem')[0].reset(); // Xóa dữ liệu trong form
                    }
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: xhr.responseJSON.message || 'Không thể thêm gói cước!',
                });
            }
        });
    });

    // Xử lý sửa gói cước
    $('#formSua').submit(function (event) {
        event.preventDefault(); // Ngăn chặn form gửi mặc định và tải lại trang

        let formData = $(this).serialize() + "&_method=PUT";

        $.ajax({
            url: "/admin/goi_cuoc/" + $('#id_sua').val(),
            type: "POST",
            data: formData,
            success: function (response) {
                Swal.fire("Cập nhật thành công!", response.message, "success");
                $('#modalSua').modal('hide');
                // Cập nhật thông tin gói cước trong bảng
                let updatedRow = ` 
                    <td>${response.goicuoc.id}</td>
                    <td>${response.goicuoc.ten_goi}</td>
                    <td>${response.goicuoc.gia}</td>
                    <td>${response.goicuoc.mo_ta}</td>
                    <td>${response.goicuoc.cu_phap_dang_ky}</td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-edit" data-id="${response.goicuoc.id}" data-ten="${response.goicuoc.ten_goi}" data-gia="${response.goicuoc.gia}" data-mo_ta="${response.goicuoc.mo_ta}" data-cu_phap="${response.goicuoc.cu_phap_dang_ky}">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="${response.goicuoc.id}">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </td>
                `;

                $(`#goi_cuoc_${response.goicuoc.id}`).html(updatedRow); // Cập nhật dòng bảng
            },
            error: function (xhr) {
                Swal.fire("Có lỗi!", "Không thể cập nhật gói cước.", "error");
            }
        });
    });

    // Xử lý xóa gói cước
    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Bạn chắc chắn muốn xóa?',
            text: 'Sau khi xóa, bạn sẽ không thể khôi phục lại dữ liệu!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/goi_cuoc/" + id,
                    type: 'DELETE',
                    success: function (response) {
                        Swal.fire("Đã xóa!", response.message, "success");
                        $(`#goi_cuoc_${id}`).remove(); // Xóa dòng khỏi bảng
                    },
                    error: function () {
                        Swal.fire("Có lỗi!", "Không thể xóa gói cước này.", "error");
                    }
                });
            }
        });
    });

    // Hiển thị modal sửa khi nhấn vào nút sửa
    $(document).on('click', '.btn-edit', function () {
        let id = $(this).data('id');
        let ten = $(this).data('ten');
        let gia = $(this).data('gia');
        let mo_ta = $(this).data('mo_ta');
        let cu_phap = $(this).data('cu_phap');

        $('#id_sua').val(id);
        $('#ten_goi_sua').val(ten);
        $('#gia_sua').val(gia);
        $('#mo_ta_sua').val(mo_ta);
        $('#cu_phap_dang_ky_sua').val(cu_phap);

        $('#modalSua').modal('show');
    });

});
</script>
@endsection
