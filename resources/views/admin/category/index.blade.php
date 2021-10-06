@extends('layouts.app-dashboard', [
'title' => 'Kategori'
])

@section('content')
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-uppercase"><i class="fas fa-folder mr-3"></i>kategori</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.category.index') }}" method="GET">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.category.create') }}"
                                            class="btn btn-primary btn-sm text-uppercase" style="padding-top: 10px;"><i
                                                class="fa fa-plus-circle mr-3"></i>tambah</a>
                                    </div>
                                    <input type="text" name="q" class=" form-control"
                                        placeholder="cari berdasarkan nama kategori">
                                    <div class=" input-group-append">
                                        <button type="submit" class=" btn btn-primary text-uppercase"><i
                                                class="fa fa-search mr-2"></i>cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class=" table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 6%">No.</th>
                                        <th style="width: 40%">Image</th>
                                        <th>Category Name</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $no => $category)
                                        <tr>
                                            <td>{{ ++$no + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                                            <td>
                                                <img src="{{ $category->image }}" style="width: 50px">
                                            </td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <a href="{{ route('admin.category.edit', $category->id) }}"
                                                    class=" btn btn-primary btn-sm"><i class="fa fa-pencil-alt "></i></a>
                                                <button onclick="Delete(this.id)" class="btn btn-sm btn-danger"
                                                    id="{{ $category->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            <p> Data Belum Tersedia !</p>
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="text-center">
                                {{ $categories->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //ajax delete
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
                        url: "{{ route('admin.category.index') }}/" + id,
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
@endsection
