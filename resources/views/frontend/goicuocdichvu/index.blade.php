
@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <h1 class="text-center display-5 fw-bold text-primary mb-3">GÓI CƯỚC MOBIFONE ƯU ĐÃI</h1>
    <p class="text-center text-muted mb-5">Lựa chọn gói cước phù hợp – tiết kiệm tối đa</p>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if(!$soDienThoai)
        <div class="alert alert-warning text-center">Bạn cần đăng ký số điện thoại trước khi đăng ký gói cước.</div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($goiCuocs as $goi)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/' . $goi->hinh_anh) }}" alt="{{ $goi->ten_goi }}" class="img-fluid p-2">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-bold">{{ $goi->ten_goi }}</h5>
                        <p class="card-text text-muted small">{{ $goi->mo_ta }}</p>
                        <p class="card-text fw-semibold text-success">{{ number_format($goi->gia) }} VND</p>
                        @if(in_array($goi->id, $goiDaDangKy))
                            <button class="btn btn-outline-danger w-100 fw-semibold rounded-pill btn-huy-goi"
                                data-id="{{ $goi->id }}"
                                data-ten="{{ $goi->ten_goi }}">
                                <i class="bi bi-trash"></i> Hủy gói cước
                            </button>
                        @else
                            <button class="btn btn-outline-primary w-100 fw-semibold rounded-pill btn-dang-ky"
                                data-id="{{ $goi->id }}"
                                data-ten="{{ $goi->ten_goi }}"
                                data-cuphap="{{ $goi->cu_phap_dang_ky }}">
                                <i class="bi bi-send"></i> Đăng ký ngay
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal xác nhận đăng ký -->
@if($soDienThoai)
<div id="confirmModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="confirmForm" method="POST" action="{{ route('frontend.goicuocdichvu.dangky') }}">
                @csrf
                <input type="hidden" name="goi_cuoc_id" id="goi_cuoc_id">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận đăng ký gói cước</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn đang đăng ký gói cước <strong id="goi_ten"></strong> cho số điện thoại <strong>{{ $soDienThoai->so }}</strong>.</p>
                    <p>Vui lòng xác nhận bằng cách giải bài toán sau:</p>
                    <p id="math_question"></p>
                    <input type="number" id="math_answer" name="math_answer" class="form-control" required placeholder="Nhập kết quả">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal xác nhận hủy gói cước -->
<div id="cancelModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="cancelForm" method="POST" action="{{ route('frontend.goicuocdichvu.huy') }}">
                @csrf
                <input type="hidden" name="goi_cuoc_id" id="cancel_goi_cuoc_id">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận hủy gói cước</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn đang hủy gói cước <strong id="cancel_goi_ten"></strong> cho số điện thoại <strong>{{ $soDienThoai->so }}</strong>.</p>
                    <p>Vui lòng xác nhận bằng cách giải bài toán sau:</p>
                    <p id="cancel_math_question"></p>
                    <input type="number" id="cancel_math_answer" name="math_answer" class="form-control" required placeholder="Nhập kết quả">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Hàm tạo bài toán ngẫu nhiên
    function generateMathQuestion() {
        const ops = ['+', '-', '*'];
        const op = ops[Math.floor(Math.random() * ops.length)];
        const num1 = Math.floor(Math.random() * 10) + 1;
        const num2 = Math.floor(Math.random() * 10) + 1;
        let question = `${num1} ${op} ${num2}`;
        let answer = eval(question);
        return { question, answer };
    }

    // Xử lý đăng ký gói cước
    const dangKyButtons = document.querySelectorAll('.btn-dang-ky');
    const confirmModalElement = document.getElementById('confirmModal');
    if (confirmModalElement) {
        const confirmModal = new bootstrap.Modal(confirmModalElement);
        const confirmForm = document.getElementById('confirmForm');
        const goiCuocIdInput = document.getElementById('goi_cuoc_id');
        const goiTen = document.getElementById('goi_ten');
        const mathQuestion = document.getElementById('math_question');
        const mathAnswerInput = document.getElementById('math_answer');

        dangKyButtons.forEach(button => {
            button.addEventListener('click', () => {
                console.log('Nút đăng ký được nhấp:', button.getAttribute('data-id'));
                const { question, answer } = generateMathQuestion();
                goiCuocIdInput.value = button.getAttribute('data-id');
                goiTen.textContent = button.getAttribute('data-ten');
                mathQuestion.textContent = question;
                mathAnswerInput.value = '';
                mathAnswerInput.dataset.answer = answer;
                confirmModal.show();
            });
        });

        confirmForm.addEventListener('submit', function (e) {
            const userAnswer = parseInt(mathAnswerInput.value);
            const correctAnswer = parseInt(mathAnswerInput.dataset.answer);
            if (userAnswer !== correctAnswer) {
                e.preventDefault();
                mathAnswerInput.value = '';
                alert('Kết quả bài toán không đúng. Vui lòng thử lại!');
            }
        });
    }

    // Xử lý hủy gói cước
    const huyButtons = document.querySelectorAll('.btn-huy-goi');
    const cancelModalElement = document.getElementById('cancelModal');
    if (cancelModalElement) {
        const cancelModal = new bootstrap.Modal(cancelModalElement);
        const cancelForm = document.getElementById('cancelForm');
        const cancelGoiCuocIdInput = document.getElementById('cancel_goi_cuoc_id');
        const cancelGoiTen = document.getElementById('cancel_goi_ten');
        const cancelMathQuestion = document.getElementById('cancel_math_question');
        const cancelMathAnswerInput = document.getElementById('cancel_math_answer');

        huyButtons.forEach(button => {
            button.addEventListener('click', () => {
                console.log('Nút hủy được nhấp:', button.getAttribute('data-id'));
                const { question, answer } = generateMathQuestion();
                cancelGoiCuocIdInput.value = button.getAttribute('data-id');
                cancelGoiTen.textContent = button.getAttribute('data-ten');
                cancelMathQuestion.textContent = question;
                cancelMathAnswerInput.value = '';
                cancelMathAnswerInput.dataset.answer = answer;
                cancelModal.show();
            });
        });

        cancelForm.addEventListener('submit', function (e) {
            const userAnswer = parseInt(cancelMathAnswerInput.value);
            const correctAnswer = parseInt(cancelMathAnswerInput.dataset.answer);
            if (userAnswer !== correctAnswer) {
                e.preventDefault();
                cancelMathAnswerInput.value = '';
                alert('Kết quả bài toán không đúng. Vui lòng thử lại!');
            }
        });
    }
});
</script>
@endsection
```