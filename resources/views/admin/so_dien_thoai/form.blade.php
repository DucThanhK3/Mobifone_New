<!-- Modal Thêm -->
<div class="modal fade" id="modalThem">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.so_dien_thoai.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>Thêm Số Điện Thoại</h5>
                </div>
                <div class="modal-body">
                    <input type="text" name="so" class="form-control" placeholder="Số điện thoại">
                    <input type="text" name="chu_so_huu" class="form-control mt-2" placeholder="Chủ sở hữu">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
