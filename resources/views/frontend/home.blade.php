@extends('layouts.frontend')

@section('content')  {{-- Đặt tên section là content --}}
    @include('frontend.banner')
    @include('frontend.feature')
    @include('frontend.about')  {{-- Đưa nội dung vào section --}}
    @include('frontend.feature_section')
@endsection
