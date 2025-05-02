<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
    <a href="{{ route('frontend.home') }}" class="logo d-flex align-items-center" title="Trang chủ Mobifone">
      <h1 class="sitename">Mobifone</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('frontend.home') }}" class="active" title="Trang chủ">Trang chủ</a></li>
        <li><a href="{{ url('about') }}" title="Giới thiệu về Mobifone">Giới thiệu</a></li>

        <li class="dropdown">
          <a href="#" aria-expanded="false" title="Dịch vụ Mobifone">
            <span>Dịch vụ</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
          </a>
          <ul>
            <li><a href="{{ route('frontend.goicuocloai.index') }}" title="Loại thuê bao">Loại thuê bao</a></li>
            <li><a href="{{ route('frontend.goicuocdichvu.index') }}" title="Đăng ký gói cước">Đăng ký gói cước</a></li>
            <li><a href="{{ route('frontend.lichsu') }}" title="Lịch sử đăng ký gói cước">Lịch sử đăng ký</a></li>
            <li><a href="#" title="Gói data (Chưa khả dụng)">Gói data</a></li>
            <li><a href="#" title="Dịch vụ khác (Chưa khả dụng)">Dịch vụ</a></li>
            <li><a href="#" title="Đăng ký hòa mạng (Chưa khả dụng)">Đăng ký hòa mạng</a></li>
            <li><a href="#" title="Dịch vụ quốc tế (Chưa khả dụng)">Dịch vụ quốc tế</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" aria-expanded="false" title="Gói cước Mobifone">
            <span>Gói cước</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
          </a>
          <ul>
            <li><a href="{{ route('frontend.goicuoc') }}" title="Danh sách gói cước">Danh sách gói cước</a></li>
          </ul>
        </li>

        <li><a href="{{ url('team') }}" title="Đội ngũ Mobifone">Đội ngũ</a></li>

        <li><a href="{{ route('frontend.tin_tuc.index') }}" title="Tin tức Mobifone">Tin tức</a></li>

        <li class="dropdown">
          <a href="#" aria-expanded="false" title="Các tính năng khác">
            <span>Khác</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
          </a>
          <ul>
            <li><a href="#" title="Ưu đãi đặc biệt (Chưa khả dụng)">Ưu đãi đặc biệt</a></li>
            <li class="dropdown">
              <a href="#" title="Hỗ trợ khách hàng">
                <span>Hỗ trợ khách hàng</span> <i class="bi bi-chevron-right toggle-dropdown"></i>
              </a>
              <ul>
                <li><a href="#" title="Tra cứu cước (Chưa khả dụng)">Tra cứu cước</a></li>
                <li><a href="#" title="Hướng dẫn sử dụng (Chưa khả dụng)">Hướng dẫn sử dụng</a></li>
                <li><a href="#" title="Câu hỏi thường gặp (Chưa khả dụng)">Câu hỏi thường gặp</a></li>
                <li><a href="#" title="Chính sách bảo mật (Chưa khả dụng)">Chính sách bảo mật</a></li>
                <li><a href="#" title="Điều khoản sử dụng (Chưa khả dụng)">Điều khoản sử dụng</a></li>
              </ul>
            </li>
            <li><a href="#" title="Chương trình khuyến mãi (Chưa khả dụng)">Chương trình khuyến mãi</a></li>
            <li><a href="#" title="Mạng 5G (Chưa khả dụng)">Mạng 5G</a></li>
            <li><a href="#" title="Ứng dụng di động (Chưa khả dụng)">Ứng dụng di động</a></li>
          </ul>
        </li>

        <li><a href="{{ url('contact') }}" title="Liên hệ với Mobifone">Liên hệ</a></li>

        {{-- Auth Links --}}
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Tài khoản người dùng">
              Xin chào, {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
              <li>
                <form action="{{ route('frontend.logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item" title="Đăng xuất khỏi tài khoản">Đăng xuất</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item">
            <a href="{{ route('frontend.login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-2" title="Đăng nhập tài khoản">Đăng nhập</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('frontend.register') }}" class="btn btn-primary btn-sm rounded-pill px-3" title="Đăng ký tài khoản mới">Đăng ký</a>
          </li>
        @endauth
      </ul>

      <i class="mobile-nav-toggle d-xl-none bi bi-list" title="Menu di động"></i>
    </nav>
  </div>
</header>