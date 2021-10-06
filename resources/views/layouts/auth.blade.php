<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo_toko_title.svg') }}" type="image/x-icon">
    <title>{{ $title ?? config('app.name') }} - Admin</title>

    @include('includes.admin-style')
</head>

<body style="background-color: #fff;">

    @yield('content')

    {{-- script --}}
    @include('includes.admin-script')
</body>

</html>
