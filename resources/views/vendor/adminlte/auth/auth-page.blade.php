@extends('adminlte::master')

@php
$dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

if (config('adminlte.use_route_url', false)) {
$dashboard_url = $dashboard_url ? route($dashboard_url) : '';
} else {
$dashboard_url = $dashboard_url ? url($dashboard_url) : '';
}

$bodyClasses = ($auth_type ?? 'login') . '-page';

if (! empty(config('adminlte.layout_dark_mode', null))) {
$bodyClasses .= ' dark-mode';
}
@endphp

@section('adminlte_css')
@stack('css')
@yield('css')
@stop

@section('classes_body'){{ $bodyClasses }}@stop

@section('body')
<div class="d-flex justify-content-between align-items-center vw-100">
    <!-- Left side (Login Form) -->
    <div class="col-md-6  d-flex justify-content-center">
        <div class="{{ $auth_type ?? 'login' }}-box">
            <!-- Logo Section -->
            <div class="{{ $auth_type ?? 'login' }}-logo">
                <a href="{{ $dashboard_url }}">
                    @if (config('adminlte.auth_logo.enabled', false))
                    <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                        alt="{{ config('adminlte.auth_logo.img.alt') }}"
                        @if (config('adminlte.auth_logo.img.class', null)) class="{{ config('adminlte.auth_logo.img.class') }}" @endif
                        @if (config('adminlte.auth_logo.img.width', null)) width="{{ config('adminlte.auth_logo.img.width') }}" @endif
                        @if (config('adminlte.auth_logo.img.height', null)) height="{{ config('adminlte.auth_logo.img.height') }}" @endif>
                    @else
                    <img src="{{ asset(config('adminlte.logo_img')) }}" alt="{{ config('adminlte.logo_img_alt') }}" height="50" class="custom-logo">
                    @endif
                    {!! config('adminlte.logo') !!}
                </a>
            </div>

            <!-- Card Section -->
            <!-- <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}"> -->
            <div class="">

                @hasSection('auth_header')
                <!-- <div class="card-header {{ config('adminlte.classes_auth_header', '') }}"> -->
                <h3 class="text-center my-5">
                    @yield('auth_header')
                </h3>
                <!-- </div> -->
                @endif

                <!-- Card Body -->
                <!-- <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}"> -->
                @yield('auth_body')
                <!-- </div> -->

                @hasSection('auth_footer')
                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                    @yield('auth_footer')
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right side (Illustration) -->
    <div class="col-md-6 p-0 bg-danger">
        <img src="{{ asset('storage/assets/login-illustration.png') }}" alt="Login Illustration" class="img-fluid w-100" style="object-fit: cover; height: 100vh;">
    </div>
</div>

@stop

@section('adminlte_js')
@stack('js')
@yield('js')
@stop