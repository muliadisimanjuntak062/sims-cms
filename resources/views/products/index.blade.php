@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content_header')
<h1>Daftar Produk</h1>
@stop

@section('content')
<div class="container-fluid">
  <!-- Success Alert -->
  @if (session('success'))
    <script>
      alert("{{ session('success') }}")
    </script>
  @endif

  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex gap-2 justify-content-end">
            <div>
              <a href="{{ route('products.create') }}" class="btn btn-danger mb-2">Tambah Produk</a>
            </div>
            <div>
              <select name="categoryFilter" id="categoryFilter" class="form-control">
                <option value="">All Category</option>
                @foreach($productCategories as $productCategory)
                <option value="{{ $productCategory->id }}">{{ $productCategory->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="table-responsive">
            <table id="tbl_list" class="table" cellspacing="0" width="100%">

              <thead>
                <tr>
                  <th>No</th>
                  <th>Image</th>
                  <th>Nama Produk</th>
                  <th>Kategori Produk</th>
                  <th>Harga Beli (Rp)</th>
                  <th>Harga Jual (Rp)</th>
                  <th>Stok Produk</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody class="">

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
</script>
<script type="text/javascript">
  $(document).ready(function() {
    const table = $('#tbl_list').DataTable({
      processing: true,
      serverSide: true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        text: 'Export to Excel',
        title: 'Products Data',
        className: 'btn btn-success',
        exportOptions: {
          columns: ':not(:nth-child(2))' // Exclude the 2nd column (image column in this case)
        }
      }],
      ajax: {
        url: '{{ url()->current() }}',
        data: function(d) {
          d.product_category_id = $('#categoryFilter').val();
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'image',
          name: 'image',
          render: function(data) {
            return `<img src="${data}" alt="Image" style="width:50px; height:auto;">`;
          }
        },
        {
          data: 'name',
          name: 'name',
          orderable: true
        },
        {
          data: 'product_category_name',
          name: 'product_category_name',
        },
        {
          data: 'purchase_price',
          name: 'purchase_price'
        },
        {
          data: 'sell_price',
          name: 'sell_price'
        },
        {
          data: 'stock',
          name: 'stock'
        },
        {
          data: 'id',
          name: 'actions',
          render: function(data) {
            return `
            <div class="d-flex gap-2">
              <div>
                <a class="edit" data-id="${data}" href="/admin/products/${data}/edit"><i class="text-primary fas fa-pencil-alt"></i></a>
              </div>
              <div>
                <a class="delete" href="#" onclick="event.preventDefault(); if (confirm('Apakah kamu yakin?')) { document.getElementById('delete-form-${data}').submit(); }">
                    <i class="text-danger fas fa-trash"></i>
                </a>

                <form id="delete-form-${data}" action="/admin/products/${data}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
              </div>
            </div>
            `;
          },
          orderable: false,
          searchable: false
        }
      ]
    });

    $('#categoryFilter').change(function() {
      table.ajax.reload();
    });
  });
</script>
@stop