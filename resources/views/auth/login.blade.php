@extends('layouts.auth', ['title' => 'Login'])

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-login navbar-expand navbar-dark bg-white fixed-top">
        <div class="container-fluid">
            <div class="ml-auto mr-auto mr-sm-auto mr-lg-0 mr-md-auto">
                <a class="navbar-brand page-scroll" href="#">
                    <img src="{{ url('assets/img/chackra.jpg') }}" width="60" alt="" />
                </a>
            </div>
            <ul class="navbar-nav mr-auto d-none d-sm-block d-lg-block">
                <li>
                    <span class="text-muted"> | &nbsp; PT. CHAKRA GAHANA GEMILANG</span>
                </li>
            </ul>
        </div>
    </nav>

    <main class="login-container">
        <div class="container">
            <div class="row page-login d-flex align-items-center">
                <div class="section-left col-12 col-md-6">
                    <h1 class="mb-4" style=" font-size: 28px;">
                        Hii Admin yuk kelola dengan mudah<br />
                        data penjualan mu
                    </h1>
                    <img src="{{ url('assets/img/login_img.png') }}" alt="" class="w-75 d-none d-sm-flex" />
                </div>
                <div class="section-right col-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ url('assets/img/chackra.jpg') }}" width="40" alt="">
                            </div>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="inputEmail">Email address</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror" required
                                        placeholder="Masukkan Alamat Email">
                                    @error('email')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword">Password</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Masukkan Password">
                                    @error('password')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe" />
                                    <label for="rememberMe" class="form-check-label">Remember Me</label>
                                </div>
                                <button type="submit" class="btn btn-login btn-block">
                                    Sign In
                                </button>
                                <p class="text-center mt-4">
                                    <a href="/forgot-password">I forgot the password</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
