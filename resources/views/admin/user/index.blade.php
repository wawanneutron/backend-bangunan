@extends('layouts.app-dashboard', [
'title' => 'Data User'
])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header ">
                        <h6 class="m-0 font-weight-bold text-uppercase"><i class="fas fa-users mr-3"></i>Data Users (Admin)
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.user.index') }}" method="get">
                            <div class="form-group mb-4">
                                <div class=" input-group">
                                    <div class=" input-group-prepend">
                                        <a href="{{ route('admin.user.create') }}" class=" btn  btn-primary"><i
                                                class="fa fa-plus-circle mr-2"></i>Tambah</a>
                                    </div>
                                    <input type="text" name="q" class=" form-control"
                                        placeholder="Cari berdasarkan nama pengguna">
                                    <div class=" input-group-append">
                                        <button type="submit " class=" btn btn-primary"><i
                                                class="fas fa-search mr-2"></i>Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class=" table table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Email User</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $no => $user)
                                        <tr>
                                            <td>{{ ++$no + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                                    class=" btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                <button onclick="Delete(this.id)" id="{{ $user->id }}"
                                                    class=" btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            <p>Data Tidak Ada !</p>
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    // ajak delete
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

                // ajak delete
                jQuery.ajax({
                    url: "{{ route('admin.user.index') }}/" + id,
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
