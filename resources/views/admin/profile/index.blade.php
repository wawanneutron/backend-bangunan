@extends('layouts.app-dashboard',[
    'title' => 'Your Profile'
])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            @if (session('status') == 'profile-information-updated')
                                <p>Profile has been updated.</p>
                            @endif
                            @if (session('status') == 'password-updated')
                                <p>password has been updated.</p>
                            @endif
                            @if (session('status') == 'two-factor-authentication-disabled')
                                <p>Two factor authentication disabled.</p>
                            @endif
                            @if (session('status') == 'two-factor-authentication-enabled')
                                <p>Two factor authentication enabled.</p>
                            @endif
                            @if (session('status') == 'recovery-codes-generated')
                                <p>Recovery codes generated.</p>
                            @endif
                        </div>
                    </div>
                @endif
                
            </div>
        </div>

        <div class="row">
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                <div class="col-md-5 mb-5">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-uppercase"><i class="fas fa-key mr-3"></i>two-factor authentication</h6>
                        </div>
                        <div class="card-body">
                            @if (! auth()->user()->two_factor_secret)
                                {{-- Enable 2FA --}}
                                <form action="{{ url('user/two-factor-authentication') }}" method="post">
                                    @csrf
                                    <button type="submit" class=" btn btn-primary text-uppercase">enable two-factor</button>
                                </form>
                            @else
                                {{-- Disable 2FA --}}
                                <form action="{{ url('user/two-factor-authentication') }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class=" btn btn-danger mb-3 text-uppercase">disable two-factor</button>
                                </form>
                                @if (session('status') == 'two-factor-authentication-enabled')
                                    {{-- Show SVG QR Code, After Enabling 2FA --}}
                                    <p>
                                        Otentikasi dua faktor sekarang diaktifkan.
                                        Pindai kode QR berikut menggunakan aplikasi pengautentikasi ponsel Anda.
                                    </p>
                                    <div class="mb-3">
                                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                    </div>
                                @endif
                                    {{-- Show 2FA Recovery Codes --}}
                                    <p>
                                        Simpan recovery code ini  dengan aman. 
                                        Ini dapat digunakan untuk memulihkan akses ke akun Anda jika perangkat otentikasi dua faktor Anda hilang.
                                    </p>
                                <div style="background: rgb(44, 44, 44);color:white" class=" rounded p-3 mb-2">
                                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                        <div>{{ $code }}</div>
                                    @endforeach
                                </div>
                                {{-- Regenerate 2FA Recovery Codes --}}
                                <form action="{{ url('user/two-factor-recovery-codes') }}" method="post">
                                    @csrf
                                    <button type="submit" class=" btn btn-dark text-uppercase">regenerate recovery codes</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-7">
                <div class="card border-0 shadow">
                    <div class="card-header m-0 font-weight-bold text-uppercase"><i class="fas fa-user-circle mr-3"></i>edit profile</div>
                    <div class="card-body">
                        <form action="{{ route('user-profile-information.update') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class=" form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? auth()->user()->name }}" autofocus autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback ">
                                        <h6 class=" alert alert-danger">{{ $message }}</h6>
                                    </div>
                                @enderror
                            </div>
                             <div class="form-group">
                                <label for="email">email</label>
                                <input type="email" name="email" id="email" class=" form-control @error('email') is-invalid @enderror" value="{{ old('email') ?? auth()->user()->email }}" autofocus>
                                @error('email')
                                    <div class="invalid-feedback ">
                                        <h6 class=" alert alert-danger">{{ $message }}</h6>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class=" btn btn-primary text-uppercase">update profile</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card border-0 shadow mt-4 mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-uppercase"><i class="fas fa-unlock mr-3"></i>update password</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user-password.update') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class=" form-control @error('current_password') is-invalid @enderror" autocomplete="current-password">
                                @error('current_password')
                                    <div class="invalid-feedback ">
                                        <h6 class=" alert alert-danger">{{ $message }}</h6>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pass">Password</label>
                                <input type="password" name="password" id="pass" class=" form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <h6 class=" alert alert-danger">{{ $message }}</h6>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="confirm">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="confirm" class=" form-control  @error('password_confirmation') is-invalid @enderror" autocomplete="new-password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        <h6 class=" alert alert-danger">{{ $message }}</h6>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary text-uppercase" type="submit">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection