<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="laporan">
        <h4 class=" text-center">Laporan Data Barang</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th>Stock Barang</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ moneyFormat($item->price) }}</td>
                        <td>{{ stockFormat($item->stock) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer mt-5 text-right">
            <div class="text-header">Mengetahui</div>
                <img src="{{ public_path('/assets/img/ttd.png') }}" width="90" alt="">
            <div class="text-header ">Admin</div>
            <span style=" font-size: 12px;">dicetak tanggal
                {{ Carbon\Carbon::now()->format('d, F Y - H:i:s') }}</span>
        </div>
    </div>
</body>

</html>
