@extends('layouts.auth', [
'title' => 'Update Password'
])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-md-6 col-lg-4">
                <div class="img-logo text-center mt-5">
                    <img src="{{ asset('assets/img/company.png') }}" style=" width: 80px;">
                </div>
                <div class="card border-0 shadow-lg mb-3 mt-5">
                    <div class="card-body p-4">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h5 class="text-center text-gray-900 mb-3">UPDATE PASSWORD</h5>
                        <form action="{{ route('password.update') }}" method="post">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="form-group">
                                <label class=" font-weight-bold text-uppercase">Email Address</label>
                                <input type="email" name="email" id="email"
                                    class=" form-control @error('email') is-invalid @enderror"
                                    value="{{ $request->email ?? old('email') }}" autocomplete="email" autofocus
                                    placeholder="Masukan Alamat Email">
                                @error('email')
                                    <div class="alert alert-danger mt-2">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class=" font-weight-bold text-uppercase">Password</label>
                                <input type="password" name="password" id="password"
                                    class=" form-control @error('password') is-invalid @enderror"
                                    autocomplete="new-password" autofocus placeholder="Masukan password baru">
                                @error('password')
                                    <div class="alert alert-danger mt-2">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class=" font-weight-bold text-uppercase">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password-confirm"
                                    class=" form-control" placeholder="Konfirmasi password baru">
                            </div>
                            <button type="submit" class=" btn btn-primary mt-4 btn-block text-uppercase">Update
                                Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center text-white">
            <label><a href="/login" class="text-dark">Kembali ke Login</a></label>
        </div>
    </div>
@endsection
