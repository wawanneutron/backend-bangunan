<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<style>
    .footer-report {
        position: absolute;
        bottom: 0;
        right: 30px;
    }

</style>

<body>
    <div class="laporan">
        <h4 class=" text-center">Laporan Data Pembelian</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Nama Customer</th>
                    <th>Tanggal Pembelian</th>
                    <th>Total Pembelian</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->invoice }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ dateID($item->created_at) }}</td>
                        <td>{{ moneyFormat($item->grand_total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class=" text-right"><i>*total semua pendapatan adalah</i> {{ moneyFormat($grandTotal) }}</div>
        <div class="footer-report mt-5 text-right">
            <div class="text-header">Mengetahui</div>
            <br> <br> <br>
            <div class="sub">
                <div class="text-header ">Manager Toko</div>
                <span style=" font-size: 12px;">dicetak tanggal
                    {{ dateID(Carbon\Carbon::now()->toDateTimeString()) }}</span>
            </div>
        </div>
    </div>
</body>

</html>
