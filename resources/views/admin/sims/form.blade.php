@extends('layouts.app')

@section('content')
<div class="container">
    <h2>QUẢN LÝ SIM</h2>
    
    <!-- Nút mở modal thêm SIM -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalThemSim">
        + Thêm SIM
    </button>

    <!-- Modal Thêm SIM -->
    <div class="modal fade" id="modalThemSim">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('sims.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm SIM</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>SỐ THUÊ BAO</label>
                            <input type="text" name="so_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>NHÀ MẠNG</label>
                            <input type="text" name="network_provider" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>TRẠNG THÁI</label>
                            <select name="status" class="form-control">
                            <option value="active">Hoạt động</option>
                            <option value="inactive">Chưa kích hoạt</option>
                            <option value="locked">Bị khóa</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">LƯU</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
