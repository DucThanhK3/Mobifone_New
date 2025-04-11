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
    <h2 class="text-center mb-4">Quản lý Tin Tức</h2>

    <!-- Nút thêm tin tức -->
    <button class="btn btn-gradient mb-3" data-bs-toggle="modal" data-bs-target="#modalThemTinTuc">
        <i class="fas fa-plus"></i> Thêm Tin Tức
    </button>

    <!-- Bảng danh sách tin tức -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tiêu Đề</th>
                    <th>Hình Ảnh</th>
                    <th>Ngày Tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="danhSachTinTuc">
                @foreach ($tinTucs as $tinTuc)
                <tr id="tinTuc_{{ $tinTuc->id }}">
                    <td>{{ $tinTuc->id }}</td>
                    <td>{{ $tinTuc->tieu_de }}</td>
                    <td>
                        @if($tinTuc->hinh_anh)
                        <img src="{{ asset('assets/images/' . $tinTuc->hinh_anh) }}" width="100" alt="Image">
                        @endif
                    </td>
                    <td>{{ $tinTuc->created_at->format('d/m/Y') }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="moModalSua({{ $tinTuc->id }}, '{{ $tinTuc->tieu_de }}', '{{ $tinTuc->noi_dung }}', '{{ $tinTuc->hinh_anh }}')">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="xoaTinTuc({{ $tinTuc->id }})">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Thêm Tin Tức -->
<div class="modal fade" id="modalThemTinTuc" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Tin Tức</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formThemTinTuc" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tiêu Đề</label>
                        <input type="text" class="form-control" id="tieu_de" name="tieu_de" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình Ảnh</label>
                        <input type="file" class="form-control" id="hinh_anh" name="hinh_anh">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội Dung</label>
                        <textarea class="form-control" id="noi_dung" name="noi_dung" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sửa Tin Tức -->
<div class="modal fade" id="modalSuaTinTuc" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa Tin Tức</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formSuaTinTuc" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_sua" name="id">

                    <div class="mb-3">
                        <label class="form-label">Tiêu Đề</label>
                        <input type="text" class="form-control" id="tieu_de_sua" name="tieu_de" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình Ảnh</label>
                        <input type="file" class="form-control" id="hinh_anh_sua" name="hinh_anh">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội Dung</label>
                        <textarea class="form-control" id="noi_dung_sua" name="noi_dung" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
    // Xử lý thêm tin tức
    $('#formThemTinTuc').submit(function(event) {
        event.preventDefault();
        
        let formData = new FormData(this);
        
        $.ajax({
            url: "{{ route('admin.tintuc.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire("Thành công!", "Tin tức đã được thêm!", "success");
                $('#modalThemTinTuc').modal('hide');
                $('#formThemTinTuc')[0].reset();
                $('tbody').append(`
                    <tr id="tinTuc_${response.tinTuc.id}">
                        <td>${response.tinTuc.id}</td>
                        <td>${response.tinTuc.tieu_de}</td>
                        <td><img src="{{ asset('assets/images/') }}/${response.tinTuc.hinh_anh}" width="100" alt="Image"></td>
                        <td>${response.tinTuc.created_at}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="moModalSua(${response.tinTuc.id}, '${response.tinTuc.tieu_de}', '${response.tinTuc.noi_dung}', '${response.tinTuc.hinh_anh}')">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="xoaTinTuc(${response.tinTuc.id})">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>
                `);
            },
            error: function(xhr) {
                Swal.fire("Lỗi!", "Không thể thêm tin tức!", "error");
            }
        });
    });

    // Xử lý sửa tin tức
    function moModalSua(id, tieu_de, noi_dung, hinh_anh) {
        $('#modalSuaTinTuc #id_sua').val(id);
        $('#modalSuaTinTuc #tieu_de_sua').val(tieu_de);
        $('#modalSuaTinTuc #noi_dung_sua').val(noi_dung);
        $('#modalSuaTinTuc').modal('show');
    }

    $('#formSuaTinTuc').submit(function(event) {
        event.preventDefault();

        let id = $('#id_sua').val();
        let formData = new FormData(this);

        $.ajax({
            url: "/admin/tintuc/" + id,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire("Cập nhật thành công!", "Tin tức đã được cập nhật!", "success");
                $('#modalSuaTinTuc').modal('hide');
                $(`#tinTuc_${id}`).find('td').eq(1).text(response.tinTuc.tieu_de);
                $(`#tinTuc_${id}`).find('td').eq(2).html('<img src="{{ asset('assets/images/') }}/' + response.tinTuc.hinh_anh + '" width="100" alt="Image">');
                $(`#tinTuc_${id}`).find('td').eq(3).text(response.tinTuc.created_at);
            },
            error: function(xhr) {
                Swal.fire("Lỗi!", "Không thể cập nhật tin tức!", "error");
            }
        });
    });

    // Xử lý xóa tin tức
    function xoaTinTuc(id) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa tin tức này?',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/tintuc/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire('Xóa thành công!', 'Tin tức đã được xóa.', 'success');
                        $('#tinTuc_' + id).remove();
                    },
                    error: function(xhr) {
                        Swal.fire('Lỗi!', 'Không thể xóa tin tức này!', 'error');
                    }
                });
            }
        });
    }
</script>

@endsection
