@extends('layouts.app-dashboard', [
'title' => 'Gallery Product'
])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">Gallery</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-uppercase"><i class="fas fa-folder mr-3"></i>tambah gallery
                            product</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.gallery.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <input type="file" name="image" id="image"
                                    class=" form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">
                                        <div class="h6 alert alert-danger">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name" name="gambar">Nama Product</label>
                                <select name="product_id" class=" custom-select">
                                    @foreach ($products as $name)
                                        <option value="{{ $name->id }}">{{ $name->title }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">
                                        <div class="h6 alert alert-danger">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class=" btn btn-primary mr-2 mb-2 btn-submit"><i
                                    class="fa fa-paper-plane mr-2"></i>Simpan</button>
                            <button type="reset" class=" btn btn-warning  btn-reset"><i
                                    class="fa fa-redo mr-2"></i>Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
