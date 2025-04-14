<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Mobifone | Giải pháp viễn thông tối ưu')</title>

  <!-- Meta -->
  <meta name="description" content="Mobifone cung cấp các giải pháp viễn thông hiệu quả, kết nối mọi nơi, mọi lúc.">
  <meta name="keywords" content="Mobifone, viễn thông, giải pháp, kết nối">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  <!-- Cho phép view con đẩy thêm CSS -->
  @stack('styles')

  <!-- Open Graph -->
  <meta property="og:title" content="Mobifone | Giải pháp viễn thông tối ưu">
  <meta property="og:description" content="Mobifone cung cấp các giải pháp viễn thông hiệu quả, kết nối mọi nơi, mọi lúc.">
  <meta property="og:image" content="{{ asset('assets/img/favicon.png') }}">
  <meta property="og:url" content="http://www.mobifone.vn">
  <meta property="og:type" content="website">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Mobifone | Giải pháp viễn thông tối ưu">
  <meta name="twitter:description" content="Mobifone cung cấp các giải pháp viễn thông hiệu quả, kết nối mọi nơi, mọi lúc.">
  <meta name="twitter:image" content="{{ asset('assets/img/favicon.png') }}">
  <meta name="twitter:site" content="@mobifone">
</head>

<body class="index-page">

  {{-- Header --}}
  @include('partials.frontend.header')

  {{-- Nội dung chính --}}
  <main class="main">
    @yield('content')
  </main>

  {{-- Footer --}}
  @include('partials.frontend.footer')

  <!-- Nút cuộn lên đầu trang -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" aria-label="Quay lại đầu trang">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  {{-- Cho phép view con đẩy thêm JS --}}
  @stack('scripts')

</body>

</html>
