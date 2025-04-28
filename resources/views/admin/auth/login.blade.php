@extends('layouts.admin')

@section('title', 'Đăng nhập Admin')

@section('content')
<div class="container h-100 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-sm" style="width: 400px;">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Admin Login</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        required
                    >
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <p class="mb-0">
                    Chưa có tài khoản? <a href="{{ route('admin.register') }}">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
