<!DOCTYPE html>
<html>
<head>
    <title>Thông báo từ chối gói cước</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc3545; color: #fff; padding: 10px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .footer { text-align: center; padding: 10px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Thông báo từ chối gói cước</h2>
        </div>
        <div class="content">
            <p>Kính gửi Quý khách,</p>
            <p>Yêu cầu đăng ký gói cước <strong>{{ $ten_goi }}</strong> cho số điện thoại <strong>{{ $so_dien_thoai }}</strong> đã bị từ chối.</p>
            <p>Thông tin chi tiết:</p>
            <ul>
                <li><strong>Gói cước:</strong> {{ $ten_goi }}</li>
                <li><strong>Số điện thoại:</strong> {{ $so_dien_thoai }}</li>
                <li><strong>Ngày đăng ký:</strong> {{ $ngay_dang_ky }}</li>
            </ul>
            <p>Vui lòng liên hệ với chúng tôi để biết thêm chi tiết.</p>
        </div>
        <div class="footer">
            <p>Trân trọng,<br>Mobifone</p>
        </div>
    </div>
</body>
</html>