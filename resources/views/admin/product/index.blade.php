@extends('layouts.app-dashboard', [
'title' => 'Product'
])

@section('content')
    <div class="container-fluid  mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-uppercase"><i class="fa fa-shopping-bag mr-3"></i>product</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.cetak.product') }}" class=" btn btn-primary mb-4"><i
                                class="fas fa-file-pdf mr-2"></i>Cetak pdf</a>
                        <a href="{{ route('admin.product.create') }}" class="btn btn-primary mb-4 ml-2 "><i
                                class="fa fa-plus-circle  mr-3"></i>Tambah Data</a>

                        {{-- <form action="{{ route('admin.product.index') }}" method="get">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm text-uppercase"
                                        style="padding-top: 10px;"><i class="fa fa-plus-circle mr-3"></i>tambah</a>
                                    </div>
                                    <input type="text" name="q" class=" form-control" placeholder="cari berdasarkan nama product">
                                    <div class=" input-group-append">
                                        <button type="submit" class=" btn btn-primary text-uppercase"><i class="fa fa-search mr-2"></i>cari</button>
                                    </div>
                                </div>
                            </div>
                        </form> --}}
                        <div class="table-responsive">
                            <table class=" table table-bordered text-center" id="crudTable">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Image</th>
                                        <th>Nama Product</th>
                                        <th>Kategori</th>
                                        <th>Unit</th>
                                        <th>Harga</th>
                                        <th>Stock</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @forelse ($products as $no => $product)
                                        <tr>
                                            <td>{{ ++$no + ($products->currentPage()-1) * $products->perPage() }}</td>
                                            <td>
                                                <img src="{{ $product->image }}" width="80px">
                                            </td>
                                            <td>{{ $product->title }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <th> {{ moneyFormat($product->price) }} </th>
                                            <th> {{ $product->stock }} </th>
                                            <td>
                                                <a href="{{ route('admin.product.edit', $product->id) }}" class=" btn btn-primary ">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button onclick="Delete(this.id)" class=" btn btn-danger " id="{{ $product->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            <p>Data Belum Tersedia !</p>
                                        </div>
                                    @endforelse --}}
                                </tbody>
                            </table>
                            {{-- <div class="text-center">
                                {{ $products->links('vendor.pagination.bootstrap-4') }}
                                                </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        //  DataTables
        $(document).ready(function() {
            $('#crudTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                },
                columns: [{
                        data: 'image',
                        name: 'image',
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'category.name',
                        name: 'category.name'
                    },
                    {
                        data: 'unit',
                        name: 'unit'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searcable: false,
                    },
                ],
                // dom: 'lBfrtip',
                // buttons: [
                //     'excel', 'pdf', 'copy', 'print'
                // ],
                // "lengthMenu": [
                //     [10, 25, 50, -1],
                //     [10, 25, 50, "All"]
                // ]

            });
        });

        //ajax delete switalert
        function Delete(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    //ajax delete
                    jQuery.ajax({
                        url: "{{ route('admin.product.index') }}/" + id,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    return true;
                }
            })
        }
    </script>
@endpush
