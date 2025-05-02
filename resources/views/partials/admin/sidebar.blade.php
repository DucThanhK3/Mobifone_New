<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.html" class="brand-link">
    <img src="dist/img/OIP.jpg" alt="Mobifone Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">MOBIFONE</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ asset('assets/images/' . (Auth::guard('admin')->user()->avatar ?? 'avatars/default.png')) }}"
           class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
    </div>
  </div>




    <!-- Sidebar Search Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Tìm kiếm" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
    <a href="{{ route('admin.home') }}" class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p> Dashboard </p>
    </a>
</li>

    <!-- Quản lý thuê bao -->
    <li class="nav-item">
  <a href="{{ route('so_dien_thoai.index') }}" class="nav-link">
    <i class="nav-icon fas fa-users"></i>
    <p> Quản lý số Thuê bao </p>
  </a>
</li>

<!-- Quản lý SIM -->
<li class="nav-item">
  <a href="{{ route('sims.index') }}" class="nav-link">
    <i class="nav-icon fas fa-sim-card"></i>
    <p> Quản lý SIM </p>
  </a>
</li>




       <!-- Gói cước -->
<li class="nav-item">
  <a href="{{ route('goi_cuoc.index') }}" class="nav-link">
    <i class="nav-icon fas fa-list"></i>
    <p> Gói cước </p>
  </a>
</li>

<!-- Đăng ký Gói Cước -->
<li class="nav-item">
  <a href="{{ route('dang_ky_goi_cuoc.index') }}" class="nav-link">
    <i class="nav-icon fas fa-plus-circle"></i>
    <p> Đăng ký Gói Cước </p>
  </a>
</li>

 <!-- Tin Tức -->
<li class="nav-item">
<a href="{{ route('tintuc.index') }}"class="nav-link">

    <i class="nav-icon fas fa-newspaper"></i>
    <p> Tin Tức</p>
  </a>
</li>



        <!-- Giao dịch -->
        <li class="nav-item">
          <a href="transactions.html" class="nav-link">
            <i class="nav-icon fas fa-money-check-alt"></i>
            <p> Giao dịch </p>
          </a>
        </li>

        <!-- Nhật ký hoạt động -->
        <li class="nav-item">
          <a href="logs.html" class="nav-link">
            <i class="nav-icon fas fa-history"></i>
            <p> Nhật ký hoạt động </p>
          </a>
        </li>

        <!-- Quản lý người dùng -->
        <li class="nav-item">
          <a href="users.html" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p> Quản lý Người dùng </p>
          </a>
        </li>

        <!-- Hỗ trợ khách hàng -->
        <li class="nav-item">
          <a href="support.html" class="nav-link">
            <i class="nav-icon fas fa-headset"></i>
            <p> Hỗ trợ khách hàng </p>
          </a>
        </li>

        <!-- Báo cáo & Thống kê -->
        <li class="nav-item">
          <a href="reports.html" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p> Báo cáo & Thống kê </p>
          </a>
        </li>


       <!-- Đăng xuất -->
<li class="nav-item">
  <a href="#" class="nav-link"
     onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
    <i class="nav-icon fas fa-sign-out-alt"></i>
    <p> Đăng xuất </p>
  </a>
  <form id="sidebar-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
    @csrf
  </form>
</li>

      </ul>
    </nav>
  </div>
  <!-- /.sidebar -->
</aside>



<style>
  
</style>