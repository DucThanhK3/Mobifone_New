@extends('layouts.admin')

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Thư viện Alert đẹp -->
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
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="moModalSua({{ $goiCuoc->id }}, '{{ $goiCuoc->ten_goi }}', '{{ $goiCuoc->gia }}', '{{ $goiCuoc->mo_ta }}')">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="xoaGoiCuoc({{ $goiCuoc->id }})">
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
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS: Xử lý thêm, sửa, xóa -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('#formThem').submit(function (event) {
        event.preventDefault(); // Ngăn chặn form gửi mặc định và tải lại trang

        let formData = $(this).serialize(); // Lấy dữ liệu từ form

        $.ajax({
            url: "{{ route('goi_cuoc.store') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                // Hiển thị thông báo thành công
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Cập nhật bảng ngay lập tức
                        $('tbody').append(`
                            <tr id="row_${response.goicuoc.id}">
                                <td>${response.goicuoc.id}</td>
                                <td>${response.goicuoc.ten_goi}</td>
                                <td>${response.goicuoc.gia}</td>
                                <td>${response.goicuoc.mo_ta}</td>
                                <td>
                                    <button class="btn btn-warning" onclick="moModalSua(${response.goicuoc.id}, '${response.goicuoc.ten_goi}', '${response.goicuoc.gia}', '${response.goicuoc.mo_ta}')">Sửa</button>
                                    <button class="btn btn-danger" onclick="xoaGoiCuoc(${response.goicuoc.id})">Xóa</button>
                                </td>
                            </tr>
                        `);
                        $('#modalThem').modal('hide'); // Đóng modal sau khi thêm thành công
                        $('#formThem')[0].reset(); // Xóa dữ liệu trong form
                    }
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Không thể thêm gói cước!',
                });
            }
        });
    });
});
$('#formSua').submit(function (event) {
    event.preventDefault();

    let id = $('#id_sua').val();
    let tenGoi = $('#ten_goi_sua').val();
    let gia = $('#gia_sua').val();
    let moTa = $('#mo_ta_sua').val();

    if (!tenGoi || tenGoi.trim() === "") {
        Swal.fire("Lỗi!", "Tên gói cước không được để trống!", "error");
        return;
    }

    let formData = $(this).serialize() + "&_method=PUT";

    $.ajax({
        url: "/admin/goi_cuoc/" + id,
        type: "POST",
        data: formData,
        success: function (response) {
            Swal.fire("Cập nhật thành công!", response.message, "success");
            $('#modalSua').modal('hide');
            location.reload();
        },
        error: function (xhr) {
            console.log("❌ Lỗi cập nhật:", xhr.responseText);
            Swal.fire("Lỗi!", "Không thể cập nhật gói cước!", "error");
