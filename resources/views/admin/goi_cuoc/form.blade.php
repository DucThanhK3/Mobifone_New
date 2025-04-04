<!-- Modal Thêm Gói Cước -->
<div class="modal fade" id="modalThemGoiCuoc">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('goi_cuoc.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>Thêm Gói Cước</h5>
                </div>
                <div class="modal-body">
                    <input type="text" name="ten_goi" class="form-control" placeholder="Tên gói cước" required>
                    <input type="number" step="0.01" name="gia" class="form-control mt-2" placeholder="Giá" required>
                    <textarea name="mo_ta" class="form-control mt-2" placeholder="Mô tả" rows="3"></textarea>
                   
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
