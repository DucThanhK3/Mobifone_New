@extends('layouts.admin')

@section('title', 'Trang Chủ Quản Trị - Mobifone')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Trang Chủ Quản Trị</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ \App\Models\SoDienThoai::count() }}</h3>
                            <p>Số Điện Thoại</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <a href="{{ route('so_dien_thoai.index') }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ \App\Models\Sim::count() }}</h3>
                            <p>SIM</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-sim-card"></i>
                        </div>
                        <a href="{{ route('sims.index') }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ \App\Models\GoiCuoc::count() }}</h3>
                            <p>Gói Cước</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <a href="{{ route('goi_cuoc.index') }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ \App\Models\TinTuc::count() }}</h3>
                            <p>Tin Tức</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <a href="{{ route('tintuc.index') }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">
                    <!-- Custom tabs (Charts or other content) -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Thống Kê Nhanh
                            </h3>
                        </div>
                        <div class="card-body">
                            <p>Chỗ này có thể thêm biểu đồ hoặc thông tin thống kê (ví dụ: số lượng đăng ký gói cước theo ngày).</p>
                        </div>
                    </div>
                </section>
                <!-- Right col -->
                <section class="col-lg-5 connectedSortable">
                    <!-- Recent Activity -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                Hoạt Động Gần Đây
                            </h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li>Đăng ký gói cước mới bởi khách hàng #1234</li>
                                <li>Tin tức "Khuyến mãi tháng 5" được đăng</li>
                                <li>SIM #5678 được kích hoạt</li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
@endsection