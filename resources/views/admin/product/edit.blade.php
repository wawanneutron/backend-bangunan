@extends('layouts.app-dashboard',[
'title' => 'Edit Product'
])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Product</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit data</li>
                    </ol>
                </nav>
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-uppercase"><i class="fa fa-shopping-bag mr-3"></i>Edit Product
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product.update', $product->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <input type="file" name="image" id="image"
                                    class=" form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">
                                        <p>{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="title">Nama Product</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}"
                                    class=" form-control @error('title') is-invalid @enderror">
                                @error('title')
                                    <div class="invalid-feedback">
                                        <p>{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select name="category_id" class=" form-control">
                                            <option value="{{ $product->category_id }}" selected>
                                                {{ $product->category->name }}
                                            </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unit">Satuan / Unit</label>
                                        <select name="unit" class=" form-control  @error('unit') is-invalid @enderror"">
                                            <option disabled selected>-- PILIH UNIT / SATUAN --</option>
                                            <option value=" Pack">Pack</option>
                                            <option value="Dus">Dus</option>
                                            <option value="Box">Box</option>
                                            <option value="Lembar">Lembar</option>
                                            <option value="Pcs">Pc / Pcs</option>
                                            <option value="Batang">Batang</option>
                                            <option value="Roll">Roll</option>
                                        </select>
                                        @error('unit')
                                            <div class="invalid-feedback">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="stock">Stock Barang (pcs)</label>
                                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                            class=" form-control @error('stock') is-invalid @enderror"
                                            placeholder="Stock Barang (per pcs)">
                                        @error('stock')
                                            <div class="invalid-feedback">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content">Deskripsi</label>
                                <textarea name="content" id="content" rows="15"
                                    class=" form-control content @error('content') is-invalid @enderror">{{ old('content', $product->content) }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>HARGA</label>
                                        <input type="number" name="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ old('price', $product->price) }}">

                                        @error('price')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>DISKON (%)</label>
                                        <input type="number" name="discount"
                                            class="form-control @error('discount') is-invalid @enderror"
                                            value="{{ old('discount', $product->discount) }}"
                                            placeholder="Diskon Produk (%)">

                                        @error('discount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                                SIMPAN</button>
                            <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i>
                                RESET</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="//cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        var editor_config = {
            selector: "textarea.content",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
        };

        tinymce.init(editor_config);
    </script>
@endsection
