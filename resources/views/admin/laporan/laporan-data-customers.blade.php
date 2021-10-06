<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Customers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="laporan">
        <h4 class=" text-center">Laporan Data Customers</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Customer</th>
                    <th>Email</th>
                    <th>Tanggal Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ dateID($item->created_at) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer mt-5 text-right">
            <div class="text-header">Mengetahui</div>
            <br> <br> <br>
            <div class="text-header ">Manager Toko</div>
            <span style=" font-size: 12px;">dicetak tanggal
                {{ dateID(Carbon\Carbon::now()->toDateTimeString()) }}</span>
        </div>
    </div>
</body>

</html>
