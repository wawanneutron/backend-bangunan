@extends('layouts.auth', [
    'title' => 'Forgot Password'
])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="img-logo text-center mt-5">
                    <img src="{{ asset('assets/img/company.png') }}"
                        style="width: 80px;">
                </div>
                <div class="card o-hidden border-0 shadow-lg mb-3 mt-5">
                    <div class="card-body p-4">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="text-center">
                            <h1 class="h5 text-uppercase text-gray-900 mb-4">confirm password</h1>
                        </div>
                        <form action="{{ route('password.confirm') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class=" form-control" placeholder="Masukan password anda">
                            </div>
                            <div class="form-group">
                                <button type="submit" class=" btn btn-primary btn-lg btn-block  text-uppercase">Confirm password</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center">
                    <label><a href="/forgot-password">Lupa password ?</a></label>
                </div>
            </div>
        </div>
    </div>
@endsection