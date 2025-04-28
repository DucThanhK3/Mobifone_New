<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
    <a href="{{ route('frontend.home') }}" class="logo d-flex align-items-center">
      <h1 class="sitename">Mobifone</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('frontend.home') }}" class="active">Trang chủ</a></li>
        <li><a href="{{ url('about') }}">Giới thiệu</a></li>

        <li class="dropdown">
          <a href="#"><span>Dịch vụ</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="{{ route('frontend.goicuocloai.index') }}">Loại thuê bao</a></li>
            <li><a href="{{ route('frontend.goicuocdichvu.index') }}">Đăng ký gói cước</a></li>
            <li><a href="#">Gói data</a></li>
            <li><a href="#">Dịch vụ</a></li>
            <li><a href="#">Đăng ký hòa mạng</a></li>
            <li><a href="#">Dịch vụ quốc tế</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#"><span>Gói cước</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="{{ route('frontend.goicuoc') }}">Danh sách gói cước</a></li>
          </ul>
        </li>

        <li><a href="{{ url('team') }}">Đội ngũ</a></li>

        <li><a href="{{ route('frontend.tin_tuc.index') }}">Tin tức</a></li>

        <li class="dropdown">
          <a href="#"><span>Khác</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="#">Ưu đãi đặc biệt</a></li>
            <li class="dropdown">
              <a href="#"><span>Hỗ trợ khách hàng</span> <i class="bi bi-chevron-right toggle-dropdown"></i></a>
              <ul>
                <li><a href="#">Tra cứu cước</a></li>
                <li><a href="#">Hướng dẫn sử dụng</a></li>
                <li><a href="#">Câu hỏi thường gặp</a></li>
                <li><a href="#">Chính sách bảo mật</a></li>
                <li><a href="#">Điều khoản sử dụng</a></li>
              </ul>
            </li>
            <li><a href="#">Chương trình khuyến mãi</a></li>
            <li><a href="#">Mạng 5G</a></li>
            <li><a href="#">Ứng dụng di động</a></li>
          </ul>
        </li>

        <li><a href="{{ url('contact') }}">Liên hệ</a></li>

        {{-- Auth Links --}}
@guest
  <li class="nav-item">
    <a href="{{ route('frontend.login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-2">Đăng nhập</a>
  </li>
  <li class="nav-item">
    <a href="{{ route('frontend.register') }}" class="btn btn-primary btn-sm rounded-pill px-3">Đăng ký</a>
  </li>
@else
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      Xin chào, {{ Auth::user()->name }}
    </a>
    <ul class="dropdown-menu" aria-labelledby="userDropdown">
      <li>
        <form action="{{ route('frontend.logout') }}" method="POST">
          @csrf
          <button type="submit" class="dropdown-item">Đăng xuất</button>
        </form>
      </li>
    </ul>
  </li>
@endguest

      </ul>

      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

  </div>
</header>
