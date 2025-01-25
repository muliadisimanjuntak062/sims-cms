@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content_header')
<h1>Edit Produk</h1>
@stop

@section('content')
<div class="container-fluid">
  <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    @method('PUT')
    <!-- Product Category -->
    <div class="mb-3 col-12 col-md-2">
      <label for="productCategory" class="form-label">Kategori</label>
      <select name="product_category_id" id="productCategory" class="form-control">
        <option value="">Pilih Kategori</option>
        @foreach($productCategories as $productCategory)
        @if($product->product_category_id == $productCategory->id)
        <option value="{{ $productCategory->id }}" {{ old('product_category_id') == $productCategory->id ? 'selected' : '' }} selected>
          {{ $productCategory->name }}
        </option>
        @else
        <option value="{{ $productCategory->id }}" {{ old('product_category_id') == $productCategory->id ? 'selected' : '' }}>
          {{ $productCategory->name }}
        </option>
        @endif
        @endforeach
      </select>
      @if($errors->has('product_category_id'))
      <small class="text-danger">{{ $errors->first('product_category_id') }}</small>
      @endif
    </div>

    <!-- Product Name -->
    <div class="mb-3 col-12 col-md-10">
      <label for="productName" class="form-label">Nama Barang</label>
      <input type="text" class="form-control" id="productName" placeholder="Masukkan nama barang" name="name" value="{{ old('name', $product->name ?? '') }}">
      @if($errors->has('name'))
      <small class="text-danger">{{ $errors->first('name') }}</small>
      @endif
    </div>

    <!-- Purchase Price -->
    <div class="mb-3 col-12 col-md-4">
      <label for="purchasePrice" class="form-label">Harga Beli</label>
      <input type="number" class="form-control" id="purchasePrice" placeholder="Masukkan harga beli" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price ?? '') }}">
      @if($errors->has('purchase_price'))
      <small class="text-danger">{{ $errors->first('purchase_price') }}</small>
      @endif
    </div>

    <!-- Sell Price -->
    <div class="mb-3 col-12 col-md-4">
      <label for="sellPrice" class="form-label">Harga Jual</label>
      <input type="number" class="form-control" id="sellPrice" placeholder="Masukkan harga jual" name="sell_price" value="{{ old('sell_price', $product->sell_price ?? '') }}">
      @if($errors->has('sell_price'))
      <small class="text-danger">{{ $errors->first('sell_price') }}</small>
      @endif
    </div>

    <!-- Stock -->
    <div class="mb-3 col-12 col-md-4">
      <label for="productStock" class="form-label">Stok Barang</label>
      <input type="number" class="form-control" id="productStock" placeholder="Masukkan stok barang" name="stock" value="{{ old('stock', $product->stock ?? '') }}">
      @if($errors->has('stock'))
      <small class="text-danger">{{ $errors->first('stock') }}</small>
      @endif
    </div>

    <!-- Image Upload -->
    <div class="col-12 col-md-12">
      <div class="mb-2 position-relative">
        <label for="Image" class="form-label">Upload Image</label>
        <div class="img-input-wrapper">
          <input
            class="img-input form-control"
            type="file"
            id="formFile"
            onchange="preview()"
            name="image"
            value="{{ old('image')}}"
            accept="image/*">
          <div class="dflex flex-col">
            <img id="frame" src="{{ old('image') ? asset('storage/products/' . old('image')) : ($product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/250x250') }}"  class="img-placeholder" alt="Image Preview" />
            <p id="img-text-placeholder" class="img-text-placeholder text-center mt-2 {{ old('image') ? asset('storage/products/' . old('image')) : 'd-none' }}">Input image</p>
          </div>
        </div>
        @if($errors->has('image'))
        <small class="text-danger">{{ $errors->first('image') }}</small>
        @endif
      </div>
    </div>

    <!-- Buttons -->
    <div class="d-flex gap-1 justify-content-end">
      <button class="btn btn-secondary" type="reset">Batalkan</button>
      <button class="btn btn-primary" type="submit" onclick="return confirm('Apakah kamu yakin?')">Simpan</button>
    </div>
  </form>
</div>

@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
<style>
  .img-input-wrapper {
    position: relative;
    height: 300px;
    border: dashed #ced4da 1px;
    border-radius: 5px;
    overflow: hidden;
    display: flex;
    /* Flexbox for centering */
    justify-content: center;
    /* Horizontally center */
    align-items: center;
    /* Vertically center */
  }

  .img-input {
    opacity: 0;
    position: absolute;
    width: 250px;
    height: 250px;
    cursor: pointer;
    z-index: 2;
  }

  .img-placeholder {
    width: 100px;
    /* Adjust placeholder size */
    height: 100px;
    /* Adjust placeholder size */
    object-fit: cover;
    /* Ensures image fits without distortion */
    z-index: 1;
    /* Optional: add transparency for a placeholder look */
  }
</style>
@stop

@section('js')
<script>
  console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
<script>
  function preview() {
    const fileInput = document.getElementById('formFile');
    const textPlaceholder = document.getElementById('img-text-placeholder');
    const frame = document.getElementById('frame');

    if (fileInput.files && fileInput.files[0]) {
      frame.src = URL.createObjectURL(fileInput.files[0]);
      textPlaceholder.classList.add('d-none');
    }
  }

  function clearImage() {
    const fileInput = document.getElementById('formFile');
    const frame = document.getElementById('frame');
    const textPlaceholder = document.getElementById('img-text-placeholder');

    fileInput.value = null;
    frame.src = '';
    textPlaceholder.classList.remove('d-none');

  }
</script>

<script type="text/javascript"></script>
@stop