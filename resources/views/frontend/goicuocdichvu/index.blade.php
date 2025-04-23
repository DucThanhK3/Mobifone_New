@extends('layouts.frontend')

@section('content')
<!-- ... CSS và Carousel giữ nguyên ... -->

<div class="container py-5">
    <h1 class="text-center display-5 fw-bold text-primary mb-3">GÓI CƯỚC MOBIFONE ƯU ĐÃI</h1>
    <p class="text-center text-muted mb-5">Lựa chọn gói cước phù hợp – tiết kiệm tối đa</p>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($goiCuocs as $goi)
        <div class="col">
            <div class="card h-100">
                <img src="{{ asset('assets/images/' . $goi->hinh_anh) }}" alt="{{ $goi->ten_goi }}" class="img-fluid p-2">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold">{{ $goi->ten_goi }}</h5>
                    <p class="card-text text-muted small">{{ $goi->mo_ta }}</p>
                    <p class="card-text fw-semibold text-success">{{ number_format($goi->gia) }} VND</p>
                    <button class="btn btn-outline-primary w-100 fw-semibold rounded-pill btn-dang-ky"
                        data-id="{{ $goi->id }}"
                        data-ten="{{ $goi->ten_goi }}"
                        data-cuphap="{{ $goi->cu_phap_dang_ky }}">
                        <i class="bi bi-send"></i> Đăng ký ngay
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- ✅ Modal xác nhận -->
<div id="confirmModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="confirmForm" method="POST" action="{{ route('frontend.dangky') }}">
                @csrf
                <input type="hidden" name="goi_cuoc_id" id="goi_cuoc_id">
                <input type="hidden" name="so_dien_thoai" id="so_dien_thoai_hidden">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận số điện thoại</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p>Vui lòng nhập lại số điện thoại để xác nhận:</p>
                    <input type="text" id="confirmPhone" name="confirmPhone" class="form-control" required placeholder="Xác nhận số điện thoại">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.btn-dang-ky');
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        const confirmPhoneInput = document.getElementById('confirmPhone');
        const confirmForm = document.getElementById('confirmForm');
        const goiCuocIdInput = document.getElementById('goi_cuoc_id');
        const phoneHiddenInput = document.getElementById('so_dien_thoai_hidden');

        function generateMathQuestion() {
            const ops = ['+', '-', '*'];
            const op = ops[Math.floor(Math.random() * ops.length)];
            const num1 = Math.floor(Math.random() * 10) + 1;
            const num2 = Math.floor(Math.random() * 10) + 1;
            let question = `${num1} ${op} ${num2}`;
            let answer = eval(question);
            return { question, answer };
        }

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const phone = prompt("Nhập số điện thoại để đăng ký:");
                const validPhone = /^(090|093|089|070|079|077|076|078)\d{7}$/.test(phone);

                if (!validPhone) {
                    alert("Số điện thoại không hợp lệ!");
                    return;
                }

                const { question, answer } = generateMathQuestion();
                const userAnswer = prompt(`Giải bài toán: ${question}`);

                if (parseFloat(userAnswer) === answer) {
                    // Hiện form xác nhận nếu đúng
                    confirmPhoneInput.value = "";
                    phoneHiddenInput.value = phone;
                    goiCuocIdInput.value = button.getAttribute('data-id');
                    modal.show();
                } else {
                    alert("Bài toán không đúng, vui lòng thử lại!");
                }
            });
        });

        confirmForm.addEventListener('submit', function (e) {
            const confirmPhone = confirmPhoneInput.value.trim();
            const originalPhone = phoneHiddenInput.value.trim();
            if (confirmPhone !== originalPhone) {
                e.preventDefault();
                confirmPhoneInput.value = "";
                alert("Xác nhận không đúng. Vui lòng nhập lại!");
            }
        });
    });
</script>

@endsection
