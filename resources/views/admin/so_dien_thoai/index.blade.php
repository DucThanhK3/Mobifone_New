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
    <h2 class="text-center mb-4">Quản lý số điện thoại</h2>

    <!-- Nút thêm số điện thoại -->
    <button class="btn btn-gradient mb-3" data-bs-toggle="modal" data-bs-target="#modalThem">
        <i class="fas fa-plus"></i> Thêm số điện thoại
    </button>

    <!-- Bảng danh sách số điện thoại -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Số</th>
                    <th>Chủ sở hữu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="danhSachSo">
                @foreach ($soDienThoai as $so)
                <tr id="so_{{ $so->id }}">
                    <td>{{ $so->id }}</td>
                    <td>{{ $so->so }}</td>
                    <td>{{ $so->chu_so_huu }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="moModalSua({{ $so->id }}, '{{ $so->so }}', '{{ $so->chu_so_huu }}')">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="xoaSo({{ $so->id }})">
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
                <h5 class="modal-title">Thêm Số Điện Thoại</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formThem">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Số Điện Thoại</label>
                        <input type="text" class="form-control" id="so" name="so" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Chủ Sở Hữu</label>
                        <input type="text" class="form-control" id="chu_so_huu" name="chu_so_huu" value="Chưa có ai sở hữu">
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
                <h5 class="modal-title">Sửa Số Điện Thoại</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formSua">
                    @csrf
                    <input type="hidden" id="id_sua" name="id">

                    <div class="mb-3">
                        <label class="form-label">Số Điện Thoại</label>
                        <input type="text" class="form-control" id="so_sua" name="so" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Chủ Sở Hữu</label>
                        <input type="text" class="form-control" id="chu_so_huu_sua" name="chu_so_huu">
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
            url: "{{ route('so_dien_thoai.store') }}",
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
                            <tr id="row_${response.so.id}">
                                <td>${response.so.id}</td>
                                <td>${response.so.so}</td>
                                <td>${response.so.chu_so_huu}</td>
                                <td>
                                    <button class="btn btn-warning" onclick="moModalSua(${response.so.id}, '${response.so.so}', '${response.so.chu_so_huu}')">Sửa</button>
                                    <button class="btn btn-danger" onclick="xoaSo(${response.so.id})">Xóa</button>
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
                    text: 'Không thể thêm số điện thoại!',
                });
            }
        });
    });
});
$('#formSua').submit(function (event) {
    event.preventDefault();

    let id = $('#id_sua').val();
    let so = $('#so_sua').val();
    let chuSoHuu = $('#chu_so_huu_sua').val();

    console.log("🔄 ID gửi AJAX:", id);
    console.log("📞 Số gửi AJAX:", so);
    console.log("👤 Chủ sở hữu gửi AJAX:", chuSoHuu);

    if (!so || so.trim() === "") {
        Swal.fire("Lỗi!", "Số điện thoại không được để trống!", "error");
        return;
    }

    let formData = $(this).serialize() + "&_method=PUT";

    $.ajax({
        url: "/admin/so_dien_thoai/" + id,
        type: "POST",
        data: formData,
        success: function (response) {
            Swal.fire("Cập nhật thành công!", response.message, "success");
            $('#modalSua').modal('hide');
            location.reload();
        },
        error: function (xhr) {
            console.log("❌ Lỗi cập nhật:", xhr.responseText);
            Swal.fire("Lỗi!", "Không thể cập nhật số điện thoại!", "error");
        }
    });
});




function moModalSua(id, so, chuSoHuu) {
    $('#modalSua #id_sua').val(id); // ✅ Đúng ID input
    $('#modalSua #so_sua').val(so);
    $('#modalSua #chu_so_huu_sua').val(chuSoHuu);
    $('#modalSua').modal('show');
}


</script>
<script>
 function xoaSo(id) {
    Swal.fire({
        title: "Bạn có chắc chắn muốn xóa?",
        text: "Hành động này không thể hoàn tác!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/admin/so_dien_thoai/" + id, // Đúng đường dẫn
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    Swal.fire("Đã xóa!", response.message, "success");
                    $("#row_" + id).remove();
                },
                error: function () {
                    Swal.fire("Lỗi!", "Không thể xóa số điện thoại!", "error");
                }
            });
        }
    });
}


</script>

@endsection
