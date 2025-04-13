@extends('layouts.admin')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Font Awesome -->

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
    <h2 class="text-center mb-4">Quản lý Tin Tức</h2>

    <button class="btn btn-gradient mb-3" data-bs-toggle="modal" data-bs-target="#modalThemTinTuc">
        <i class="fas fa-plus"></i> Thêm Tin Tức
    </button>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tiêu Đề</th>
                    <th>Hình Ảnh</th>
                    <th>Nội Dung</th>
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
                    <td>{{ $tinTuc->noi_dung }}</td>
                    <td>
                        @if($tinTuc->created_at)
                            {{ $tinTuc->created_at->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                            onclick='moModalSua(@json($tinTuc->id), @json($tinTuc->tieu_de), @json($tinTuc->noi_dung), @json($tinTuc->hinh_anh))'>
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

<!-- Modal Thêm -->
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

<!-- Modal Sửa -->
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
                    <input type="hidden" name="_method" value="PUT">
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
    // Mở modal sửa và gán dữ liệu
    function moModalSua(id, tieu_de, noi_dung, hinh_anh) {
        $('#id_sua').val(id);
        $('#tieu_de_sua').val(tieu_de);
        $('#noi_dung_sua').val(noi_dung);
        $('#modalSuaTinTuc').modal('show');
    }

    // Thêm tin tức
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
                        <td><img src="{{ asset('assets/images') }}/${response.tinTuc.hinh_anh}" width="100" alt="Image"></td>
                        <td>${response.tinTuc.noi_dung}</td>
                        <td>${response.tinTuc.created_at}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                onclick='moModalSua(${response.tinTuc.id}, ${JSON.stringify(response.tinTuc.tieu_de)}, ${JSON.stringify(response.tinTuc.noi_dung)}, ${JSON.stringify(response.tinTuc.hinh_anh)})'>
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

    // Sửa tin tức
    $('#formSuaTinTuc').submit(function(event) {
        event.preventDefault();

        let id = $('#id_sua').val();
        let formData = new FormData(this);
        formData.append('_method', 'PUT');

        $.ajax({
            url: '/admin/tintuc/' + id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire("Cập nhật thành công!", "Tin tức đã được cập nhật!", "success");
                $('#modalSuaTinTuc').modal('hide');

                let row = $('#tinTuc_' + id);
                row.find('td:eq(1)').text(response.tinTuc.tieu_de);
                row.find('td:eq(2)').html('<img src="{{ asset("assets/images/") }}/' + response.tinTuc.hinh_anh + '" width="100">');
                row.find('td:eq(3)').text(response.tinTuc.noi_dung);
            },
            error: function(xhr) {
                Swal.fire("Lỗi!", "Không thể cập nhật tin tức!", "error");
            }
        });
    });

    // Xóa tin tức
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
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Đã xóa!', 'Tin tức đã bị xóa.', 'success');
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
