@extends('layouts.frontend')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Danh sách SIM</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Số SIM</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ssims as $sim)
                <tr>
                    <td>{{ $sim->sodt }}</td>
                    <td>{{ $sim->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-4 mb-3">Danh sách số điện thoại</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Số điện thoại</th>
                <th>Loại thuê bao</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($soDienThoais as $so)
                <tr>
                    <td>{{ $so->so }}</td>
                    <td>{{ $so->loai_thue_bao }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-4 mb-3">Danh sách gói cước</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Tên gói</th>
                <th>Giá</th>
                <th>Mô tả</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($goiCuocs as $goi)
                <tr>
                    <td>{{ $goi->ten_goi }}</td>
                    <td>{{ number_format($goi->gia, 0, ',', '.') }} VND</td>
                    <td>{{ $goi->mo_ta }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
