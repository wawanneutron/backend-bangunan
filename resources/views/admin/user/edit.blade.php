@extends('layouts.app-dashboard', ['title' => 'edit user'])
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class=" m-0 text-uppercase font-weight-bold"><i class="fas fa-user-circle mr-3"></i>Edit User</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap</label>
                                        <input type="text" name="name" id="name" 
                                            class=" form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name) }}"
                                            placeholder="Masukan nama lengkap anda">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <h6 class=" alert alert-danger">{{ $message }}</h6>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Alamat Email</label>
                                        <input type="email" name="email" id="email" class=" form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="Masukan email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                <h6 class=" alert alert-danger">{{ $message }}</h6>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class=" form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Masukan password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <h6 class=" alert alert-danger">{{ $message }}</h6>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Konfirmasi password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class=" form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" placeholder="masukan konfirmasi password">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                <h6 class=" alert alert-danger">{{ $message }}</h6>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class=" btn btn-primary mr-2"><i class="fa fa-paper-plane mr-2"></i>Simpan</button>
                            <button type="reset" class=" btn btn-warning"><i class="fa fa-redo mr-2"></i>Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection