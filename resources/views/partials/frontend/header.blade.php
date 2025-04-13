<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="{{ url('/') }}" class="logo d-flex align-items-center">
      <!-- Bỏ dấu chú thích dòng dưới nếu bạn muốn sử dụng logo hình ảnh -->
      <!-- <img src="assets/img/logo.png" alt=""> -->
      <h1 class="sitename">Mobifone</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ url('/') }}" class="active">Trang chủ</a></li>
        <li><a href="about.html">Giới thiệu</a></li>
        <li><a href="{{ url('/customer/dichvu') }}">Dịch vụ</a></li>
        <li class="dropdown">
          <a href="#"><span>Gói cước</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="{{ url('/goi_cuoc') }}">Danh sách gói cước</a></li>
            
          </ul>
        </li>
        <li><a href="team.html">Đội ngũ</a></li>
        <li><a href="{{ route('frontend.tin_tuc.index') }}">Tin tức</a></li>


        <li class="dropdown">
          <a href="#"><span>Khác</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="#">Ưu đãi đặc biệt</a></li>
            <li class="dropdown">
              <a href="#"><span>Hỗ trợ khách hàng</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
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
        <li><a href="contact.html">Liên hệ</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

  </div>
</header>
