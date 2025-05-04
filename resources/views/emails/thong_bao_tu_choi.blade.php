<!DOCTYPE html>
<html>
<head>
    <title>Thông báo từ chối đăng ký gói cước</title>
</head>
<body>
    <h1>Thông báo từ chối đăng ký gói cước</h1>
    <p>Kính gửi Quý khách,</p>
    <p>Yêu cầu đăng ký gói cước <strong>{{ $ten_goi }}</strong> cho số điện thoại <strong>{{ $so_dien_thoai }}</strong> vào ngày <strong>{{ $ngay_dang_ky }}</strong> đã bị từ chối.</p>
    <p><strong>Lý do</strong>: Vui lòng liên hệ Mobifone để biết thêm chi tiết.</p>
    <p>Cảm ơn Quý khách đã sử dụng dịch vụ của Mobifone!</p>
    <p>Trân trọng,<br>Mobifone</p>
    <p><a href="{{ url('/lich_su_dang_ky') }}" style="padding: 10px; background: #007bff; color: #fff; text-decoration: none;">Xem lịch sử đăng ký</a></p>
</body>
</html>