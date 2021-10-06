@extends('layouts.app-dashboard',[
    'title' => 'Slider'
])

@section('content')
    <div class="container-fluid  mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-uppercase"><i class="fa fa-image mr-3"></i>data slider</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.slider.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <input type="file" name="image" class=" form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">
                                        <p>{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                             <div class="form-group">
                                <label for="link">Link</label>
                                <input type="text" name="link" value="{{ old('link') }}" placeholder="masukan link" class=" form-control  @error('image') is-invalid @enderror">
                                @error('link')
                                    <div class="invalid-feedback">
                                        <p>{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class=" btn btn-primary mr-2"><i class="fa fa-paper-plane mr-2"></i>Simpan</button>
                            <button type="reset" class=" btn btn-warning btn-reset"><i class="fa fa-redo mr-2"></i>Reset</button>
                        </form>
                    </div>
                </div>
                <div class="card border-0 shadow mt-4 mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-laptop"></i> SLIDERS</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-hover table-condensed">
                                <thead>
                                    <tr class=" text-center">
                                        <th width="6%">No.</th>
                                        <th>Gambar</th>
                                        <th>Link</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sliders as $no => $slider)
                                        <tr>
                                            <td>{{ ++$no + ($sliders->currentPage()-1) * $sliders->perPage() }}</td>
                                            <td>
                                                <img src="{{ $slider->image }}" class=" rounded" width="200px">
                                            </td>
                                            <td>{{ $slider->link }}</td>
                                            <td>
                                                <button onclick="Delete(this.id)" class=" btn btn-danger " id="{{ $slider->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            <p>Data Belum Tersedia !</p>
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="text-center">
                                {{ $sliders->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
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
        }).then(function (isConfirm) {
            if (isConfirm) {

                //ajax delete
                jQuery.ajax({
                    url: "{{ route("admin.slider.index") }}/" + id,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function (response) {
                        if (response.status == "success") {
                            swal({
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DIHAPUS!',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function () {
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
                            }).then(function () {
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