@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content_header')
<h1>Tambah Produk</h1>
@stop

@section('content')
<div class="container-fluid">
  <form action="#" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    <!-- Product Category -->
    <!-- Product Name -->

    <div class="mb-3 col-12 md:col-12">
      <div>
        <img src="{{ asset('storage/assets/user-default-photo.png') }}" alt="" class="rounded-circle mb-3">
        <h2 class="text-capitalize">{{ $user->name }}</h2>
      </div>
      @if($errors->has('name'))
      <small class="text-danger">{{ $errors->first('name') }}</small>
      @endif
    </div>

    <div class="mb-3 col-12 col-md-8">
      <label for="productName" class="form-label">Nama Kandidat</label>
      <input type="text" class="form-control" value="@ {{ $user->name }}" disabled>
      @if($errors->has('name'))
      <small class="text-danger">{{ $errors->first('name') }}</small>
      @endif
    </div>

    <!-- Purchase Price -->
    <div class="mb-3 col-12 col-md-4">
      <label for="purchasePrice" class="form-label">Posisi Kandidat</label>
      <input type="text" class="form-control" value="</> {{ $user->role }}" disabled>
      @if($errors->has('purchase_price'))
      <small class="text-danger">{{ $errors->first('purchase_price') }}</small>
      @endif
    </div>
  </form>
</div>

@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
  console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@stop