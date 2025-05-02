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
                            <button class="btn btn-outline-secondary w-100 fw-semibold rounded-pill" disabled>Đã đăng ký</button>
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

<!-- Modal xác nhận -->
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
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.btn-dang-ky');
    const modalElement = document.getElementById('confirmModal');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        const confirmForm = document.getElementById('confirmForm');
        const goiCuocIdInput = document.getElementById('goi_cuoc_id');
        const goiTen = document.getElementById('goi_ten');
        const mathQuestion = document.getElementById('math_question');
        const mathAnswerInput = document.getElementById('math_answer');

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
                console.log('Nút đăng ký được nhấp:', button.getAttribute('data-id')); // Debug
                const { question, answer } = generateMathQuestion();
                goiCuocIdInput.value = button.getAttribute('data-id');
                goiTen.textContent = button.getAttribute('data-ten');
                mathQuestion.textContent = question;
                mathAnswerInput.value = '';
                mathAnswerInput.dataset.answer = answer;
                modal.show();
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
});
</script>
@endsection