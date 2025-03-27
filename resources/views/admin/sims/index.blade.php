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
    <h2 class="text-center mb-4">Quản lý SIM</h2>

    <button class="btn btn-gradient mb-3" data-bs-toggle="modal" data-bs-target="#modalThem">
        <i class="fas fa-plus"></i> Thêm SIM
    </button>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Số Thuê Bao</th>
                    <th>Nhà Mạng</th>
                    <th>Trạng Thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="danhSachSim">
                @foreach ($sims as $sim)
                <tr id="sim_{{ $sim->id }}">
                    <td>{{ $sim->id }}</td>
                    <td>{{ $sim->phone_number }}</td>
                    <td>{{ $sim->network_provider }}</td>
                    <td>{{ $sim->status }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="moModalSua({{ $sim->id }}, '{{ $sim->phone_number }}', '{{ $sim->network_provider }}', '{{ $sim->status }}')">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="xoaSim({{ $sim->id }})">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalThem" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm SIM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formThem">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Số Thuê Bao</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nhà Mạng</label>
                        <input type="text" class="form-control" id="network_provider" name="network_provider">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trạng Thái</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Đang sử dụng">active</option>
                            <option value="Chưa kích hoạt">inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSua" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa SIM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formSua">
                    @csrf
                    <input type="hidden" id="id_sua" name="id">
                    <div class="mb-3">
                        <label class="form-label">Số Thuê Bao</label>
                        <input type="text" class="form-control" id="phone_number_sua" name="phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nhà Mạng</label>
                        <input type="text" class="form-control" id="network_provider_sua" name="network_provider">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trạng Thái</label>
                        <select class="form-control" id="status_sua" name="status">
                            <option value="Đang sử dụng">active</option>
                            <option value="Chưa kích hoạt">inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#formThem').submit(function (event) {
        event.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('sims.store') }}",
            type: "POST",
            data: formData,
            success: function () {
                Swal.fire("Thành công!", "SIM đã được thêm.", "success");
                location.reload();
            },
            error: function () {
                Swal.fire("Lỗi!", "Không thể thêm SIM.", "error");
            }
        });
    });
});

function moModalSua(id, phone_number, network_provider, status) {
    $('#id_sua').val(id);
    $('#phone_number_sua').val(phone_number);
    $('#network_provider_sua').val(network_provider);
    $('#status_sua').val(status);
    $('#modalSua').modal('show');
}

function xoaSim(id) {
    Swal.fire({
        title: "Bạn có chắc chắn muốn xóa?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/admin/sims/" + id,
                type: "POST",
                data: { _method: "DELETE", _token: "{{ csrf_token() }}" },
                success: function () {
                    Swal.fire("Đã xóa!", "SIM đã được xóa.", "success");
                    location.reload();
                },
                error: function () {
                    Swal.fire("Lỗi!", "Không thể xóa SIM.", "error");
                }
            });
        }
    });
}
</script>
@endsection